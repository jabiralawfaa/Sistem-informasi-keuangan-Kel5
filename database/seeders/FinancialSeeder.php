<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Receipt;
use App\Models\CashBalance;
use App\Models\Report;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class FinancialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user bendahara yang sudah dibuat oleh RoleSeeder
        $bendahara = User::where('email', 'bendahara@example.com')->first();
        $auditor = User::where('email', 'auditor@example.com')->first();

        // 1. Buat Kategori Pemasukan dan Pengeluaran
        $now = now();
        $categories = [
            ['name' => 'Iuran Kas', 'type' => 'pemasukan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sumbangan', 'type' => 'pemasukan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Laba Usaha', 'type' => 'pemasukan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Konsumsi Rapat', 'type' => 'pengeluaran', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Alat Tulis Kantor', 'type' => 'pengeluaran', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Biaya Transportasi', 'type' => 'pengeluaran', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Perlengkapan Acara', 'type' => 'pengeluaran', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('categories')->insert($categories);

        // 2. Buat Transaksi
        $iuranKas = Category::where('name', 'Iuran Kas')->first();
        $konsumsiRapat = Category::where('name', 'Konsumsi Rapat')->first();
        $sumbangan = Category::where('name', 'Sumbangan')->first();
        $atk = Category::where('name', 'Alat Tulis Kantor')->first();

        $transactions = [
            [
                'user_id' => $bendahara->id,
                'category_id' => $iuranKas->id,
                'amount' => 500000,
                'description' => 'Iuran kas mingguan anggota',
                'transaction_date' => now()->subDays(10),
            ],
            [
                'user_id' => $bendahara->id,
                'category_id' => $konsumsiRapat->id,
                'amount' => -75000,
                'description' => 'Beli snack untuk rapat mingguan',
                'transaction_date' => now()->subDays(8),
            ],
            [
                'user_id' => $bendahara->id,
                'category_id' => $sumbangan->id,
                'amount' => 250000,
                'description' => 'Sumbangan dari donatur',
                'transaction_date' => now()->subDays(5),
            ],
            [
                'user_id' => $bendahara->id,
                'category_id' => $atk->id,
                'amount' => -50000,
                'description' => 'Pembelian kertas dan pulpen',
                'transaction_date' => now()->subDays(2),
            ],
        ];

        foreach ($transactions as $trans) {
            $transaction = Transaction::create($trans);

            // 3. Buat Bukti Transaksi (Receipts) untuk setiap transaksi
            Receipt::create([
                'transaction_id' => $transaction->id,
                'receipt_image_path' => 'path/to/dummy/receipt-' . $transaction->id . '.jpg', // Path gambar dummy
            ]);
        }

        // 4. Inisialisasi atau Update Saldo Kas (CashBalance)
        $totalBalance = Transaction::sum('amount');
        CashBalance::updateOrCreate(
            ['id' => 1], // Asumsi hanya ada satu baris untuk saldo kas
            [
                'balance' => $totalBalance,
                'last_updated' => now(),
            ]
        );

        // 5. Buat Laporan (Report)
        if ($auditor) {
            Report::create([
                'generated_by' => $auditor->id,
                'report_data' => json_encode([
                    'start_date' => now()->subMonth()->startOfMonth(),
                    'end_date' => now()->subMonth()->endOfMonth(),
                    'total_income' => 800000,
                    'total_expense' => -200000,
                    'final_balance' => 600000,
                    'summary' => 'Laporan keuangan bulan lalu.',
                ]),
            ]);
        }
    }
}