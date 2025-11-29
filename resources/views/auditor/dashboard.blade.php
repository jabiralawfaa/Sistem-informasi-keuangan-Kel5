@extends('layouts.app')

@section('title', 'Auditor Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-amber-400 mb-2">Auditor Dashboard</h1>
            <p class="text-gray-400">Monitor and verify financial transactions and reports</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Transactions Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-amber-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Total Transactions</p>
                        <p class="text-2xl font-bold text-amber-400">{{ $totalTransactions }}</p>
                    </div>
                </div>
            </div>

            <!-- Verified Transactions Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Verified Transactions</p>
                        <p class="text-2xl font-bold text-green-400">{{ $verifiedTransactions }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Verification Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-yellow-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Pending Verification</p>
                        <p class="text-2xl font-bold text-yellow-400">{{ $pendingTransactions }}</p>
                    </div>
                </div>
            </div>

            <!-- Monthly Reports Card -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-xl border border-amber-900">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-900/30 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400">Monthly Reports</p>
                        <p class="text-2xl font-bold text-blue-400">{{ $monthlyReports }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Audits -->
            <div class="lg:col-span-2 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-amber-400">Recent Reports</h2>
                    <a href="{{ route('auditor.reports.index') }}" class="text-sm text-amber-400 hover:text-amber-300">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="py-3 px-4 text-left text-gray-400">Date</th>
                                <th class="py-3 px-4 text-left text-gray-400">Report</th>
                                <th class="py-3 px-4 text-left text-gray-400">Status</th>
                                <th class="py-3 px-4 text-left text-gray-400">Created By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentReports as $report)
                            <tr class="border-b border-gray-700 hover:bg-gray-750">
                                <td class="py-3 px-4">{{ $report->created_at->format('Y-m-d') }}</td>
                                <td class="py-3 px-4">{{ $report->title ?? 'Financial Report' }}</td>
                                <td class="py-3 px-4"><span class="px-2 py-1 bg-green-900/30 text-green-400 rounded text-xs">Verified</span></td>
                                <td class="py-3 px-4">{{ $report->user->name ?? 'System' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">No recent reports</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Verification Stats -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
                <h2 class="text-xl font-bold mb-4 text-amber-400">Verification Stats</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-400">Verification Rate</span>
                            <span class="text-amber-400">{{ $verificationRate }}%</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-2">
                            <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $verificationRate }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-400">Total Reports</span>
                            <span class="text-amber-400">{{ $monthlyReports }}</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-400">Total Transactions</span>
                            <span class="text-amber-400">{{ $totalTransactions }}</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    <a href="{{ route('auditor.reports.index') }}" class="block w-full text-center px-4 py-3 bg-amber-600 hover:bg-amber-700 rounded-lg transition duration-200 text-white font-medium">
                        Review Reports
                    </a>
                    <a href="{{ route('bendahara.transactions.index') }}" class="block w-full text-center px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400 font-medium">
                        Verify Transactions
                    </a>
                    <a href="{{ route('bendahara.reports.create') }}" class="block w-full text-center px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition duration-200 text-amber-400 font-medium">
                        Generate Audit Report
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection