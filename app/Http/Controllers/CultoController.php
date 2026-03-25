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
        $cultos = Evento::with(['presencaCulto', 'oferta', 'visitantes'])
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
            'data'           => 'required|date',
            'pregador'       => 'required|string|max:150',
            'adultos'        => 'required|integer|min:0',
            'adolescentes'   => 'required|integer|min:0',
            'criancas'       => 'required|integer|min:0',
        ], [
            'data.required'     => 'A data do culto é obrigatória.',
            'pregador.required' => 'O nome do pregador é obrigatório.',
        ]);

        /* 1. Criar evento */
        $evento = Evento::create([
            'data'           => $request->data,
            'tipo_evento'    => 'culto_dominical',
            'horario_inicio' => $request->horario_inicio,
            'horario_fim'    => $request->horario_fim,
            'pregador'       => $request->pregador,
            'tema_culto'     => $request->tema_culto,
            'observacoes'    => $request->observacoes,
        ]);

        /* 2. Presença */
        PresencaCulto::create([
            'evento_id'   => $evento->id,
            'adultos'     => $request->adultos,
            'adolescentes'=> $request->adolescentes,
            'criancas'    => $request->criancas,
        ]);

        /* 3. Visitantes nominais */
        if ($request->has('visitantes')) {
            foreach ($request->visitantes as $v) {
                if (!empty($v['nome'])) {
                    Visitante::create([
                        'evento_id'      => $evento->id,
                        'nome'           => $v['nome'],
                        'telefone'       => $v['telefone'] ?? null,
                        'tipo'           => $v['tipo'] ?? 'adulto',
                        'primeira_visita'=> true,
                        'data_visita'    => $request->data,
                        'bairro'         => $v['bairro'] ?? null,
                        'como_conheceu'  => $v['como_conheceu'] ?? null,
                        'status'         => 'pendente',
                    ]);
                }
            }
        }

        /* 4. Oferta */
        if ($request->filled('valor_dinheiro') || $request->filled('valor_transferencia') || $request->filled('valor_cartao')) {
            Oferta::create([
                'evento_id'          => $evento->id,
                'tipo'               => $request->tipo_oferta ?? 'Oferta de Louvor',
                'valor_dinheiro'     => $request->valor_dinheiro ?? 0,
                'valor_transferencia'=> $request->valor_transferencia ?? 0,
                'valor_cartao'       => $request->valor_cartao ?? 0,
                'moeda'              => 'AOA',
                'observacao'         => $request->observacao_oferta,
            ]);
        }

        return redirect()->route('cultos.show', $evento)
            ->with('success', 'Culto registado com sucesso!');
    }

    public function show(Evento $culto)
    {
        $culto->load(['presencaCulto', 'oferta', 'visitantes', 'ebdRegistro', 'celestialRegistro']);
        return view('pages.culto.show', compact('culto'));
    }

    public function edit(Evento $culto)
    {
        $culto->load(['presencaCulto', 'oferta', 'visitantes']);
        return view('pages.culto.edit', compact('culto'));
    }

    public function update(Request $request, Evento $culto)
    {
        $request->validate([
            'data'     => 'required|date',
            'pregador' => 'required|string|max:150',
        ]);

        $culto->update($request->only(['data','horario_inicio','horario_fim','pregador','tema_culto','observacoes']));

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
