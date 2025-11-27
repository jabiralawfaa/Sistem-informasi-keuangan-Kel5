@extends('layouts.app')

@section('title', $report->title)

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-amber-400">{{ $report->title }}</h1>
                <div class="flex space-x-3">
                    <button onclick="window.print()" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 4v1H4a2 2 0 00-2 2v6a2 2 0 002 2h1v7a2 2 0 002 2h8a2 2 0 002-2V13h1a2 2 0 002-2V7a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v1h6V4zm0 2H7v1h6V6zM7 9h6v6H7V9z" clip-rule="evenodd" />
                        </svg>
                        Print Report
                    </button>
                    <a href="{{ route('bendahara.reports.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                        Back to Reports
                    </a>
                </div>
            </div>
            <div class="mt-2 text-gray-400">
                <span class="capitalize">{{ $report->type }}</span> Report | 
                {{ $report->period_start->format('F j, Y') }} - {{ $report->period_end->format('F j, Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                <p class="text-gray-400">Total Income</p>
                <p class="text-2xl font-bold text-green-400">Rp {{ number_format($report->total_income, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                <p class="text-gray-400">Total Expenses</p>
                <p class="text-2xl font-bold text-red-400">Rp {{ number_format($report->total_expenses, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                <p class="text-gray-400">Net Income</p>
                <p class="text-2xl font-bold {{ $report->net_income >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    Rp {{ number_format($report->net_income, 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                <p class="text-gray-400">Generated On</p>
                <p class="text-xl font-bold text-amber-400">{{ $report->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-amber-400 mb-4">Report Content</h2>
                <div class="prose prose-invert max-w-none bg-gray-900 p-6 rounded-lg">
                    {!! $report->content !!}
                </div>
            </div>

            <div class="border-t border-gray-700 pt-6">
                <h3 class="text-xl font-bold text-amber-400 mb-4">Income vs Expenses Chart</h3>
                <div class="flex items-end h-40 gap-4 mb-6">
                    <div class="flex flex-col items-center flex-1">
                        <div class="text-green-400 text-lg mb-2">Income</div>
                        <div 
                            class="w-full bg-gradient-to-t from-green-500 to-green-600 rounded-t-lg transition-all duration-1000 ease-out"
                            style="height: {{ $report->total_income > 0 ? min(100, ($report->total_income / max($report->total_income, $report->total_expenses)) * 100) : 0 }}%"
                        >
                            <div class="text-center text-xs pt-1 text-white font-bold">
                                Rp {{ number_format($report->total_income, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-center flex-1">
                        <div class="text-red-400 text-lg mb-2">Expenses</div>
                        <div 
                            class="w-full bg-gradient-to-t from-red-500 to-red-600 rounded-t-lg transition-all duration-1000 ease-out"
                            style="height: {{ $report->total_expenses > 0 ? min(100, ($report->total_expenses / max($report->total_income, $report->total_expenses)) * 100) : 0 }}%"
                        >
                            <div class="text-center text-xs pt-1 text-white font-bold">
                                Rp {{ number_format($report->total_expenses, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-center">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 mr-2"></div>
                        <span class="mr-6">Income: Rp {{ number_format($report->total_income, 0, ',', '.') }}</span>
                        <div class="w-4 h-4 bg-red-500 mr-2"></div>
                        <span>Expenses: Rp {{ number_format($report->total_expenses, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection