<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect based on user role
        switch ($user->role) {
            case 'admin':
                // For admin dashboard, we need to fetch the data
                $totalUsers = User::count();
                $totalTransactions = Transaction::count();
                $totalIncome = Transaction::where('type', 'income')->sum('amount');
                $totalExpenses = Transaction::where('type', 'expense')->sum('amount');
                $recentTransactions = Transaction::with(['user', 'category'])
                    ->orderBy('created_at', 'desc')
                    ->limit(3)
                    ->get();
                $recentUsers = User::orderBy('created_at', 'desc')
                    ->limit(2)
                    ->get();

                return view('admin.dashboard', compact(
                    'totalUsers',
                    'totalTransactions',
                    'totalIncome',
                    'totalExpenses',
                    'recentTransactions',
                    'recentUsers'
                ));
            case 'bendahara':
                // For bendahara dashboard, fetch specific data
                $totalIncome = Transaction::where('user_id', $user->id)
                    ->where('type', 'income')
                    ->sum('amount');

                $totalExpenses = Transaction::where('user_id', $user->id)
                    ->where('type', 'expense')
                    ->sum('amount');

                $cashBalance = \App\Models\CashBalance::where('user_id', $user->id)
                    ->orderBy('date', 'desc')
                    ->first();

                $calculatedCashBalance = $cashBalance ? $cashBalance->balance : 0;

                $transactionsThisMonth = Transaction::where('user_id', $user->id)
                    ->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year)
                    ->count();

                $recentTransactions = Transaction::where('user_id', $user->id)
                    ->with(['category'])
                    ->orderBy('date', 'desc')
                    ->limit(4)
                    ->get();

                $latestReceipt = \App\Models\Receipt::latest()->first();

                $transactions = Transaction::where('user_id', Auth::id())
                    ->with('category')
                    ->orderBy('date', 'desc')
                    ->paginate(10);

                return view('bendahara.dashboard', compact(
                    'totalIncome',
                    'totalExpenses',
                    'calculatedCashBalance',
                    'transactionsThisMonth',
                    'recentTransactions',
                    'latestReceipt',
                    'transactions'
                ));
            case 'auditor':
                // For auditor dashboard, fetch specific data
                $totalTransactions = Transaction::count();
                $verifiedTransactions = $totalTransactions; // For now, treating all as verified
                $pendingTransactions = 0; // For now, setting to 0
                $monthlyReports = \App\Models\Report::whereYear('created_at', date('Y'))->count();
                $recentReports = \App\Models\Report::orderBy('created_at', 'desc')->limit(4)->get();

                $verificationRate = $totalTransactions > 0 ? 100 : 0; // Since we're treating all as verified

                return view('auditor.dashboard', compact(
                    'totalTransactions',
                    'verifiedTransactions',
                    'pendingTransactions',
                    'monthlyReports',
                    'recentReports',
                    'verificationRate'
                ));
            default:
                // For guest users, fetch limited data
                $totalIncome = 0; // Guest users can't see financial data
                $totalExpenses = 0;
                $calculatedCashBalance = 0;

                $recentTransactions = collect(); // Empty collection for guest users

                return view('dashboard', compact(
                    'totalIncome',
                    'totalExpenses',
                    'calculatedCashBalance',
                    'recentTransactions'
                ));
        }
    }
}
