<?php

use App\Http\Controllers\AtestadoController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistroPontoController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/dashboard', function () {
    $funcionario = Auth::user()->funcionario;
    if ($funcionario && $funcionario->isGestor()) {
        return redirect()->route('gestor.dashboard');
    }
    if ($funcionario) {
        return redirect()->route('ponto.index');
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('funcionarios', FuncionarioController::class)->middleware('gestor');

    Route::middleware('funcionario')->group(function () {
        Route::get('/ponto', [RegistroPontoController::class, 'index'])->name('ponto.index');
        Route::post('/ponto/entrada', [RegistroPontoController::class, 'registrarEntrada'])->name('ponto.entrada');
        Route::post('/ponto/saida-almoco', [RegistroPontoController::class, 'registrarSaidaAlmoco'])->name('ponto.saida-almoco');
        Route::post('/ponto/volta-almoco', [RegistroPontoController::class, 'registrarVoltaAlmoco'])->name('ponto.volta-almoco');
        Route::post('/ponto/saida', [RegistroPontoController::class, 'registrarSaida'])->name('ponto.saida');
    });

    Route::get('/gestor/dashboard', [RegistroPontoController::class, 'dashboardGestor'])
        ->middleware('gestor')
        ->name('gestor.dashboard');

    Route::get('/gestor/exportar-csv', [RegistroPontoController::class, 'exportarCsv'])
        ->middleware('gestor')
        ->name('gestor.exportar-csv');

    // Atestados
    Route::resource('atestados', AtestadoController::class)->except(['edit', 'update']);
    Route::post('atestados/{atestado}/aprovar',  [AtestadoController::class, 'aprovar'])->name('atestados.aprovar');
    Route::post('atestados/{atestado}/reprovar', [AtestadoController::class, 'reprovar'])->name('atestados.reprovar');

    // Completar perfil apos registro
    Route::get('/completar-perfil', [FuncionarioController::class, 'completarPerfil'])->name('perfil.completar');
    Route::post('/completar-perfil', [FuncionarioController::class, 'salvarPerfil'])->name('perfil.salvar');

    // Calendario
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
    Route::get('/calendario/eventos', [CalendarioController::class, 'eventos'])->name('calendario.eventos');
    Route::post('/calendario', [CalendarioController::class, 'store'])->name('calendario.store');
    Route::delete('/calendario/{evento}', [CalendarioController::class, 'destroy'])->name('calendario.destroy');
});

require __DIR__.'/auth.php';