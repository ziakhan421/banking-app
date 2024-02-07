<?php

use App\Http\Controllers\Web\AccountController;
use App\Http\Controllers\Web\TransactionController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {

    //dashboard route
    Route::get('/', [AccountController::class, 'index'])->name('dashboard');

    //account routes
    Route::group(["as" => "accounts."], function () {
        //deposit routes
        Route::get('/deposit', [AccountController::class, 'depositCreate'])->name('deposit.create');
        Route::post('/deposit', [AccountController::class, 'depositStore'])->name('deposit.store');

        //withdraw routes
        Route::get('/withdraw', [AccountController::class, 'withdrawCreate'])->name('withdraw.create');
        Route::post('/withdraw', [AccountController::class, 'withdrawStore'])->name('withdraw.store');

        //transfer amount routes
        Route::get('/transfer', [AccountController::class, 'transferCreate'])->name('transfer.create');
        Route::post('/transfer', [AccountController::class, 'transferStore'])->name('transfer.store');
    });

    //dashboard route
    Route::get('/statement', [TransactionController::class, 'index'])->name('statement');

});
