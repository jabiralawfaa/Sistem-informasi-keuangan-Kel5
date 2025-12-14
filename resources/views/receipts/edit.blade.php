@extends('layouts.app')

@section('title', 'Edit Receipt: ' . $receipt->receipt_number)

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-amber-400">Edit Receipt</h1>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.receipts.show', $receipt) }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                        Cancel
                    </a>
                @else
                    <a href="{{ route('bendahara.receipts.show', $receipt) }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                        Cancel
                    </a>
                @endif
            </div>

            <div class="bg-gray-800 rounded-xl border border-amber-900 p-8">
                <form method="POST" action="
                    @if(Auth::user()->role === 'admin')
                        {{ route('admin.receipts.update', $receipt) }}
                    @else
                        {{ route('bendahara.receipts.update', $receipt) }}
                    @endif
                ">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="receipt_number" class="block text-gray-400 mb-2">Receipt Number</label>
                            <input type="text" id="receipt_number" name="receipt_number" value="{{ old('receipt_number', $receipt->receipt_number) }}" readonly class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-400">
                        </div>
                        <div>
                            <label for="amount" class="block text-gray-400 mb-2">Amount</label>
                            <input type="number" step="0.01" id="amount" name="amount" value="{{ old('amount', $receipt->amount) }}" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-amber-400">
                            @error('amount')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="title" class="block text-gray-400 mb-2">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $receipt->title) }}" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-amber-400">
                        @error('title')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-gray-400 mb-2">Description</label>
                        <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-amber-400">{{ old('description', $receipt->description) }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="issued_by" class="block text-gray-400 mb-2">Issued By</label>
                        <input type="text" id="issued_by" name="issued_by" value="{{ old('issued_by', $receipt->issued_by) }}" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-amber-400">
                        @error('issued_by')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="recipient_name" class="block text-gray-400 mb-2">Recipient Name</label>
                            <input type="text" id="recipient_name" name="recipient_name" value="{{ old('recipient_name', $receipt->recipient_name) }}" required class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-amber-400">
                            @error('recipient_name')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="recipient_address" class="block text-gray-400 mb-2">Recipient Address</label>
                            <input type="text" id="recipient_address" name="recipient_address" value="{{ old('recipient_address', $receipt->recipient_address) }}" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-amber-400">
                            @error('recipient_address')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                            Update Receipt
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection