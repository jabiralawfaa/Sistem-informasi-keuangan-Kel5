<?php

namespace App\Http\Controllers;

use App\Models\CashBalance;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CashBalanceController extends Controller
{
    /**
     * Display a listing of cash balances.
     */
    public function index()
    {
        $cashBalances = CashBalance::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(10);

        // Get the latest balance
        $latestBalance = CashBalance::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->first();

        return view('cash_balances.index', compact('cashBalances', 'latestBalance'));
    }

    /**
     * Show the form for creating a new cash balance.
     */
    public function create()
    {
        // Calculate what the balance should be based on transactions
        $transactions = Transaction::where('user_id', Auth::id())
            ->orderBy('date', 'asc')
            ->get();

        $calculatedBalance = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->type === 'income') {
                $calculatedBalance += $transaction->amount;
            } else {
                $calculatedBalance -= $transaction->amount;
            }
        }

        return view('cash_balances.create', compact('calculatedBalance'));
    }

    /**
     * Store a newly created cash balance in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'balance' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $cashBalance = CashBalance::create([
            'user_id' => Auth::id(),
            'balance' => $request->balance,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('cash_balances.index')->with('success', 'Cash balance recorded successfully.');
    }

    /**
     * Display the specified cash balance.
     */
    public function show(CashBalance $cashBalance)
    {
        // Ensure user can only view their own cash balances
        if ($cashBalance->user_id !== Auth::id()) {
            abort(403);
        }

        return view('cash_balances.show', compact('cashBalance'));
    }

    /**
     * Show the form for editing the specified cash balance.
     */
    public function edit(CashBalance $cashBalance)
    {
        // Ensure user can only edit their own cash balances
        if ($cashBalance->user_id !== Auth::id()) {
            abort(403);
        }

        return view('cash_balances.edit', compact('cashBalance'));
    }

    /**
     * Update the specified cash balance in storage.
     */
    public function update(Request $request, CashBalance $cashBalance)
    {
        // Ensure user can only update their own cash balances
        if ($cashBalance->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'balance' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $cashBalance->update([
            'balance' => $request->balance,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('cash_balances.index')->with('success', 'Cash balance updated successfully.');
    }

    /**
     * Remove the specified cash balance from storage.
     */
    public function destroy(CashBalance $cashBalance)
    {
        // Ensure user can only delete their own cash balances
        if ($cashBalance->user_id !== Auth::id()) {
            abort(403);
        }

        $cashBalance->delete();

        return redirect()->route('cash_balances.index')->with('success', 'Cash balance deleted successfully.');
    }

    /**
     * Monitor cash balance changes over time.
     */
    public function monitor()
    {
        $cashBalances = CashBalance::where('user_id', Auth::id())
            ->orderBy('date', 'asc')
            ->limit(10) // Get last 10 records for the chart
            ->get();

        // Calculate summary data
        $latestBalance = CashBalance::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->first();

        $oldestBalance = CashBalance::where('user_id', Auth::id())
            ->orderBy('date', 'asc')
            ->first();

        $balanceChange = null;
        if ($latestBalance && $oldestBalance) {
            $balanceChange = $latestBalance->balance - $oldestBalance->balance;
        }

        return view('cash_balances.monitor', compact('cashBalances', 'latestBalance', 'balanceChange'));
    }

    /**
     * Calculate current cash balance based on all transactions.
     */
    public function calculateCurrentBalance()
    {
        $transactions = Transaction::where('user_id', Auth::id())->get();

        $currentBalance = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->type === 'income') {
                $currentBalance += $transaction->amount;
            } else {
                $currentBalance -= $transaction->amount;
            }
        }

        return $currentBalance;
    }
}
