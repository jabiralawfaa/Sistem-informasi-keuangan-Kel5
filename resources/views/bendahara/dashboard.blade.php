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
                        <p class="text-2xl font-bold text-green-400">Rp 18,500,000</p>
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
                        <p class="text-2xl font-bold text-red-400">Rp 8,300,000</p>
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
                        <p class="text-2xl font-bold text-amber-400">Rp 10,200,000</p>
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
                        <p class="text-2xl font-bold text-blue-400">24</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Transactions -->
            <div class="lg:col-span-2 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-amber-400">Recent Transactions</h2>
                    <a href="{{ route('transactions.index') }}" class="text-sm text-amber-400 hover:text-amber-300">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="py-3 px-4 text-left text-gray-400">Date</th>
                                <th class="py-3 px-4 text-left text-gray-400">Description</th>
                                <th class="py-3 px-4 text-left text-gray-400">Type</th>
                                <th class="py-3 px-4 text-left text-gray-400">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-700 hover:bg-gray-750">
                                <td class="py-3 px-4">2025-01-15</td>
                                <td class="py-3 px-4">Office Supplies</td>
                                <td class="py-3 px-4"><span class="px-2 py-1 bg-red-900/30 text-red-400 rounded text-xs">Expense</span></td>
                                <td class="py-3 px-4 text-red-400">Rp 1,200,000</td>
                            </tr>
                            <tr class="border-b border-gray-700 hover:bg-gray-750">
                                <td class="py-3 px-4">2025-01-14</td>
                                <td class="py-3 px-4">Project Payment</td>
                                <td class="py-3 px-4"><span class="px-2 py-1 bg-green-900/30 text-green-400 rounded text-xs">Income</span></td>
                                <td class="py-3 px-4 text-green-400">Rp 5,000,000</td>
                            </tr>
                            <tr class="border-b border-gray-700 hover:bg-gray-750">
                                <td class="py-3 px-4">2025-01-12</td>
                                <td class="py-3 px-4">Utility Bills</td>
                                <td class="py-3 px-4"><span class="px-2 py-1 bg-red-900/30 text-red-400 rounded text-xs">Expense</span></td>
                                <td class="py-3 px-4 text-red-400">Rp 800,000</td>
                            </tr>
                            <tr class="hover:bg-gray-750">
                                <td class="py-3 px-4">2025-01-10</td>
                                <td class="py-3 px-4">Consultation Fee</td>
                                <td class="py-3 px-4"><span class="px-2 py-1 bg-green-900/30 text-green-400 rounded text-xs">Income</span></td>
                                <td class="py-3 px-4 text-green-400">Rp 3,500,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <h2 class="text-xl font-bold mb-4 text-amber-400">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('transactions.create') }}" class="block w-full text-center px-4 py-3 bg-amber-600 hover:bg-amber-700 rounded-lg transition duration-200 text-white font-medium">
                        Add Transaction
                    </a>
                    <a href="{{ route('receipts.print') }}" class="block w-full text-center px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400 font-medium">
                        Print Receipt
                    </a>
                    <a href="#" class="block w-full text-center px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400 font-medium">
                        View Cash Flow
                    </a>
                    <a href="#" class="block w-full text-center px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400 font-medium">
                        Export Transactions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection