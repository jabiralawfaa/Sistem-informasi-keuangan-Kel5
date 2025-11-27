<!-- resources/views/components/cash-balance-widget.blade.php -->
<div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-amber-900 p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-amber-400">Cash Balance</h3>
        <div class="flex items-center">
            <span class="text-xs bg-amber-600/20 text-amber-400 px-2 py-1 rounded-full">
                Live
            </span>
        </div>
    </div>

    @php
        // Calculate from transactions if no direct cash balance is recorded
        $transactions = \App\Models\Transaction::where('user_id', auth()->id())->get();
        $calculatedBalance = 0;
        
        foreach ($transactions as $transaction) {
            if ($transaction->type === 'income') {
                $calculatedBalance += $transaction->amount;
            } else {
                $calculatedBalance -= $transaction->amount;
            }
        }
        
        // Get the most recent recorded cash balance
        $recentBalance = \App\Models\CashBalance::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->first();
    @endphp

    <div class="mb-6">
        <p class="text-3xl font-bold text-amber-400">
            Rp {{ number_format(max($calculatedBalance, $recentBalance ? $recentBalance->balance : 0), 0, ',', '.') }}
        </p>
        <p class="text-sm text-gray-400 mt-1">
            @if($recentBalance)
                Last recorded: {{ $recentBalance->date->format('M d, Y') }}
            @else
                Calculated from transactions
            @endif
        </p>
    </div>

    <div class="space-y-3">
        <div class="flex justify-between">
            <span class="text-gray-400">Total Income</span>
            <span class="font-medium text-green-400">
                Rp {{ number_format($transactions->where('type', 'income')->sum('amount'), 0, ',', '.') }}
            </span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-400">Total Expenses</span>
            <span class="font-medium text-red-400">
                Rp {{ number_format($transactions->where('type', 'expense')->sum('amount'), 0, ',', '.') }}
            </span>
        </div>
        <div class="pt-2 mt-2 border-t border-gray-700 flex justify-between">
            <span class="text-gray-400">Net Position</span>
            <span class="font-bold {{ $calculatedBalance >= 0 ? 'text-green-400' : 'text-red-400' }}">
                {{ $calculatedBalance >= 0 ? '+' : '' }}Rp {{ number_format($calculatedBalance, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <div class="mt-6 pt-4 border-t border-gray-700">
        <div class="flex space-x-2">
            <a href="{{ route('cash_balances.create') }}" class="flex-1 text-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm transition duration-200">
                Record Balance
            </a>
            <a href="{{ route('cash_balances.monitor') }}" class="flex-1 text-center px-4 py-2 bg-gray-700 hover:bg-gray-600 text-amber-400 rounded-lg text-sm transition duration-200">
                Monitor
            </a>
        </div>
    </div>
</div>