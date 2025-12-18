<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\Technician\TicketController as TechnicianTicketController;
use App\Http\Controllers\Auth\LoginController as TechnicianAuthController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tickets/create');

Route::redirect('/login', '/technician/login')->name('login');

/*
|--------------------------------------------------------------------------
| Utilisateur (sans compte)
|--------------------------------------------------------------------------
*/
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/confirmation', [TicketController::class, 'confirmation'])->name('tickets.confirmation');

/*
|--------------------------------------------------------------------------
| Technicien (auth Laravel)
|--------------------------------------------------------------------------
*/
Route::prefix('technician')->name('technician.')->group(function () {
    Route::middleware(['technician.guest'])->group(function () {
        Route::get('/login', [TechnicianAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [TechnicianAuthController::class, 'login'])->name('login.store');
    });

    Route::post('/logout', [TechnicianAuthController::class, 'logout'])
        ->middleware(['technician.auth'])
        ->name('logout');

    Route::middleware(['technician.auth'])->group(function () {
        Route::redirect('/', '/technician/tickets')->name('dashboard');

        Route::get('/tickets', [TechnicianTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [TechnicianTicketController::class, 'show'])->name('tickets.show');

        Route::patch('/tickets/{ticket}/status', [TechnicianTicketController::class, 'updateStatus'])->name('tickets.status.update');
        Route::post('/tickets/{ticket}/comments', [TechnicianTicketController::class, 'storeComment'])->name('tickets.comments.store');
    });
});
