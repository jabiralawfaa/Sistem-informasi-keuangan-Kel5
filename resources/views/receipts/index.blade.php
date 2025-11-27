@extends('layouts.app')

@section('title', 'Digital Receipts')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-amber-400">Digital Receipts</h1>
            <a href="{{ route('bendahara.receipts.create') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                Create New Receipt
            </a>
        </div>

        <div class="bg-gray-800 rounded-xl border border-amber-900 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Total Receipts</p>
                    <p class="text-2xl font-bold text-amber-400">{{ $receipts->total() }}</p>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Total Amount</p>
                    <p class="text-2xl font-bold text-green-400">
                        Rp {{ number_format($receipts->sum('amount'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">This Month</p>
                    <p class="text-2xl font-bold text-blue-400">
                        {{ $receipts->where('issued_date', '>=', now()->startOfMonth())->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl border border-amber-900 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="py-3 px-4 text-left text-gray-400">Receipt #</th>
                            <th class="py-3 px-4 text-left text-gray-400">Title</th>
                            <th class="py-3 px-4 text-left text-gray-400">Recipient</th>
                            <th class="py-3 px-4 text-left text-gray-400">Amount</th>
                            <th class="py-3 px-4 text-left text-gray-400">Date</th>
                            <th class="py-3 px-4 text-left text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($receipts as $receipt)
                        <tr class="border-b border-gray-700 hover:bg-gray-750">
                            <td class="py-3 px-4 font-mono text-amber-400">{{ $receipt->receipt_number }}</td>
                            <td class="py-3 px-4">{{ $receipt->title }}</td>
                            <td class="py-3 px-4">{{ $receipt->recipient_name }}</td>
                            <td class="py-3 px-4 text-green-400">Rp {{ number_format($receipt->amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">{{ $receipt->issued_date->format('M d, Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('bendahara.receipts.show', $receipt) }}" class="text-blue-400 hover:text-blue-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('bendahara.receipts.print', $receipt) }}" class="text-green-400 hover:text-green-300" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 4v1H4a2 2 0 00-2 2v6a2 2 0 002 2h1v7a2 2 0 002 2h8a2 2 0 002-2V13h1a2 2 0 002-2V7a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v1h6V4zm0 2H7v1h6V6zM7 9h6v6H7V9z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('bendahara.receipts.edit', $receipt) }}" class="text-amber-400 hover:text-amber-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('bendahara.receipts.destroy', $receipt) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure you want to delete this receipt?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                                No receipts found. <a href="{{ route('bendahara.receipts.create') }}" class="text-amber-400 hover:text-amber-300">Create your first receipt</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-700">
                {{ $receipts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection