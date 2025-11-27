@extends('layouts.app')

@section('title', 'Create New Receipt')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-amber-400">Create New Receipt</h1>
                <a href="{{ route('bendahara.receipts.index') }}" class="text-amber-400 hover:text-amber-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            </div>

            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                <form action="{{ route('bendahara.receipts.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Receipt Title</label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            value="{{ old('title') }}" 
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" 
                            placeholder="Payment for services"
                            required
                        >
                        @error('title')
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
                            placeholder="Enter receipt details"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-300 mb-2">Amount (Rp)</label>
                            <input 
                                type="number" 
                                name="amount" 
                                id="amount" 
                                value="{{ old('amount') }}" 
                                step="0.01" 
                                min="0.01"
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" 
                                placeholder="0.00"
                                required
                            >
                            @error('amount')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="issued_by" class="block text-sm font-medium text-gray-300 mb-2">Issued By</label>
                            <input 
                                type="text" 
                                name="issued_by" 
                                id="issued_by" 
                                value="{{ old('issued_by', Auth::user()->name ?? '') }}" 
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" 
                                placeholder="Name of issuer"
                                required
                            >
                            @error('issued_by')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="recipient_name" class="block text-sm font-medium text-gray-300 mb-2">Recipient Name</label>
                        <input 
                            type="text" 
                            name="recipient_name" 
                            id="recipient_name" 
                            value="{{ old('recipient_name') }}" 
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" 
                            placeholder="Name of recipient"
                            required
                        >
                        @error('recipient_name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="recipient_address" class="block text-sm font-medium text-gray-300 mb-2">Recipient Address</label>
                        <textarea 
                            name="recipient_address" 
                            id="recipient_address" 
                            rows="2" 
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" 
                            placeholder="Address of recipient"
                        >{{ old('recipient_address') }}</textarea>
                        @error('recipient_address')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('bendahara.receipts.index') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                            Create Receipt
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection