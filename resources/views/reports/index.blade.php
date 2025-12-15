@extends('layouts.app')

@section('title', 'Financial Reports')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-amber-400">Financial Reports</h1>
            <div class="flex space-x-3">
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.reports.create') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                        New Report
                    </a>
                @elseif(Auth::user()->role === 'auditor')
                    <a href="{{ route('auditor.reports.create') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                        New Report
                    </a>
                @else
                    <a href="{{ route('bendahara.reports.monthly') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                        Generate Monthly Report
                    </a>
                    <a href="{{ route('bendahara.reports.create') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                        New Report
                    </a>
                @endif
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl border border-amber-900 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Total Reports</p>
                    <p class="text-2xl font-bold text-amber-400">{{ $reports->total() }}</p>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Monthly Reports</p>
                    <p class="text-2xl font-bold text-amber-400">{{ $reports->where('type', 'monthly')->count() }}</p>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Quarterly Reports</p>
                    <p class="text-2xl font-bold text-amber-400">{{ $reports->where('type', 'quarterly')->count() }}</p>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <p class="text-gray-400">Annual Reports</p>
                    <p class="text-2xl font-bold text-amber-400">{{ $reports->where('type', 'annual')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl border border-amber-900 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="py-3 px-4 text-left text-gray-400">Title</th>
                            <th class="py-3 px-4 text-left text-gray-400">Type</th>
                            <th class="py-3 px-4 text-left text-gray-400">Period</th>
                            <th class="py-3 px-4 text-left text-gray-400">Total Income</th>
                            <th class="py-3 px-4 text-left text-gray-400">Total Expenses</th>
                            <th class="py-3 px-4 text-left text-gray-400">Net Income</th>
                            <th class="py-3 px-4 text-left text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr class="border-b border-gray-700 hover:bg-gray-750">
                            <td class="py-3 px-4">{{ $report->title }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 bg-blue-900/30 text-blue-400 rounded text-xs capitalize">{{ $report->type }}</span>
                            </td>
                            <td class="py-3 px-4">
                                {{ $report->period_start->format('M Y') }} - {{ $report->period_end->format('M Y') }}
                            </td>
                            <td class="py-3 px-4 text-green-400">Rp {{ number_format($report->total_income, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-red-400">Rp {{ number_format($report->total_expenses, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 {{ $report->net_income >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                Rp {{ number_format($report->net_income, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">

                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.reports.show', $report) }}" class="text-blue-400 hover:text-blue-300">
                                    @elseif(Auth::user()->role === 'auditor')
                                        <a href="{{ route('auditor.reports.show', $report) }}" class="text-blue-400 hover:text-blue-300">
                                    @else
                                        <a href="{{ route('bendahara.reports.show', $report) }}" class="text-blue-400 hover:text-blue-300">
                                    @endif
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    {{-- Tombol Hapus (Hanya untuk Admin dan Auditor) --}}
                                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'auditor')
                                        <form action="{{ route(Auth::user()->role . '.reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan {{ $report->title }}? Data ini tidak dapat dikembalikan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-gray-500">
                                No reports found.
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.reports.create') }}" class="text-amber-400 hover:text-amber-300">Generate your first report</a>.
                                @elseif(Auth::user()->role === 'auditor')
                                    <a href="{{ route('auditor.reports.create') }}" class="text-amber-400 hover:text-amber-300">Generate your first report</a>.
                                @else
                                    <a href="{{ route('bendahara.reports.create') }}" class="text-amber-400 hover:text-amber-300">Generate your first report</a>.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-700">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection