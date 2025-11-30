<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Receipt;
use App\Models\CashBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;



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

        return view('bendahara.dashboard', compact(
            'totalIncome',
            'totalExpenses',
            'calculatedCashBalance',
            'transactionsThisMonth',
            'recentTransactions',
            'latestReceipt'
        ));
    }

    public function cashFlow(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());

        $query = Transaction::where('user_id', Auth::id())
            ->whereBetween('date', [$startDate, $endDate]);

        $transactions = $query->with('category')->orderBy('date', 'desc')->paginate(15);

        $totalIncome = (clone $query)->where('type', 'income')->sum('amount');
        $totalExpenses = (clone $query)->where('type', 'expense')->sum('amount');
        $netCashFlow = $totalIncome - $totalExpenses;

        // Prepare data for the chart
        $period = CarbonPeriod::create($startDate, '1 day', $endDate);
        $labels = [];
        $incomeData = [];
        $expensesData = [];

        foreach ($period as $date) {
            $labels[] = $date->format('d M');
            $incomeData[] = (clone $query)->where('type', 'income')->whereDate('date', $date)->sum('amount');
            $expensesData[] = (clone $query)->where('type', 'expense')->whereDate('date', $date)->sum('amount');
        }

        $chartData = [
            'labels' => $labels,
            'income' => $incomeData,
            'expenses' => $expensesData,
        ];

        return view('bendahara.cashflow', compact(
            'transactions',
            'totalIncome',
            'totalExpenses',
            'netCashFlow',
            'chartData'
        ));
    }
}