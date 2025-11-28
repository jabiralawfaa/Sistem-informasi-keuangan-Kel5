@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-amber-400 mb-2">Admin Dashboard</h1>
            <p class="text-gray-400">Control panel for financial system administration</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-amber-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Total Users</p>
                        <p class="text-2xl font-bold text-amber-400">12</p>
                    </div>
                </div>
            </div>

            <!-- Total Transactions Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-amber-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Total Transactions</p>
                        <p class="text-2xl font-bold text-amber-400">142</p>
                    </div>
                </div>
            </div>

            <!-- Income Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Total Income</p>
                        <p class="text-2xl font-bold text-green-400">Rp 24,500,000</p>
                    </div>
                </div>
            </div>

            <!-- Expenses Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-red-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Total Expenses</p>
                        <p class="text-2xl font-bold text-red-400">Rp 12,300,000</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Activities -->
            <div class="lg:col-span-2 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <h2 class="text-xl font-bold mb-4 text-amber-400">Recent Activities</h2>
                <div class="space-y-4">
                    <div class="flex items-start border-b border-gray-700 pb-3">
                        <div class="p-2 rounded-full bg-amber-900/30 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium">New transaction added</h3>
                            <p class="text-sm text-gray-400">Bendahara added a new income transaction</p>
                            <p class="text-xs text-gray-500 mt-1">10 minutes ago</p>
                        </div>
                    </div>
                    <div class="flex items-start border-b border-gray-700 pb-3">
                        <div class="p-2 rounded-full bg-amber-900/30 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium">User registered</h3>
                            <p class="text-sm text-gray-400">New user registered to the system</p>
                            <p class="text-xs text-gray-500 mt-1">30 minutes ago</p>
                        </div>
                    </div>
                    <div class="flex items-start border-b border-gray-700 pb-3">
                        <div class="p-2 rounded-full bg-amber-900/30 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium">Report generated</h3>
                            <p class="text-sm text-gray-400">Monthly financial report generated</p>
                            <p class="text-xs text-gray-500 mt-1">2 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <h2 class="text-xl font-bold mb-4 text-amber-400">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.users') }}" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-600 hover:to-gray-700 rounded-lg transition duration-200 text-amber-400 font-medium border border-amber-900">
                        Manage Users
                    </a>
                    <a href="{{ route('bendahara.transactions.index') }}" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-600 hover:to-gray-700 rounded-lg transition duration-200 text-amber-400 font-medium border border-amber-900">
                        View Transactions
                    </a>
                    <a href="#" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-600 hover:to-gray-700 rounded-lg transition duration-200 text-amber-400 font-medium border border-amber-900">
                        Generate Reports
                    </a>
                    <a href="#" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-600 hover:to-gray-700 rounded-lg transition duration-200 text-amber-400 font-medium border border-amber-900">
                        Export Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection