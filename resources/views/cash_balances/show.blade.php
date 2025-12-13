@extends('layouts.app')

@section('title', 'Cash Balance Details')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-amber-400">Cash Balance Details</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('bendahara.cash-balances.edit', $cashBalance->id) }}"
                       class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                        Edit
                    </a>
                    <a href="{{ route('bendahara.cash-balances.index') }}"
                       class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                        Back to List
                    </a>
                </div>
            </div>

            <!-- Card -->
            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">

                <!-- Top Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                    <!-- Date -->
                    <div>
                        <p class="text-gray-400">Date</p>
                        <p class="text-xl font-medium">
                            {{ $cashBalance->created_at->format('d F Y') }}
                        </p>
                    </div>

                    <!-- Balance -->
                    <div>
                        <p class="text-gray-400">Balance</p>
                        <p class="text-2xl font-bold">
                            @if($cashBalance->balance >= 0)
                                <span class="text-green-400">
                                    Rp {{ number_format($cashBalance->balance, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-red-400">
                                    Rp {{ number_format($cashBalance->balance, 0, ',', '.') }}
                                </span>
                            @endif
                        </p>
                    </div>

                </div>

                <!-- Description -->
                <div class="mb-8">
                    <p class="text-gray-400 mb-2">Description</p>
                    <p class="text-lg">{{ $cashBalance->description }}</p>
                </div>

                <div class="border-t border-gray-700 pt-6">

                    <div class="grid grid-cols-2 gap-4">

                        <!-- Created at -->
                        <div>
                            <p class="text-gray-400">Created At</p>
                            <p>{{ $cashBalance->created_at->format('d F Y H:i') }}</p>
                        </div>

                        <!-- Updated at -->
                        <div>
                            <p class="text-gray-400">Updated At</p>
                            <p>{{ $cashBalance->updated_at->format('d F Y H:i') }}</p>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Bottom Buttons -->
            <div class="mt-6 flex justify-end space-x-3">

                <a href="{{ route('bendahara.cash-balances.edit', $cashBalance->id) }}"
                   class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                    Edit Balance
                </a>

                <form action="{{ route('bendahara.cash-balances.destroy', $cashBalance->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this record?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-200">
                        Delete Balance
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection
