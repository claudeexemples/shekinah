<?php
namespace App\Http\Controllers;

use App\Models\Visitante;
use Illuminate\Http\Request;

class VisitanteController extends Controller
{
    public function index(Request $request)
    {
        $query = Visitante::query()->latest('data_visita');

        if ($request->filled('status'))
            $query->where('status', $request->status);

        if ($request->filled('busca'))
            $query->where('nome', 'like', '%'.$request->busca.'%');

        $visitantes = $query->paginate(20)->withQueryString();

        $kpis = [
            'total'       => Visitante::count(),
            'pendentes'   => Visitante::where('status', 'pendente')->count(),
            'acompanhados'=> Visitante::where('status', 'acompanhado')->count(),
            'convertidos' => Visitante::where('status', 'convertido')->count(),
        ];

        return view('pages.visitantes.index', compact('visitantes', 'kpis'));
    }

    public function create()
    {
        return view('pages.visitantes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'       => 'required|string|max:200',
            'data_visita'=> 'required|date',
        ], ['nome.required' => 'O nome do visitante é obrigatório.']);

        Visitante::create([
            'nome'           => $request->nome,
            'telefone'       => $request->telefone,
            'email'          => $request->email,
            'idade'          => $request->idade,
            'tipo'           => $request->tipo ?? 'adulto',
            'primeira_visita'=> (bool)$request->primeira_visita,
            'data_visita'    => $request->data_visita,
            'como_conheceu'  => $request->como_conheceu,
            'bairro'         => $request->bairro,
            'municipio'      => $request->municipio,
            'provincia'      => $request->provincia ?? 'Luanda',
            'observacoes'    => $request->observacoes,
            'status'         => 'pendente',
        ]);

        return redirect()->route('visitantes.index')->with('success', 'Visitante cadastrado com sucesso!');
    }

    public function show(Visitante $v)
    {
        return view('pages.visitantes.show', ['visitante' => $v]);
    }

    public function update(Request $request, Visitante $v)
    {
        $v->update($request->only(['nome','telefone','email','tipo','status','bairro','municipio','provincia','observacoes']));
        return redirect()->route('visitantes.index')->with('success', 'Visitante actualizado!');
    }

    public function marcarAcompanhado(Visitante $v)
    {
        $v->update(['status' => 'acompanhado', 'acompanhado' => true]);
        return back()->with('success', 'Visitante marcado como acompanhado!');
    }

    public function destroy(Visitante $v)
    {
        $v->delete();
        return redirect()->route('visitantes.index')->with('success', 'Visitante removido.');
    }
}
