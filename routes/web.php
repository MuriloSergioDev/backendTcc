<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controle\ProfessorController;
use App\Http\Controllers\Controle\HorarioController;
use App\Http\Controllers\Controle\AgendamentoController;
use App\Http\Controllers\Controle\BlocoController;
use App\Http\Controllers\Controle\DashboardController;
use App\Http\Controllers\Controle\FeriadoController;
use App\Http\Controllers\Controle\HomologacaoController;
use App\Http\Controllers\Controle\SalaController;
use App\Http\Controllers\Controle\TipoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('site.index.index');
// });
Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect('/controle/dashboard/index');
})->name('dashboard');


Route::group([
    'prefix'        => 'controle/',
    'middleware'    => ['web', 'auth:sanctum', 'verified'],
    'as'            => 'controle.'
] ,function () {

    /*--------------------------------------------------------------------------
    | Rotas do controle (Exemplo)
    |--------------------------------------------------------------------------*/
    // Route::prefix('empreendimentos')->name('empreendimentos.')->group(function () {
    //     $controller = EmpreendimentoController::class;
    //     Route::get('/', [$controller, 'index'])->middleware('permission:Visualizar empreendimento')->name('index');
    //     Route::get('/create', [$controller, 'create'])->middleware('permission:Cadastrar empreendimento')->name('create');
    //     Route::post('/store', [$controller, 'store'])->middleware('permission:Cadastrar empreendimento')->name('store');
    //     Route::get('/edit/{id}', [$controller, 'edit'])->middleware('permission:Alterar empreendimento')->name('edit');
    //     Route::put('/update/{id}', [$controller, 'update'])->middleware('permission:Alterar empreendimento')->name('update');
    //     Route::delete('/delete', [$controller, 'destroy'])->middleware('permission:Excluir empreendimento')->name('delete');
    // });    
});
