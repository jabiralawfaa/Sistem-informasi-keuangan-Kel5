<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Receipt;
use App\Models\CashBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BendaharaDashboardController extends Controller
{
    public function index()
    {
        // Total income for the authenticated user
        $totalIncome = Transaction::where('user_id', Auth::id())
            ->where('type', 'income')
            ->sum('amount');
        
        // Total expenses for the authenticated user
        $totalExpenses = Transaction::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->sum('amount');
        
        // Cash balance (from cash_balances table or calculated)
        $cashBalance = CashBalance::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->first();
        
        $calculatedCashBalance = $cashBalance ? $cashBalance->balance : 0;
        
        // Transactions this month
        $transactionsThisMonth = Transaction::where('user_id', Auth::id())
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();
        
        // Recent transactions for the authenticated user
        $recentTransactions = Transaction::where('user_id', Auth::id())
            ->with(['category'])
            ->orderBy('date', 'desc')
            ->limit(4)
            ->get();
        
        // Latest receipt
        $latestReceipt = Receipt::latest()->first();

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
    }
}