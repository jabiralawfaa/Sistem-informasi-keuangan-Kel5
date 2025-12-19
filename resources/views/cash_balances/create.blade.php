@extends('layouts.app')

@section('title', 'Record Cash Balance')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-amber-400">Record Cash Balance</h1>
                <a href="{{ route('bendahara.cash-balances.index') }}" class="text-amber-400 hover:text-amber-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            </div>

            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                <div class="mb-6 p-4 bg-gray-700 rounded-lg">
                    <p class="text-gray-300 mb-2">Calculated Balance Based on Transactions:</p>
                    <p class="text-xl font-bold text-green-400">Rp {{ number_format($calculatedBalance ?? 0, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-400 mt-2">This is the balance calculated from your income and expense transactions</p>
                </div>

                <form action="{{ route('bendahara.cash-balances.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="balance" class="block text-sm font-medium text-gray-300 mb-2">Current Balance (Rp)</label>
                        <input 
                            type="number" 
                            name="balance" 
                            id="balance" 
                            value="{{ old('balance') }}" 
                            step="0.01"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" 
                            placeholder="0.00"
                            required
                        >
                        @error('balance')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="date" class="block text-sm font-medium text-gray-300 mb-2">Date</label>
                        <input 
                            type="date" 
                            name="date" 
                            id="date" 
                            value="{{ old('date', date('Y-m-d')) }}" 
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" 
                            required
                        >
                        @error('date')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="3" 
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" 
                            placeholder="Enter description for this balance record"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('bendahara.cash-balances.index') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                            Record Balance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection