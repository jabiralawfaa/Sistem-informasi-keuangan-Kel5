<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Receipt;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total users count
        $totalUsers = User::count();

        // Total transactions count
        $totalTransactions = Transaction::count();

        // Total income amount
        $totalIncome = Transaction::where('type', 'income')->sum('amount');

        // Total expenses amount
        $totalExpenses = Transaction::where('type', 'expense')->sum('amount');

        // Recent transactions for activity log
        $recentTransactions = Transaction::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Count recent users registered
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
    }
}