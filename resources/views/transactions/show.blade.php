@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-amber-400">Transaction Details</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('bendahara.transactions.edit', $transaction->id) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                        Edit
                    </a>
                    <a href="{{ route('bendahara.transactions.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                        Back to List
                    </a>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <p class="text-gray-400">Date</p>
                        <p class="text-xl font-medium">{{ $transaction->date->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Type</p>
                        <p>
                            @if($transaction->type === 'income')
                                <span class="px-3 py-1 bg-green-900/30 text-green-400 rounded-full">Income</span>
                            @else
                                <span class="px-3 py-1 bg-red-900/30 text-red-400 rounded-full">Expense</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400">Amount</p>
                        <p class="text-2xl font-bold">
                            @if($transaction->type === 'income')
                                <span class="text-green-400">+Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            @else
                                <span class="text-red-400">-Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400">Category</p>
                        <p class="text-xl font-medium">
                            <span class="px-3 py-1 bg-gray-700 rounded-full">
                                {{ $transaction->category->name }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-gray-400 mb-2">Description</p>
                    <p class="text-lg">{{ $transaction->description }}</p>
                </div>

                <div class="border-t border-gray-700 pt-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-400">Created At</p>
                            <p>{{ $transaction->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Updated At</p>
                            <p>{{ $transaction->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                @if(Auth::user()->role !== 'guest')
                @if($transaction->receipt_id)
                <a href="{{ route('bendahara.receipts.print', $transaction->receipt_id) }}" target="_blank" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200">
                    Print Receipt
                </a>
                @else
                <a href="{{ route('bendahara.transactions.receipt', $transaction->id) }}" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200"
                   onclick="return confirm('Generate receipt for this transaction?')">
                    Generate Receipt
                </a>
                @endif
                <form action="{{ route('bendahara.transactions.destroy', $transaction->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-200"
                            onclick="return confirm('Are you sure you want to delete this transaction?')">
                        Delete Transaction
                    </button>
                </form>
                @else
                <div class="px-6 py-3 bg-gray-600 text-white rounded-lg">
                    Guest access restricted
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection