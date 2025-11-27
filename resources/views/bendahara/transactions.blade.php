@extends('layouts.app')

@section('title', 'Bendahara Transactions')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-amber-400 mb-2">Transactions Management</h1>
            <p class="text-gray-400">Record and manage all financial transactions</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Quick Stats -->
            <div class="lg:col-span-1">
                <div class="bg-gray-800 rounded-xl border border-amber-900 p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4 text-amber-400">Quick Stats</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-700">
                            <span class="text-gray-400">Total Income</span>
                            <span class="text-xl font-bold text-green-400">Rp 18,500,000</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-700">
                            <span class="text-gray-400">Total Expenses</span>
                            <span class="text-xl font-bold text-red-400">Rp 8,300,000</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Current Balance</span>
                            <span class="text-xl font-bold text-amber-400">Rp 10,200,000</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                    <h2 class="text-xl font-bold mb-4 text-amber-400">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('bendahara.transactions.create') }}" class="block w-full text-center px-4 py-3 bg-amber-600 hover:bg-amber-700 rounded-lg transition duration-200 text-white font-medium">
                            Add New Transaction
                        </a>
                        <a href="#" class="block w-full text-center px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400 font-medium">
                            Import Transactions
                        </a>
                        <a href="#" class="block w-full text-center px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400 font-medium">
                            Export Transactions
                        </a>
                        <a href="#" class="block w-full text-center px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400 font-medium">
                            View Reports
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="lg:col-span-2">
                <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-amber-400">Recent Transactions</h2>
                        <a href="{{ route('bendahara.transactions.index') }}" class="text-amber-400 hover:text-amber-300">
                            View All
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-700">
                                    <th class="py-3 px-4 text-left text-gray-400">Date</th>
                                    <th class="py-3 px-4 text-left text-gray-400">Description</th>
                                    <th class="py-3 px-4 text-left text-gray-400">Category</th>
                                    <th class="py-3 px-4 text-left text-gray-400">Type</th>
                                    <th class="py-3 px-4 text-left text-gray-400">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-700 hover:bg-gray-750">
                                    <td class="py-3 px-4">2025-01-15</td>
                                    <td class="py-3 px-4">Office Supplies</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 bg-gray-700 rounded text-xs">
                                            Operations
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 bg-red-900/30 text-red-400 rounded text-xs">Expense</span>
                                    </td>
                                    <td class="py-3 px-4 text-red-400">Rp 1,200,000</td>
                                </tr>
                                <tr class="border-b border-gray-700 hover:bg-gray-750">
                                    <td class="py-3 px-4">2025-01-14</td>
                                    <td class="py-3 px-4">Project Payment</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 bg-gray-700 rounded text-xs">
                                            Revenue
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 bg-green-900/30 text-green-400 rounded text-xs">Income</span>
                                    </td>
                                    <td class="py-3 px-4 text-green-400">Rp 5,000,000</td>
                                </tr>
                                <tr class="border-b border-gray-700 hover:bg-gray-750">
                                    <td class="py-3 px-4">2025-01-12</td>
                                    <td class="py-3 px-4">Utility Bills</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 bg-gray-700 rounded text-xs">
                                            Utilities
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 bg-red-900/30 text-red-400 rounded text-xs">Expense</span>
                                    </td>
                                    <td class="py-3 px-4 text-red-400">Rp 800,000</td>
                                </tr>
                                <tr class="hover:bg-gray-750">
                                    <td class="py-3 px-4">2025-01-10</td>
                                    <td class="py-3 px-4">Consultation Fee</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 bg-gray-700 rounded text-xs">
                                            Revenue
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 bg-green-900/30 text-green-400 rounded text-xs">Income</span>
                                    </td>
                                    <td class="py-3 px-4 text-green-400">Rp 3,500,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection