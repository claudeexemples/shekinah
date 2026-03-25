<?php

namespace App\Http\Controllers;

use App\Models\TurmaDoutrinaria;
use App\Models\CandidatoBatismo;
use App\Models\PresencaDoutrinaria;
use Illuminate\Http\Request;

class DoutrinariasController extends Controller
{
    public function index()
    {
        $turmaActiva = TurmaDoutrinaria::with([
            'candidatos' => fn($q) => $q->where('status', 'ativo')->orderBy('nome'),
        ])->where('ativa', true)->first();

        $todasTurmas = TurmaDoutrinaria::latest()->get();

        return view('pages.doutrinaria.index', compact('turmaActiva', 'todasTurmas'));
    }

    public function candidatos(Request $request)
    {
        $turmaActiva = TurmaDoutrinaria::where('ativa', true)->first();

        $query = CandidatoBatismo::with('turma')
            ->where('turma_id', $turmaActiva?->id)
            ->orderBy('nome');

        if ($request->filled('busca'))
            $query->where('nome', 'like', '%'.$request->busca.'%');

        $candidatos = $query->paginate(20);

        return view('pages.doutrinaria.candidatos', compact('candidatos', 'turmaActiva'));
    }

    public function storeCandidato(Request $request)
    {
        $request->validate([
            'turma_id'       => 'required|exists:turmas_doutrinaria,id',
            'nome'           => 'required|string|max:200',
            'data_matricula' => 'required|date',
        ]);

        CandidatoBatismo::create([
            'turma_id'       => $request->turma_id,
            'nome'           => $request->nome,
            'telefone'       => $request->telefone,
            'email'          => $request->email,
            'data_nascimento'=> $request->data_nascimento,
            'data_matricula' => $request->data_matricula,
            'is_novo'        => (bool) $request->is_novo,
            'bairro'         => $request->bairro,
            'provincia'      => $request->provincia ?? 'Luanda',
            'status'         => 'ativo',
        ]);

        return redirect()->route('doutrinaria.candidatos')
            ->with('success', 'Candidato inscrito com sucesso!');
    }

    public function destroyCandidato(CandidatoBatismo $c)
    {
        $c->delete();
        return redirect()->route('doutrinaria.candidatos')
            ->with('success', 'Candidato removido.');
    }

    public function chamada()
    {
        $turmaActiva = TurmaDoutrinaria::where('ativa', true)->first();

        if (!$turmaActiva) {
            return redirect()->route('doutrinaria.index')
                ->with('error', 'Nenhuma turma activa encontrada.');
        }

        $candidatos  = CandidatoBatismo::where('turma_id', $turmaActiva->id)
            ->where('status', 'ativo')->orderBy('nome')->get();

        $aulaActual = $turmaActiva->aula_atual + 1;

        return view('pages.doutrinaria.chamada', compact('turmaActiva', 'candidatos', 'aulaActual'));
    }

    public function salvarChamada(Request $request)
    {
        $request->validate([
            'turma_id'    => 'required|exists:turmas_doutrinaria,id',
            'aula_numero' => 'required|integer|min:1',
            'data_aula'   => 'required|date',
        ]);

        $turma     = TurmaDoutrinaria::findOrFail($request->turma_id);
        $presentes = $request->presentes ?? [];

        $candidatos = CandidatoBatismo::where('turma_id', $turma->id)
            ->where('status', 'ativo')->get();

        foreach ($candidatos as $c) {
            PresencaDoutrinaria::updateOrCreate(
                ['candidato_id' => $c->id, 'aula_numero' => $request->aula_numero],
                [
                    'turma_id'  => $turma->id,
                    'data_aula' => $request->data_aula,
                    'presente'  => in_array((string)$c->id, array_map('strval', $presentes)),
                ]
            );
            $c->recalcularPresenca();
        }

        if ($request->aula_numero > $turma->aula_atual) {
            $turma->update(['aula_atual' => $request->aula_numero]);
        }

        return redirect()->route('doutrinaria.index')
            ->with('success', "Chamada da Aula {$request->aula_numero} guardada com sucesso!");
    }

    public function perfilCandidato(CandidatoBatismo $c)
    {
        $c->load(['turma', 'presencas' => fn($q) => $q->orderBy('aula_numero')]);
        $turma = $c->turma;

        return view('pages.doutrinaria.perfil', compact('c', 'turma'));
    }

    public function createTurma()
    {
        return view('pages.doutrinaria.nova_turma');
    }

    public function storeTurma(Request $request)
    {
        $request->validate([
            'nome'       => 'required|string|max:200',
            'professor'  => 'required|string|max:150',
            'data_inicio'=> 'required|date',
        ]);

        TurmaDoutrinaria::where('ativa', true)->update(['ativa' => false]);

        TurmaDoutrinaria::create([
            'nome'                  => $request->nome,
            'professor'             => $request->professor,
            'sala'                  => $request->sala,
            'data_inicio'           => $request->data_inicio,
            'data_fim_prevista'     => $request->data_fim_prevista,
            'total_aulas_previstas' => $request->total_aulas ?? 12,
            'data_batismo_prevista' => $request->data_batismo_prevista,
            'ativa'                 => true,
        ]);

        return redirect()->route('doutrinaria.index')
            ->with('success', 'Nova turma criada e activada!');
    }
}
