@extends('layouts.app')

@section('title', 'Receipt: ' . $receipt->receipt_number)

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-amber-400">Receipt Details</h1>
                <div class="flex space-x-3">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.receipts.print', $receipt) }}" target="_blank" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4v1H4a2 2 0 00-2 2v6a2 2 0 002 2h1v7a2 2 0 002 2h8a2 2 0 002-2V13h1a2 2 0 002-2V7a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v1h6V4zm0 2H7v1h6V6zM7 9h6v6H7V9z" clip-rule="evenodd" />
                            </svg>
                            Print Receipt
                        </a>
                        <a href="{{ route('admin.receipts.edit', $receipt) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                            Edit
                        </a>
                        <a href="{{ route('admin.receipts.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                            Back to List
                        </a>
                    @else
                        <a href="{{ route('bendahara.receipts.print', $receipt) }}" target="_blank" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4v1H4a2 2 0 00-2 2v6a2 2 0 002 2h1v7a2 2 0 002 2h8a2 2 0 002-2V13h1a2 2 0 002-2V7a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v1h6V4zm0 2H7v1h6V6zM7 9h6v6H7V9z" clip-rule="evenodd" />
                            </svg>
                            Print Receipt
                        </a>
                        <a href="{{ route('bendahara.receipts.edit', $receipt) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                            Edit
                        </a>
                        <a href="{{ route('bendahara.receipts.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                            Back to List
                        </a>
                    @endif
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl border border-amber-900 p-8 mb-8">
                <!-- Receipt Header -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-amber-400 mb-2">RECEIPT</h2>
                    <div class="text-lg font-semibold">Receipt #: {{ $receipt->receipt_number }}</div>
                    <div class="text-gray-400">Date: {{ $receipt->issued_date->format('F j, Y') }}</div>
                </div>

                <!-- Receipt Body -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-lg font-bold text-amber-400 mb-3">From</h3>
                        <div class="bg-gray-700 p-4 rounded-lg">
                            <p class="font-semibold">{{ config('app.name') }}</p>
                            <p class="text-gray-400">Financial Management System</p>
                            <p class="text-gray-400">Jakarta, Indonesia</p>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-bold text-amber-400 mb-3">To</h3>
                        <div class="bg-gray-700 p-4 rounded-lg">
                            <p class="font-semibold">{{ $receipt->recipient_name }}</p>
                            @if($receipt->recipient_address)
                                <p class="text-gray-400">{{ $receipt->recipient_address }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-bold text-amber-400 mb-3">Details</h3>
                    <div class="bg-gray-700 p-6 rounded-lg">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-gray-400">Title</p>
                                <p class="font-medium">{{ $receipt->title }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Amount</p>
                                <p class="text-2xl font-bold text-green-400">Rp {{ number_format($receipt->amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        @if($receipt->description)
                            <div class="mb-4">
                                <p class="text-gray-400">Description</p>
                                <p class="">{{ $receipt->description }}</p>
                            </div>
                        @endif
                        
                        <div>
                            <p class="text-gray-400">Issued By</p>
                            <p class="font-medium">{{ $receipt->issued_by }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-700 pt-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-400">Signature</p>
                            <div class="h-16 w-40 border-b border-gray-600 mt-2"></div>
                            <p class="text-center mt-1">{{ $receipt->issued_by }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-400">Amount in Words</p>
                            <p class="font-medium mt-1">{{ ucwords($amountInWords) }} Rupiah</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <form action="{{ route('bendahara.receipts.destroy', $receipt) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-200"
                            onclick="return confirm('Are you sure you want to delete this receipt?')">
                        Delete Receipt
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function printReceipt() {
        window.print();
    }
</script>
@endsection