<?php

use App\Http\Controllers\CashBalanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
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
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/users', function () {
        return view('admin.users');
    })->name('admin.users');

    Route::resource('/admin/reports', ReportController::class)->names('admin.reports');
    Route::get('/admin/reports/monthly', [ReportController::class, 'generateMonthlyReport'])->name('admin.reports.monthly');
});

// Bendahara routes
Route::middleware(['auth', 'role:bendahara'])->group(function () {
    Route::get('/bendahara/dashboard', function () {
        return view('bendahara.dashboard');
    })->name('bendahara.dashboard');

    Route::resource('/bendahara/transactions', TransactionController::class)->names('bendahara.transactions');
    Route::prefix('bendahara')->name('bendahara.')->group(function () {
        Route::resource('transactions', TransactionController::class);
    });


    Route::resource('/transactions/index', TransactionController::class)->names('transactions.index');
    Route::get('/transactions/index', [TransactionController::class, 'index'])->name('transactions.index');

    Route::resource('/transactions/create', TransactionController::class)->names('transactions.create');
    Route::get('/transactions/create', [TransactionController::class, 'index'])->name('transactions.create');

    Route::resource('/receipts/print', ReceiptController::class)->names('receipts.print');
    Route::get('/receipts/print', [ReceiptController::class, 'print'])->name('receipts.print');

    Route::resource('/bendahara/reports', ReportController::class)->names('bendahara.reports');
    Route::get('/bendahara/reports/monthly', [ReportController::class, 'generateMonthlyReport'])->name('bendahara.reports.monthly');

    Route::resource('/bendahara/receipts', ReceiptController::class);
    Route::get('/bendahara/receipts/{receipt}/print', [ReceiptController::class, 'print'])->name('bendahara.receipts.print');
    Route::post('/bendahara/transactions/{transaction}/receipt', [ReceiptController::class, 'createForTransaction'])->name('bendahara.transactions.receipt');

    Route::resource('/bendahara/cash-balances', CashBalanceController::class);
    Route::get('/bendahara/cash-balances/monitor', [CashBalanceController::class, 'monitor'])->name('cash_balances.monitor');
});

// Auditor routes
Route::middleware(['auth', 'role:auditor'])->group(function () {
    Route::get('/auditor/dashboard', function () {
        return view('auditor.dashboard');
    })->name('auditor.dashboard');

    Route::resource('/auditor/reports', ReportController::class)->names('auditor.reports');
    Route::get('/auditor/reports/monthly', [ReportController::class, 'generateMonthlyReport'])->name('auditor.reports.monthly');
});

Route::middleware('auth')->group(function () {
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
