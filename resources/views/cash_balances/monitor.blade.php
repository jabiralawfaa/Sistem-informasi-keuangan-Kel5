@extends('layouts.app')

@section('title', 'Cash Balance Monitor')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-amber-400">Cash Balance Monitor</h1>
            <a href="{{ route('cash_balances.index') }}" class="text-amber-400 hover:text-amber-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </div>

        @if($latestBalance)
        <div class="bg-gray-800 rounded-xl border border-amber-900 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Current Balance</p>
                    <p class="text-2xl font-bold text-green-400">Rp {{ number_format($latestBalance->balance, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Balance Change</p>
                    <p class="text-2xl font-bold {{ $balanceChange >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        @if($balanceChange !== null)
                            {{ $balanceChange >= 0 ? '+' : '' }}Rp {{ number_format($balanceChange, 0, ',', '.') }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Last Updated</p>
                    <p class="text-xl font-bold text-amber-400">{{ $latestBalance->date->format('M d, Y') }}</p>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Status</p>
                    <p class="text-xl font-bold {{ $latestBalance->balance >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        {{ $latestBalance->balance >= 0 ? 'Positive' : 'Negative' }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Balance Trend Chart -->
            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                <h2 class="text-xl font-bold text-amber-400 mb-6">Balance Trend</h2>
                <div class="h-64 flex items-end space-x-2 justify-center pt-8 pb-4">
                    @if($cashBalances->count() > 0)
                        @php
                            $maxBalance = $cashBalances->max('balance');
                            $minBalance = $cashBalances->min('balance');
                            $range = max(1, $maxBalance - $minBalance);
                        @endphp
                        
                        @foreach($cashBalances as $balance)
                            <div class="flex flex-col items-center flex-1">
                                <div 
                                    class="w-full bg-gradient-to-t {{ $balance->balance >= 0 ? 'from-green-500 to-green-600' : 'from-red-500 to-red-600' }} rounded-t-lg transition-all duration-1000 ease-out"
                                    style="height: {{ $maxBalance > 0 ? ($balance->balance / $maxBalance) * 100 : 50 }}%"
                                >
                                    <div class="text-center text-xs pt-1 text-white font-bold">
                                        Rp {{ number_format($balance->balance, 0, ',', '') }}
                                    </div>
                                </div>
                                <div class="text-xs mt-2 text-gray-400">{{ $balance->date->format('m/d') }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex items-center justify-center w-full h-full text-gray-500">
                            No balance data available
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Balance Records -->
            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                <h2 class="text-xl font-bold text-amber-400 mb-6">Recent Balance Records</h2>
                <div class="space-y-4">
                    @forelse($cashBalances->take(5) as $balance)
                        <div class="flex justify-between items-center border-b border-gray-700 pb-3 last:border-0 last:pb-0">
                            <div>
                                <div class="font-medium">{{ $balance->date->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-400">{{ $balance->description ?: 'Balance Update' }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold {{ $balance->balance >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    Rp {{ number_format($balance->balance, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500 text-center py-8">
                            No recent balance records
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
            <h2 class="text-xl font-bold text-amber-400 mb-6">Balance Insights</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Highest Balance</p>
                    @if($cashBalances->count() > 0)
                        <p class="text-xl font-bold text-green-400">
                            Rp {{ number_format($cashBalances->max('balance'), 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-400 mt-1">
                            on {{ $cashBalances->sortByDesc('balance')->first()->date->format('M d, Y') }}
                        </p>
                    @else
                        <p class="text-gray-500">N/A</p>
                    @endif
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Lowest Balance</p>
                    @if($cashBalances->count() > 0)
                        <p class="text-xl font-bold text-red-400">
                            Rp {{ number_format($cashBalances->min('balance'), 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-400 mt-1">
                            on {{ $cashBalances->sortBy('balance')->first()->date->format('M d, Y') }}
                        </p>
                    @else
                        <p class="text-gray-500">N/A</p>
                    @endif
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Average Balance</p>
                    @if($cashBalances->count() > 0)
                        <p class="text-xl font-bold text-amber-400">
                            Rp {{ number_format($cashBalances->avg('balance'), 0, ',', '.') }}
                        </p>
                    @else
                        <p class="text-gray-500">N/A</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection