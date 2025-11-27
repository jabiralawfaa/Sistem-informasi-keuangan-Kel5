<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions.
     */
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        $categories = Category::all();
        return view('transactions.create', compact('categories'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
        ]);

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'description' => $request->description,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'date' => $request->date,
        ]);

        return redirect()->route('bendahara.transactions.index')->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        // Ensure user can only view their own transactions
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Transaction $transaction)
    {
        // Ensure user can only edit their own transactions
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Ensure user can only update their own transactions
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
        ]);

        $transaction->update([
            'amount' => $request->amount,
            'description' => $request->description,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'date' => $request->date,
        ]);

        return redirect()->route('bendahara.transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Ensure user can only delete their own transactions
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('bendahara.transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
