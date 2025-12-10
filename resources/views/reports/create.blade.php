@extends('layouts.app')

@section('title', 'Create New Report')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-amber-400">Create New Report</h1>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.reports.index') }}" class="text-amber-400 hover:text-amber-300">
                @elseif(Auth::user()->role === 'auditor')
                    <a href="{{ route('auditor.reports.index') }}" class="text-amber-400 hover:text-amber-300">
                @else
                    <a href="{{ route('bendahara.reports.index') }}" class="text-amber-400 hover:text-amber-300">
                @endif
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            </div>

            <div class="bg-gray-800 rounded-xl border border-amber-900 p-6">
                @if(Auth::user()->role === 'admin')
                    <form action="{{ route('admin.reports.store') }}" method="POST">
                @elseif(Auth::user()->role === 'auditor')
                    <form action="{{ route('auditor.reports.store') }}" method="POST">
                @else
                    <form action="{{ route('bendahara.reports.store') }}" method="POST">
                @endif
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Report Title</label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                value="{{ old('title') }}" 
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" 
                                placeholder="Monthly Report January 2025"
                                required
                            >
                            @error('title')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-300 mb-2">Report Type</label>
                            <select name="type" id="type" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" required>
                                <option value="">Select Type</option>
                                <option value="monthly" {{ old('type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="quarterly" {{ old('type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                <option value="annual" {{ old('type') == 'annual' ? 'selected' : '' }}>Annual</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="period_start" class="block text-sm font-medium text-gray-300 mb-2">Period Start</label>
                            <input 
                                type="date" 
                                name="period_start" 
                                id="period_start" 
                                value="{{ old('period_start') }}" 
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" 
                                required
                            >
                            @error('period_start')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="period_end" class="block text-sm font-medium text-gray-300 mb-2">Period End</label>
                            <input 
                                type="date" 
                                name="period_end" 
                                id="period_end" 
                                value="{{ old('period_end') }}" 
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent" 
                                required
                            >
                            @error('period_end')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if(Auth::user()->role === 'auditor')
                    <!-- Additional fields for auditor -->
                    <div class="mb-6">
                        <label for="content" class="block text-sm font-medium text-gray-300 mb-2">Report Content</label>
                        <textarea
                            name="content"
                            id="content"
                            rows="6"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            placeholder="Enter detailed report content here...">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="file_path" class="block text-sm font-medium text-gray-300 mb-2">Upload Report File</label>
                        <input
                            type="file"
                            name="file_path"
                            id="file_path"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.txt"
                        >
                        @error('file_path')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-400">Allowed formats: PDF, DOC, DOCX, XLS, XLSX, TXT</p>
                    </div>
                    @endif

                    <div class="flex justify-end space-x-4">
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.reports.index') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                        @elseif(Auth::user()->role === 'auditor')
                            <a href="{{ route('auditor.reports.index') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                        @else
                            <a href="{{ route('bendahara.reports.index') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                        @endif
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition duration-200">
                            Generate Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection