@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-amber-400 mb-2">Financial Dashboard</h1>
            <p class="text-gray-400">Welcome back, {{ Auth::user()->name }}. Here's your financial overview.</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Income -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Total Income</p>
                        <p class="text-2xl font-bold text-green-400">Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Expenses -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-red-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Total Expenses</p>
                        <p class="text-2xl font-bold text-red-400">Rp {{ number_format($totalExpenses ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Cash Balance -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-amber-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Cash Balance</p>
                        <p class="text-2xl font-bold text-amber-400">Rp {{ number_format($calculatedCashBalance ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Net Income -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Net Income</p>
                        <p class="text-2xl font-bold text-blue-400">Rp {{ number_format(($totalIncome ?? 0) - ($totalExpenses ?? 0), 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Quick Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Balance Trend Chart -->
            <div class="lg:col-span-2 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <h2 class="text-xl font-bold mb-4 text-amber-400">Balance Trend</h2>
                <div class="h-64 flex items-end space-x-2 justify-center pt-8 pb-4">
                    <!-- Simulated chart data -->
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-gradient-to-t from-green-500 to-green-600 rounded-t-lg h-3/5">
                            <div class="text-center text-xs pt-1 text-white font-bold">12M</div>
                        </div>
                        <div class="text-xs mt-2 text-gray-400">Jan</div>
                    </div>
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-gradient-to-t from-green-500 to-green-600 rounded-t-lg h-2/3">
                            <div class="text-center text-xs pt-1 text-white font-bold">8M</div>
                        </div>
                        <div class="text-xs mt-2 text-gray-400">Feb</div>
                    </div>
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-gradient-to-t from-green-500 to-green-600 rounded-t-lg h-4/5">
                            <div class="text-center text-xs pt-1 text-white font-bold">10M</div>
                        </div>
                        <div class="text-xs mt-2 text-gray-400">Mar</div>
                    </div>
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-gradient-to-t from-green-500 to-green-600 rounded-t-lg h-1/2">
                            <div class="text-center text-xs pt-1 text-white font-bold">6M</div>
                        </div>
                        <div class="text-xs mt-2 text-gray-400">Apr</div>
                    </div>
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-gradient-to-t from-green-500 to-green-600 rounded-t-lg h-3/4">
                            <div class="text-center text-xs pt-1 text-white font-bold">9M</div>
                        </div>
                        <div class="text-xs mt-2 text-gray-400">May</div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <h2 class="text-xl font-bold mb-4 text-amber-400">Quick Stats</h2>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Transactions (30 days)</span>
                        <span class="font-bold text-amber-400">24</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Receipts Generated</span>
                        <span class="font-bold text-amber-400">18</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Reports Generated</span>
                        <span class="font-bold text-amber-400">5</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Active Categories</span>
                        <span class="font-bold text-amber-400">12</span>
                    </div>
                    <div class="pt-4 mt-4 border-t border-gray-700">
                        <span class="text-gray-400">Balance Status</span>
                        <div class="mt-2">
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-amber-500 h-2 rounded-full" style="width: 75%"></div>
                            </div>
                            <div class="text-sm text-gray-400 mt-1">75% of target</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity and Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Activity -->
            <div class="lg:col-span-2 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-amber-400">Recent Activity</h2>
                    <a href="{{ route('bendahara.transactions.index') }}" class="text-sm text-amber-400 hover:text-amber-300">View All</a>
                </div>
                <div class="space-y-4">
                    @forelse($recentTransactions ?? collect() as $transaction)
                    <div class="flex items-start border-b border-gray-700 pb-3">
                        <div class="p-2 rounded-full bg-{{ $transaction->type === 'income' ? 'green' : 'red' }}-900/30 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-{{ $transaction->type === 'income' ? 'green' : 'red' }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                @if($transaction->type === 'income')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                                @endif
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium">{{ $transaction->type === 'income' ? 'New income' : 'New expense' }} transaction added</h3>
                            <p class="text-sm text-gray-400">{{ $transaction->description }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $transaction->date->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-500">
                        No recent transactions
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <h2 class="text-xl font-bold mb-4 text-amber-400">Quick Actions</h2>
                <div class="space-y-3">
                    @if(Auth::user()->role !== 'guest')
                    <a href="{{ route('bendahara.transactions.create') }}" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 rounded-lg transition duration-200 text-white font-medium">
                        Add Transaction
                    </a>
                    <a href="{{ route('bendahara.receipts.create') }}" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-600 hover:to-gray-700 rounded-lg transition duration-200 text-amber-400 font-medium border border-amber-900">
                        Create Receipt
                    </a>
                    <a href="{{ route('bendahara.reports.create') }}" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-600 hover:to-gray-700 rounded-lg transition duration-200 text-amber-400 font-medium border border-amber-900">
                        Generate Report
                    </a>
                    @else
                    <div class="w-full text-center px-4 py-3 bg-gradient-to-r from-amber-600 to-amber-700 rounded-lg text-gray-300 font-medium cursor-not-allowed">
                        Add Transaction
                    </div>
                    <div class="w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 rounded-lg text-gray-500 font-medium border border-gray-700 cursor-not-allowed">
                        Create Receipt
                    </div>
                    <div class="w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 rounded-lg text-gray-500 font-medium border border-gray-700 cursor-not-allowed">
                        Generate Report
                    </div>
                    @endif
                    @if(Auth::user()->role !== 'guest')
                    <a href="{{ route('bendahara.cash-balances.create') }}" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-600 hover:to-gray-700 rounded-lg transition duration-200 text-amber-400 font-medium border border-amber-900">
                        Record Balance
                    </a>
                    <a href="{{ route('bendahara.cash-balances.monitor') }}" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-600 hover:to-gray-700 rounded-lg transition duration-200 text-amber-400 font-medium border border-amber-900">
                        Monitor Balance
                    </a>
                    @else
                    <div class="w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 rounded-lg text-gray-500 font-medium border border-gray-700 cursor-not-allowed">
                        Record Balance
                    </div>
                    <div class="w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 rounded-lg text-gray-500 font-medium border border-gray-700 cursor-not-allowed">
                        Monitor Balance
                    </div>
                    @endif
                </div>

                <div class="mt-6 pt-6 border-t border-gray-700">
                    <h3 class="text-lg font-bold mb-3 text-amber-400">Role: {{ ucfirst(Auth::user()->role) }}</h3>
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <p class="text-sm text-gray-300">
                            @if(Auth::user()->role === 'admin')
                                As an Admin, you have full access to all system features.
                            @elseif(Auth::user()->role === 'bendahara')
                                As a Bendahara, you manage transactions and cash flow.
                            @elseif(Auth::user()->role === 'auditor')
                                As an Auditor, you review and verify financial records.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection