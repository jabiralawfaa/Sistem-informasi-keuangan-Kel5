<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuditorDashboardController;
use App\Http\Controllers\BendaharaDashboardController;
use App\Http\Controllers\CashBalanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/users', [App\Http\Controllers\UserRoleController::class, 'index'])->name('users');
        Route::put('/users/{id}/role', [App\Http\Controllers\UserRoleController::class, 'updateRole'])->name('users.update-role');
        Route::get('/users-management', [App\Http\Controllers\UserRoleController::class, 'allUsers'])->name('users.management');

        Route::resource('reports', ReportController::class);
        Route::resource('transactions', TransactionController::class);
        Route::resource('receipts', ReceiptController::class);
        Route::resource('cash-balances', CashBalanceController::class);

        Route::get('/reports/monthly', [ReportController::class, 'generateMonthlyReport'])
            ->name('reports.monthly');
    });
});


// Bendahara routes
Route::middleware(['auth', 'role-check', 'role:bendahara|admin|auditor '])->group(function () {

    // Dashboard Bendahara
    Route::get('/bendahara/dashboard', [App\Http\Controllers\BendaharaDashboardController::class, 'index'])
        ->name('bendahara.dashboard');

    // Transactions (resource)
    Route::prefix('bendahara')->name('bendahara.')->group(function () {
        Route::resource('transactions', TransactionController::class);
        Route::resource('receipts', ReceiptController::class);
        Route::resource('reports', ReportController::class);
        Route::resource('cash-balances', CashBalanceController::class);
        Route::get('/cash-balances/monitor', [CashBalanceController::class, 'monitor'])->name('cash-balances.monitor');
    });

    // Tambahan action custom
    Route::get('/bendahara/reports/monthly', [ReportController::class, 'generateMonthlyReport'])
        ->name('bendahara.reports.monthly');

    Route::get('/bendahara/receipts/{receipt}/print', [ReceiptController::class, 'print'])
        ->name('bendahara.receipts.print');

    Route::post('/bendahara/transactions/{transaction}/receipt', [ReceiptController::class, 'createForTransaction'])
        ->name('bendahara.transactions.receipt');

    Route::get('/receipts/print/{receipt}', [ReceiptController::class, 'print'])
    ->name('receipts.print');
});


// Auditor routes
Route::middleware(['auth', 'role-check', 'role:auditor'])->group(function () {

    Route::get('/auditor/dashboard', [App\Http\Controllers\AuditorDashboardController::class, 'index'])
        ->name('auditor.dashboard');

    Route::get('/auditor/reports/monthly', [ReportController::class, 'generateMonthlyReport'])
        ->name('auditor.reports.monthly');

    Route::resource('/auditor/reports', ReportController::class)
        ->names('auditor.reports');
});

Route::middleware(['auth', 'role-check'])->group(function () {

    Route::resource('/reports', ReportController::class);

    Route::get('/reports/generate/monthly', [ReportController::class, 'generateMonthlyReport'])
        ->name('reports.generateMonthly');

});


Route::middleware(['auth', 'role-check'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Test email route
Route::get('/test-email', function () {
    $details = [
        'title' => 'Test Email from Sistem Informasi Keuangan',
        'body' => 'Ini adalah email percobaan untuk menguji konfigurasi email.'
    ];

    try {
        \Mail::to('jabiralawfaa@gmail.com')->send(new \App\Mail\TestMail($details));
        return "Email sent successfully!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

require __DIR__.'/auth.php';
