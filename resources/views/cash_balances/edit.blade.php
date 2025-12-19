@extends('layouts.app')

@section('title', 'Cash Balance Details')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">

            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-amber-400">Cash Balance Details</h1>
                <a href="{{ route('bendahara.cash-balances.index') }}" class="text-amber-400 hover:text-amber-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            </div>

            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">

                {{-- Amount --}}
                <div class="mb-6">
                    <h3 class="text-sm text-gray-300 mb-1">Amount</h3>
                    <p class="text-2xl font-bold text-amber-400">
                        Rp {{ number_format($cashBalance->amount, 0, ',', '.') }}
                    </p>
                </div>

                {{-- Description --}}
                <div class="mb-6">
                    <h3 class="text-sm text-gray-300 mb-1">Description</h3>
                    <p class="bg-gray-700 px-4 py-3 rounded-lg border border-gray-600">
                        {{ $cashBalance->description ?? '-' }}
                    </p>
                </div>

                {{-- Date --}}
                <div class="mb-6">
                    <h3 class="text-sm text-gray-300 mb-1">Date</h3>
                    <p class="bg-gray-700 px-4 py-3 rounded-lg border border-gray-600">
                        {{ $cashBalance->date->format('d M Y') }}
                    </p>
                </div>

                {{-- User --}}
                <div class="mb-6">
                    <h3 class="text-sm text-gray-300 mb-1">Owner</h3>
                    <p class="bg-gray-700 px-4 py-3 rounded-lg border border-gray-600">
                        {{ $cashBalance->user->name ?? 'Unknown User' }}
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('bendahara.cash-balances.index') }}"
                        class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                        Back
                    </a>

                    <a href="{{ route('bendahara.cash-balances.edit', $cashBalance) }}"
                        class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                        Edit
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
