<?php
namespace App\Http\Controllers;

use App\Models\Oferta;
use App\Models\Despesa;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FinanceiroController extends Controller
{
    public function index()
    {
        $mes   = request('mes',  Carbon::now()->month);
        $ano   = request('ano',  Carbon::now()->year);

        $totalReceitas = Oferta::whereHas('evento', fn($q) =>
            $q->whereMonth('data', $mes)->whereYear('data', $ano)
        )->sum('valor_total');

        $totalDespesas = Despesa::whereMonth('data', $mes)->whereYear('data', $ano)->sum('valor');
        $saldo = $totalReceitas - $totalDespesas;

        /* Gráfico mensal últimos 6 meses */
        $grafico = [];
        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $rec  = Oferta::whereHas('evento', fn($q) =>
                $q->whereMonth('data', $data->month)->whereYear('data', $data->year)
            )->sum('valor_total');
            $desp = Despesa::whereMonth('data', $data->month)->whereYear('data', $data->year)->sum('valor');
            $grafico[] = [
                'mes'      => $data->translatedFormat('M/y'),
                'receitas' => round($rec),
                'despesas' => round($desp),
            ];
        }

        $maiorDespesas = Despesa::whereMonth('data', $mes)->whereYear('data', $ano)
            ->orderByDesc('valor')->take(5)->get();

        return view('pages.financeiro.index', compact(
            'totalReceitas','totalDespesas','saldo','grafico','maiorDespesas','mes','ano'
        ));
    }

    public function ofertas(Request $request)
    {
        $mes = $request->mes ?? Carbon::now()->month;
        $ano = $request->ano ?? Carbon::now()->year;

        $ofertas = Oferta::with('evento')
            ->whereHas('evento', fn($q) => $q->whereMonth('data', $mes)->whereYear('data', $ano))
            ->latest()->paginate(20)->withQueryString();

        $totalMes = Oferta::whereHas('evento', fn($q) =>
            $q->whereMonth('data', $mes)->whereYear('data', $ano)
        )->sum('valor_total');

        return view('pages.financeiro.ofertas', compact('ofertas', 'totalMes', 'mes', 'ano'));
    }

    public function despesas(Request $request)
    {
        $mes = $request->mes ?? Carbon::now()->month;
        $ano = $request->ano ?? Carbon::now()->year;

        $despesas = Despesa::whereMonth('data', $mes)->whereYear('data', $ano)
            ->latest('data')->paginate(20)->withQueryString();

        $totalMes = Despesa::whereMonth('data', $mes)->whereYear('data', $ano)->sum('valor');

        return view('pages.financeiro.despesas', compact('despesas', 'totalMes', 'mes', 'ano'));
    }

    public function storeDespesa(Request $request)
    {
        $request->validate([
            'data'      => 'required|date',
            'descricao' => 'required|string|max:255',
            'valor'     => 'required|numeric|min:0',
            'categoria' => 'required|string',
        ]);

        Despesa::create([
            'data'           => $request->data,
            'descricao'      => $request->descricao,
            'categoria'      => $request->categoria,
            'valor'          => $request->valor,
            'moeda'          => 'AOA',
            'forma_pagamento'=> $request->forma_pagamento ?? 'dinheiro',
            'observacao'     => $request->observacao,
        ]);

        return redirect()->route('financeiro.despesas')->with('success', 'Despesa lançada!');
    }

    public function updateDespesa(Request $request, Despesa $d)
    {
        $d->update($request->only(['data','descricao','categoria','valor','forma_pagamento','observacao']));
        return redirect()->route('financeiro.despesas')->with('success', 'Despesa actualizada!');
    }

    public function destroyDespesa(Despesa $d)
    {
        $d->delete();
        return redirect()->route('financeiro.despesas')->with('success', 'Despesa eliminada.');
    }
}
