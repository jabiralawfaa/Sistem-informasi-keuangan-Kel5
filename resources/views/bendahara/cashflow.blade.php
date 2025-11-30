@extends('layouts.app')

@section('title', 'Cash Flow Analysis')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-amber-400 mb-8">Cash Flow Analysis</h1>

        <!-- Filter Form -->
        <div class="mb-8">
            <form method="GET" action="{{ route('bendahara.cash-flow') }}" class="bg-gray-800 border border-amber-900 rounded-lg p-4 flex items-center space-x-4">
                <div>
                    <label for="start_date" class="text-sm text-gray-400">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white">
                </div>
                <div>
                    <label for="end_date" class="text-sm text-gray-400">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white">
                </div>
                <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">Filter</button>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-800 p-6 rounded-xl border border-amber-900">
                <p class="text-gray-400">Total Income</p>
                <p class="text-2xl font-bold text-green-400">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl border border-amber-900">
                <p class="text-gray-400">Total Expenses</p>
                <p class="text-2xl font-bold text-red-400">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl border border-amber-900">
                <p class="text-gray-400">Net Cash Flow</p>
                <p class="text-2xl font-bold {{ $netCashFlow >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    Rp {{ number_format($netCashFlow, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Cash Flow Chart -->
        <div class="bg-gray-800 rounded-xl border border-amber-900 p-6 mb-8">
            <h2 class="text-xl font-bold text-amber-400 mb-4">Cash Flow Chart</h2>
            <canvas id="cashFlowChart"></canvas>
        </div>

        <!-- Transactions Table -->
        <div class="bg-gray-800 rounded-xl border border-amber-900">
            <div class="p-6">
                <h2 class="text-xl font-bold text-amber-400">Transactions</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="py-3 px-4 text-left text-gray-400">Date</th>
                            <th class="py-3 px-4 text-left text-gray-400">Description</th>
                            <th class="py-3 px-4 text-left text-gray-400">Category</th>
                            <th class="py-3 px-4 text-left text-gray-400">Type</th>
                            <th class="py-3 px-4 text-left text-gray-400">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr class="border-b border-gray-700 hover:bg-gray-750">
                            <td class="py-3 px-4">{{ $transaction->date->format('Y-m-d') }}</td>
                            <td class="py-3 px-4">{{ $transaction->description }}</td>
                            <td class="py-3 px-4">{{ $transaction->category->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4">
                                @if($transaction->type === 'income')
                                    <span class="px-2 py-1 bg-green-900/30 text-green-400 rounded text-xs">Income</span>
                                @else
                                    <span class="px-2 py-1 bg-red-900/30 text-red-400 rounded text-xs">Expense</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 {{ $transaction->type === 'income' ? 'text-green-400' : 'text-red-400' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">No transactions found for the selected period.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-700">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('cashFlowChart').getContext('2d');
    var cashFlowChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Income',
                data: @json($chartData['income']),
                borderColor: 'rgba(74, 222, 128, 1)',
                backgroundColor: 'rgba(74, 222, 128, 0.2)',
                fill: true,
            }, {
                label: 'Expenses',
                data: @json($chartData['expenses']),
                borderColor: 'rgba(248, 113, 113, 1)',
                backgroundColor: 'rgba(248, 113, 113, 0.2)',
                fill: true,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)',
                        callback: function(value, index, values) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    }
                }
            }
        }
    });
});
</script>
@endsection
