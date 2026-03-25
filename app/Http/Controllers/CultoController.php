<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\PresencaCulto;
use App\Models\Visitante;
use App\Models\Oferta;
use Illuminate\Http\Request;

class CultoController extends Controller
{
    public function index()
    {
        $cultos = Evento::with(['presencaCulto', 'ofertas', 'visitantes'])
            ->where('tipo_evento', 'culto_dominical')
            ->latest('data')->paginate(15);

        return view('pages.culto.index', compact('cultos'));
    }

    public function create()
    {
        return view('pages.culto.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required|date',
            'pregador' => 'required|string|max:150',
            'adultos' => 'required|integer|min:0',
            'adolescentes' => 'required|integer|min:0',
            'criancas' => 'required|integer|min:0',
            'ofertas' => 'nullable|array',
            'ofertas.*.tipo' => 'required_with:ofertas|string|max:120',
            'ofertas.*.valor_dinheiro' => 'nullable|numeric|min:0',
            'ofertas.*.valor_transferencia' => 'nullable|numeric|min:0',
            'ofertas.*.valor_cartao' => 'nullable|numeric|min:0',
            'ofertas.*.observacao' => 'nullable|string',
        ]);

        $evento = Evento::create([
            'data' => $request->data,
            'tipo_evento' => 'culto_dominical',
            'horario_inicio' => $request->horario_inicio,
            'horario_fim' => $request->horario_fim,
            'pregador' => $request->pregador,
            'tema_culto' => $request->tema_culto,
            'observacoes' => $request->observacoes,
        ]);

        PresencaCulto::create([
            'evento_id' => $evento->id,
            'adultos' => $request->adultos,
            'adolescentes' => $request->adolescentes,
            'criancas' => $request->criancas,
        ]);

        if ($request->has('visitantes')) {
            foreach ($request->visitantes as $v) {
                if (!empty($v['nome'])) {
                    Visitante::create([
                        'evento_id' => $evento->id,
                        'nome' => $v['nome'],
                        'telefone' => $v['telefone'] ?? null,
                        'tipo' => $v['tipo'] ?? 'adulto',
                        'primeira_visita' => true,
                        'data_visita' => $request->data,
                        'bairro' => $v['bairro'] ?? null,
                        'como_conheceu' => $v['como_conheceu'] ?? null,
                        'status' => 'pendente',
                    ]);
                }
            }
        }

        foreach ($request->input('ofertas', []) as $ofertaData) {
            $dinheiro = (float) ($ofertaData['valor_dinheiro'] ?? 0);
            $transferencia = (float) ($ofertaData['valor_transferencia'] ?? 0);
            $cartao = (float) ($ofertaData['valor_cartao'] ?? 0);
            if (($dinheiro + $transferencia + $cartao) <= 0) {
                continue;
            }

            Oferta::create([
                'evento_id' => $evento->id,
                'tipo' => $ofertaData['tipo'],
                'valor_dinheiro' => $dinheiro,
                'valor_transferencia' => $transferencia,
                'valor_cartao' => $cartao,
                'moeda' => 'AOA',
                'observacao' => $ofertaData['observacao'] ?? null,
            ]);
        }

        return redirect()->route('cultos.show', $evento)
            ->with('success', 'Culto registado com sucesso!');
    }

    public function show(Evento $culto)
    {
        $culto->load(['presencaCulto', 'ofertas', 'visitantes', 'ebdRegistro', 'celestialRegistro']);
        return view('pages.culto.show', compact('culto'));
    }

    public function edit(Evento $culto)
    {
        $culto->load(['presencaCulto', 'ofertas', 'visitantes']);
        return view('pages.culto.edit', compact('culto'));
    }

    public function update(Request $request, Evento $culto)
    {
        $request->validate([
            'data' => 'required|date',
            'pregador' => 'required|string|max:150',
        ]);

        $culto->update($request->only(['data', 'horario_inicio', 'horario_fim', 'pregador', 'tema_culto', 'observacoes']));

        $culto->presencaCulto()->updateOrCreate(
            ['evento_id' => $culto->id],
            ['adultos' => $request->adultos, 'adolescentes' => $request->adolescentes, 'criancas' => $request->criancas]
        );

        return redirect()->route('cultos.show', $culto)->with('success', 'Culto actualizado!');
    }

    public function destroy(Evento $culto)
    {
        $culto->delete();
        return redirect()->route('cultos.index')->with('success', 'Registo eliminado.');
    }
}
