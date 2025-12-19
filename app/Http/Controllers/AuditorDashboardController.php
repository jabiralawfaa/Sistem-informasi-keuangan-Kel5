<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditorDashboardController extends Controller
{
    public function index()
    {
        // Total transactions
        $totalTransactions = Transaction::count();

        // Since there's no status column in transactions table, we'll use all transactions
        // In a real application, you might want to add a status column to transactions table
        $verifiedTransactions = $totalTransactions; // For now, treating all as verified
        $pendingTransactions = 0; // For now, setting to 0

        // Monthly reports this year
        $monthlyReports = Report::whereYear('created_at', date('Y'))->count();

        // Recent reports for audit
        $recentReports = Report::orderBy('created_at', 'desc')->limit(4)->get();

        // Calculate verification rate (using a different approach)
        $totalUsers = User::count();

        // Calculate verification rate based on transactions
        if ($totalTransactions > 0) {
            $verificationRate = 100; // Since we're treating all as verified for now
        } else {
            $verificationRate = 0;
        }

        return view('auditor.dashboard', compact(
            'totalTransactions',
            'verifiedTransactions',
            'pendingTransactions',
            'monthlyReports',
            'recentReports',
            'verificationRate'
        ));
    }
}