<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CultoController;
use App\Http\Controllers\EbdController;
use App\Http\Controllers\CelestialController;
use App\Http\Controllers\DoutrinariasController;
use App\Http\Controllers\VisitanteController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\RelatorioController;

/*
|--------------------------------------------------------------------------
| Shekinah — Rotas Web (Angola)
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('dashboard'));

/* ── Dashboard ── */
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/* ── Culto Dominical ── */
Route::prefix('cultos')->name('cultos.')->group(function () {
    Route::get('/',               [CultoController::class, 'index'])->name('index');
    Route::get('/novo',           [CultoController::class, 'create'])->name('create');
    Route::post('/',              [CultoController::class, 'store'])->name('store');
    Route::get('/{culto}',        [CultoController::class, 'show'])->name('show');
    Route::get('/{culto}/editar', [CultoController::class, 'edit'])->name('edit');
    Route::put('/{culto}',        [CultoController::class, 'update'])->name('update');
    Route::delete('/{culto}',     [CultoController::class, 'destroy'])->name('destroy');
});

/* ── EBD ── */
Route::prefix('ebd')->name('ebd.')->group(function () {
    Route::get('/',         [EbdController::class, 'index'])->name('index');
    Route::get('/novo',     [EbdController::class, 'create'])->name('create');
    Route::post('/',        [EbdController::class, 'store'])->name('store');
    Route::get('/{ebd}',    [EbdController::class, 'show'])->name('show');
    Route::put('/{ebd}',    [EbdController::class, 'update'])->name('update');
    Route::delete('/{ebd}', [EbdController::class, 'destroy'])->name('destroy');
});

/* ── Classe Celestial ── */
Route::prefix('celestial')->name('celestial.')->group(function () {
    Route::get('/',        [CelestialController::class, 'index'])->name('index');
    Route::get('/novo',    [CelestialController::class, 'create'])->name('create');
    Route::post('/',       [CelestialController::class, 'store'])->name('store');
    Route::delete('/{reg}',[CelestialController::class, 'destroy'])->name('destroy');
});

/* ── Classe Bíblica Doutrinária ── */
Route::prefix('doutrinaria')->name('doutrinaria.')->group(function () {
    Route::get('/',                          [DoutrinariasController::class, 'index'])->name('index');
    Route::get('/turmas/nova',               [DoutrinariasController::class, 'createTurma'])->name('turmas.create');
    Route::post('/turmas',                   [DoutrinariasController::class, 'storeTurma'])->name('turmas.store');
    Route::get('/candidatos',                [DoutrinariasController::class, 'candidatos'])->name('candidatos');
    Route::post('/candidatos',               [DoutrinariasController::class, 'storeCandidato'])->name('candidatos.store');
    Route::delete('/candidatos/{c}',         [DoutrinariasController::class, 'destroyCandidato'])->name('candidatos.destroy');
    Route::get('/candidatos/{c}/perfil',     [DoutrinariasController::class, 'perfilCandidato'])->name('candidatos.perfil');
    Route::get('/chamada',                   [DoutrinariasController::class, 'chamada'])->name('chamada');
    Route::post('/chamada',                  [DoutrinariasController::class, 'salvarChamada'])->name('chamada.store');
});

/* ── Visitantes ── */
Route::prefix('visitantes')->name('visitantes.')->group(function () {
    Route::get('/',                  [VisitanteController::class, 'index'])->name('index');
    Route::get('/novo',              [VisitanteController::class, 'create'])->name('create');
    Route::post('/',                 [VisitanteController::class, 'store'])->name('store');
    Route::get('/{v}',               [VisitanteController::class, 'show'])->name('show');
    Route::put('/{v}',               [VisitanteController::class, 'update'])->name('update');
    Route::patch('/{v}/acompanhar',  [VisitanteController::class, 'marcarAcompanhado'])->name('acompanhar');
    Route::delete('/{v}',            [VisitanteController::class, 'destroy'])->name('destroy');
});

/* ── Financeiro ── */
Route::prefix('financeiro')->name('financeiro.')->group(function () {
    Route::get('/',                [FinanceiroController::class, 'index'])->name('index');
    Route::get('/ofertas',         [FinanceiroController::class, 'ofertas'])->name('ofertas');
    Route::get('/despesas',        [FinanceiroController::class, 'despesas'])->name('despesas');
    Route::post('/despesas',       [FinanceiroController::class, 'storeDespesa'])->name('despesas.store');
    Route::put('/despesas/{d}',    [FinanceiroController::class, 'updateDespesa'])->name('despesas.update');
    Route::delete('/despesas/{d}', [FinanceiroController::class, 'destroyDespesa'])->name('despesas.destroy');
});

/* ── Relatórios ── */
Route::prefix('relatorios')->name('relatorios.')->group(function () {
    Route::get('/',                         [RelatorioController::class, 'index'])->name('index');
    Route::get('/dominical/{culto}',        [RelatorioController::class, 'dominical'])->name('dominical');
    Route::get('/dominical/{culto}/pdf',    [RelatorioController::class, 'dominicalPdf'])->name('dominical.pdf');
    Route::get('/mensal',                   [RelatorioController::class, 'mensal'])->name('mensal');
    Route::get('/mensal/pdf',               [RelatorioController::class, 'mensalPdf'])->name('mensal.pdf');
});
