<?php
namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Oferta;
use App\Models\Despesa;
use App\Models\Visitante;
use App\Models\TurmaDoutrinaria;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RelatorioController extends Controller
{
    public function index()
    {
        $cultos = Evento::with('presencaCulto')
            ->where('tipo_evento','culto_dominical')
            ->latest('data')->take(20)->get();

        return view('pages.relatorios.index', compact('cultos'));
    }

    public function dominical(Evento $culto)
    {
        $culto->load([
            'presencaCulto','ofertas','visitantes',
            'ebdRegistro','celestialRegistro',
        ]);

        $turmaActiva = TurmaDoutrinaria::with([
            'candidatos' => fn($q) => $q->where('status','ativo'),
        ])->where('ativa',true)->first();

        return view('pages.relatorios.dominical', compact('culto','turmaActiva'));
    }

    public function mensal(Request $request)
    {
        $mes = $request->mes ?? Carbon::now()->month;
        $ano = $request->ano ?? Carbon::now()->year;

        $cultos = Evento::with(['presencaCulto','ofertas'])
            ->where('tipo_evento','culto_dominical')
            ->whereMonth('data',$mes)->whereYear('data',$ano)
            ->orderBy('data')->get();

        $totalVisitantes = Visitante::whereMonth('data_visita',$mes)
            ->whereYear('data_visita',$ano)->count();

        $totalOfertas = Oferta::whereHas('evento', fn($q) =>
            $q->whereMonth('data',$mes)->whereYear('data',$ano)
        )->sum('valor_total');

        $totalDespesas = Despesa::whereMonth('data',$mes)
            ->whereYear('data',$ano)->sum('valor');

        $presencaMedia = $cultos->avg(fn($c) => $c->presencaCulto?->total ?? 0);

        $turmaActiva = TurmaDoutrinaria::with('candidatos')
            ->where('ativa',true)->first();

        return view('pages.relatorios.mensal', compact(
            'cultos','totalVisitantes','totalOfertas','totalDespesas',
            'presencaMedia','turmaActiva','mes','ano'
        ));
    }

    public function dominicalPdf(Evento $culto)
    {
        // Requer: composer require barryvdh/laravel-dompdf
        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return redirect()->route('relatorios.dominical', $culto)
                ->with('error', 'Para exportar PDF instale: composer require barryvdh/laravel-dompdf');
        }

        $culto->load(['presencaCulto','ofertas','visitantes','ebdRegistro','celestialRegistro']);
        $turmaActiva = TurmaDoutrinaria::where('ativa',true)->first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'pages.relatorios.dominical_pdf',
            compact('culto','turmaActiva')
        )->setPaper('a4','portrait');

        return $pdf->download("relatorio-dominical-{$culto->data->format('Y-m-d')}.pdf");
    }

    public function mensalPdf(Request $request)
    {
        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return redirect()->route('relatorios.mensal')
                ->with('error', 'Para exportar PDF instale: composer require barryvdh/laravel-dompdf');
        }

        $mes = $request->mes ?? Carbon::now()->month;
        $ano = $request->ano ?? Carbon::now()->year;

        $cultos = Evento::with(['presencaCulto','ofertas'])
            ->where('tipo_evento','culto_dominical')
            ->whereMonth('data',$mes)->whereYear('data',$ano)->get();

        $totalOfertas  = Oferta::whereHas('evento', fn($q) =>
            $q->whereMonth('data',$mes)->whereYear('data',$ano)
        )->sum('valor_total');

        $totalDespesas = Despesa::whereMonth('data',$mes)
            ->whereYear('data',$ano)->sum('valor');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'pages.relatorios.mensal_pdf',
            compact('cultos','totalOfertas','totalDespesas','mes','ano')
        )->setPaper('a4','portrait');

        return $pdf->download("relatorio-mensal-{$ano}-{$mes}.pdf");
    }
}
