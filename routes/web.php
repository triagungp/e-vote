<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\VotingController;

//  VOTER 
Route::get('/login', [LoginController::class, 'showLoginToken'])->name('login');
Route::post('/login', [LoginController::class, 'logintoken']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('tokenauth')->group(function () {
    Route::get('/voting', [VotingController::class, 'index'])->name('voting.index');
    Route::post('/voting/{id}', [VotingController::class, 'vote'])->name('voting.vote');
    Route::get('/vote', fn () => view('voter.index'));
});

//  ADMIN 
Route::get('/admin', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin', [AuthController::class, 'login']);
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('customauth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('candidates', CandidateController::class);
    Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
    Route::resource('elections', ElectionController::class);

    Route::get('/tokens', [TokenController::class, 'index'])->name('tokens.index');
    Route::post('/tokens/generate', [TokenController::class, 'generate'])->name('tokens.generate');
    Route::delete('/tokens/{voter}', [TokenController::class, 'destroy'])->name('tokens.destroy');
});
