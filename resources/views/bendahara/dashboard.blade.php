@extends('layouts.app')

@section('title', 'Bendahara Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-amber-400 mb-2">Bendahara Dashboard</h1>
            <p class="text-gray-400">Manage financial transactions and cash flow</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Income Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Total Income</p>
                        <p class="text-2xl font-bold text-green-400">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Expenses Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-red-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Total Expenses</p>
                        <p class="text-2xl font-bold text-red-400">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Cash Balance Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-amber-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Cash Balance</p>
                        <p class="text-2xl font-bold text-amber-400">Rp {{ number_format($transactions->where('type', 'income')->sum('amount') - $transactions->where('type', 'expense')->sum('amount'), 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Transactions This Month Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Transactions This Month</p>
                        <p class="text-2xl font-bold text-blue-400">{{ $transactionsThisMonth }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Transactions -->
            <div class="lg:col-span-2 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-amber-400">Recent Transactions</h2>
                    <a href="{{ route('bendahara.transactions.index') }}" class="text-sm text-amber-400 hover:text-amber-300">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="py-3 px-4 text-left text-gray-400">Date</th>
                                <th class="py-3 px-4 text-left text-gray-400">Description</th>
                                <th class="py-3 px-4 text-left text-gray-400">Type</th>
                                <th class="py-3 px-4 text-left text-gray-400">Amount</th>
                                <th class="py-3 px-4 text-left text-gray-400">Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                            <tr class="border-b border-gray-700 hover:bg-gray-750">
                                <td class="py-3 px-4">{{ $transaction->date->format('Y-m-d') }}</td>
                                <td class="py-3 px-4">{{ $transaction->description }}</td>
                                <td class="py-3 px-4">
                                    @if($transaction->type === 'income')
                                        <span class="px-2 py-1 bg-green-900/30 text-green-400 rounded text-xs">Income</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-900/30 text-red-400 rounded text-xs">Expense</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($transaction->type === 'income')
                                        <span class="text-green-400">+Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-red-400">-Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($transaction->receipt_id)
                                        <a href="{{ route('bendahara.receipts.print', $transaction->receipt_id) }}" target="_blank" class="text-green-400 hover:text-green-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5 4v1H4a2 2 0 00-2 2v6a2 2 0 002 2h1v3a2 2 0 002 2h6a2 2 0 002-2v-3h1a2 2 0 002-2V6a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v1h6V4zm0 2H7v1h6V6zm0 2H7v1h6V8zm0 2H7v1h6v-1z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        <form method="POST" action="{{ route('bendahara.transactions.receipt', $transaction->id) }}" class="inline"
                                              onsubmit="return confirm('Generate receipt for this transaction?')">
                                            @csrf
                                            <button type="submit" class="text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">No recent transactions</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <h2 class="text-xl font-bold mb-4 text-amber-400">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('bendahara.transactions.create') }}" class="block w-full text-center px-4 py-3 bg-amber-600 hover:bg-amber-700 rounded-lg transition duration-200 text-white font-medium">
                        Add Transaction
                    </a>
                    @if ($latestReceipt)
                    <a href="{{ route('bendahara.receipts.print', $latestReceipt->id) }}" class="block w-full text-center px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400 font-medium">
                        Print Receipt
                    </a>
                    @else
                    <button disabled class="block w-full text-center px-4 py-3 bg-gray-700 opacity-50 rounded-lg">
                        No Receipt Available
                    </button>
                    @endif
                    <a href="{{ route('bendahara.cash-balances.index') }}" class="block w-full text-center px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400 font-medium">
                        View Cash Flow
                    </a>
                    <a href="{{ route('bendahara.transactions.index') }}" class="block w-full text-center px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400 font-medium">
                        Export Transactions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection