<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Receipt;
use App\Models\CashBalance;
use App\Models\Report;

class FinancialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users with different roles
        $admin = User::factory()->create([
            'name' => 'Admin Keuangan',
            'email' => 'admin@keuangan.com',
            'role' => 'admin',
        ]);
        
        $bendahara = User::factory()->create([
            'name' => 'Bendahara',
            'email' => 'bendahara@keuangan.com',
            'role' => 'bendahara',
        ]);
        
        $auditor = User::factory()->create([
            'name' => 'Auditor',
            'email' => 'auditor@keuangan.com',
            'role' => 'auditor',
        ]);
        
        // Create categories
        $incomeCategory = Category::create([
            'name' => 'Pendapatan Usaha',
            'type' => 'income',
            'description' => 'Pendapatan dari usaha atau penjualan'
        ]);
        
        $expenseCategory = Category::create([
            'name' => 'Biaya Operasional',
            'type' => 'expense',
            'description' => 'Biaya operasional bulanan'
        ]);
        
        // Create receipt
        $receipt = Receipt::create([
            'receipt_number' => 'RCP-001',
            'title' => 'Pembayaran Jasa',
            'description' => 'Pembayaran jasa konsultasi bulan Januari',
            'amount' => 5000000,
            'issued_date' => now()->subDays(5),
            'issued_by' => $bendahara->name,
            'recipient_name' => 'PT. Maju Jaya',
        ]);
        
        // Create transactions
        Transaction::create([
            'user_id' => $bendahara->id,
            'category_id' => $incomeCategory->id,
            'amount' => 10000000,
            'description' => 'Pendapatan dari penjualan produk',
            'type' => 'income',
            'date' => now()->subDays(10),
        ]);
        
        Transaction::create([
            'user_id' => $bendahara->id,
            'category_id' => $expenseCategory->id,
            'amount' => 3000000,
            'description' => 'Pembelian peralatan kantor',
            'type' => 'expense',
            'date' => now()->subDays(8),
        ]);
        
        // Create cash balance
        CashBalance::create([
            'user_id' => $bendahara->id,
            'balance' => 7000000,
            'date' => now(),
            'description' => 'Saldo kas terkini'
        ]);
        
        // Create report
        Report::create([
            'user_id' => $admin->id,
            'title' => 'Laporan Keuangan Bulan Januari',
            'type' => 'monthly',
            'period_start' => now()->startOfMonth(),
            'period_end' => now()->endOfMonth(),
            'total_income' => 10000000,
            'total_expenses' => 3000000,
            'net_income' => 7000000,
            'content' => 'Laporan keuangan bulan Januari menunjukkan pendapatan sebesar 10 juta dan pengeluaran 3 juta, dengan laba bersih sebesar 7 juta.',
        ]);
    }
}
