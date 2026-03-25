<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Visitante;
use App\Models\TurmaDoutrinaria;
use App\Models\Oferta;
use App\Models\Despesa;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hoje = Carbon::now();
        $mesAtual = $hoje->month;
        $anoAtual = $hoje->year;

        /* Último culto dominical */
        $ultimoCulto = Evento::with(['presencaCulto', 'ofertas', 'visitantes'])
            ->where('tipo_evento', 'culto_dominical')
            ->latest('data')
            ->first();

        /* KPIs do mês */
        $totalOfertasMes = Oferta::whereHas('evento', function ($q) use ($mesAtual, $anoAtual) {
            $q->whereMonth('data', $mesAtual)->whereYear('data', $anoAtual);
        })->sum('valor_total');

        $totalDespesasMes = Despesa::whereMonth('data', $mesAtual)
            ->whereYear('data', $anoAtual)
            ->sum('valor');

        $saldoMes = $totalOfertasMes - $totalDespesasMes;

        $totalVisitantesMes = Visitante::whereMonth('data_visita', $mesAtual)
            ->whereYear('data_visita', $anoAtual)->count();

        /* Visitantes pendentes */
        $visitantesPendentes = Visitante::where('status', 'pendente')
            ->latest('data_visita')->take(5)->get();

        /* Turma doutrinária activa */
        $turmaActiva = TurmaDoutrinaria::with(['candidatos' => fn($q) => $q->where('status', 'ativo')])
            ->where('ativa', true)->first();

        /* Últimos 6 cultos para o gráfico */
        $ultimosCultos = Evento::with('presencaCulto')
            ->where('tipo_evento', 'culto_dominical')
            ->latest('data')->take(6)->get()->reverse()->values();

        /* Candidatos em risco */
        $candidatosRisco = $turmaActiva
            ? $turmaActiva->candidatos()->where('status','ativo')->where('percentual_presenca','<',75)->get()
            : collect();

        return view('pages.dashboard.index', compact(
            'ultimoCulto', 'totalOfertasMes', 'totalDespesasMes', 'saldoMes',
            'totalVisitantesMes', 'visitantesPendentes', 'turmaActiva',
            'ultimosCultos', 'candidatosRisco'
        ));
    }
}
