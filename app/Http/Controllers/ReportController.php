<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of reports.
     */
    public function index()
    {
        $user = Auth::user();

        // Admin and auditor can see all reports, others only see their own
        if ($user->role === 'admin' || $user->role === 'auditor') {
            $reports = Report::orderBy('period_end', 'desc')
                ->paginate(10);
        } else {
            $reports = Report::where('user_id', Auth::id())
                ->orderBy('period_end', 'desc')
                ->paginate(10);
        }

        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new report.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:monthly,quarterly,annual',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
            'content' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,txt|max:10240', // max 10MB
        ]);

        // Calculate financial data for the period
        // $transactions = Transaction::where('user_id', Auth::id())
        //     ->whereBetween('date', [$request->period_start, $request->period_end])
        //     ->get();
        $transactionsQuery = Transaction::query()->whereBetween('date', [$request->period_start, $request->period_end]);

        if (Auth::user()->role === 'bendahara') {
            $transactionsQuery->where('user_id', Auth::id());
        }

        $transactions = $transactionsQuery->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');
        $netIncome = $totalIncome - $totalExpenses;

        // Handle file upload if exists
        $filePath = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('reports', $fileName, 'public');
        }

        // For auditor, use the content they provided, otherwise generate from transactions
        $content = $request->content;
        if (Auth::user()->role !== 'auditor') {
            $content = $this->generateReportContent($request->period_start, $request->period_end, $transactions, $totalIncome, $totalExpenses, $netIncome);
        }

        $report = Report::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'type' => $request->type,
            'period_start' => $request->period_start,
            'period_end' => $request->period_end,
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'net_income' => $netIncome,
            'content' => $content,
            'file_path' => $filePath,
        ]);

        // Determine the appropriate route to redirect based on the current route
        $currentRoute = request()->route()->getName();
        $redirectRoute = 'reports.show'; // default

        if (str_starts_with($currentRoute, 'admin.')) {
            $redirectRoute = 'admin.reports.show';
        } elseif (str_starts_with($currentRoute, 'auditor.')) {
            $redirectRoute = 'auditor.reports.show';
        } elseif (str_starts_with($currentRoute, 'bendahara.')) {
            $redirectRoute = 'bendahara.reports.show';
        }

        return redirect()->route($redirectRoute, $report)->with('success', 'Report generated successfully.');
    }

    /**
     * Display the specified report.
     */
    public function show(Report $report)
    {
        $user = Auth::user();

        // Allow users to view their own reports
        // Also allow auditors to view reports (for audit purposes)
        // Also allow admins to view all reports
        if ($report->user_id !== Auth::id() && $user->role !== 'auditor' && $user->role !== 'admin') {
            abort(403);
        }

        return view('reports.show', compact('report'));
    }

    public function destroy(Report $report)
    {
        // Cek otorisasi untuk memastikan hanya Admin/Auditor yang boleh menghapus
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'auditor') {
            abort(403);
        }

        $report->delete();

        // kembali ke halaman indeks laporan
        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }

    /**
     * Generate report content based on transaction data.
     */
    private function generateReportContent($periodStart, $periodEnd, $transactions, $totalIncome, $totalExpenses, $netIncome)
    {
        $content = "<h2>Financial Report</h2>";
        $content .= "<p><strong>Period:</strong> " . Carbon::parse($periodStart)->format('F j, Y') . " - " . Carbon::parse($periodEnd)->format('F j, Y') . "</p>";
        $content .= "<p><strong>Generated on:</strong> " . Carbon::now()->format('F j, Y') . "</p><br>";

        $content .= "<h3>Summary</h3>";
        $content .= "<p><strong>Total Income:</strong> Rp " . number_format($totalIncome, 2, ',', '.') . "</p>";
        $content .= "<p><strong>Total Expenses:</strong> Rp " . number_format($totalExpenses, 2, ',', '.') . "</p>";
        $content .= "<p><strong>Net Income:</strong> Rp " . number_format($netIncome, 2, ',', '.') . "</p><br>";

        // Group transactions by category
        $incomeByCategory = $transactions->where('type', 'income')->groupBy('category_id');
        $expenseByCategory = $transactions->where('type', 'expense')->groupBy('category_id');

        if ($incomeByCategory->count() > 0) {
            $content .= "<h3>Income by Category</h3><ul>";
            foreach ($incomeByCategory as $categoryId => $categoryTransactions) {
                $categoryName = $categoryTransactions->first()->category->name;
                $categoryTotal = $categoryTransactions->sum('amount');
                $content .= "<li>{$categoryName}: Rp " . number_format($categoryTotal, 2, ',', '.') . "</li>";
            }
            $content .= "</ul><br>";
        }

        if ($expenseByCategory->count() > 0) {
            $content .= "<h3>Expenses by Category</h3><ul>";
            foreach ($expenseByCategory as $categoryId => $categoryTransactions) {
                $categoryName = $categoryTransactions->first()->category->name;
                $categoryTotal = $categoryTransactions->sum('amount');
                $content .= "<li>{$categoryName}: Rp " . number_format($categoryTotal, 2, ',', '.') . "</li>";
            }
            $content .= "</ul><br>";
        }

        $content .= "<h3>Transaction Details</h3>";
        $content .= "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        $content .= "<tr><th>Date</th><th>Description</th><th>Category</th><th>Type</th><th>Amount</th></tr>";
        foreach ($transactions as $transaction) {
            $content .= "<tr>";
            $content .= "<td>" . $transaction->date->format('Y-m-d') . "</td>";
            $content .= "<td>" . $transaction->description . "</td>";
            $content .= "<td>" . $transaction->category->name . "</td>";
            $content .= "<td>" . ucfirst($transaction->type) . "</td>";
            $content .= "<td>" . ($transaction->type === 'income' ? '+' : '-') . "Rp " . number_format($transaction->amount, 2, ',', '.') . "</td>";
            $content .= "</tr>";
        }
        $content .= "</table>";

        return $content;
    }

    /**
     * Generate a monthly report automatically for the current month.
     */
    public function generateMonthlyReport()
    {
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        // Check if report for this month already exists (Validasi duplikasi laporan)
        $existingReport = Report::where('user_id', Auth::id())
            ->where('type', 'monthly')
            ->where('period_start', $currentMonthStart)
            ->first();

        // untuk mendeteksi siapa yang menekan tombol (admin/auditor/dll)
        $currentRoute = request()->route()->getName();
        $redirectRoute = 'reports.show'; // default

        // untuk kembali ke url yang benar sesuai user yang menekan tombol
        if (str_starts_with($currentRoute, 'admin.')) {
            $redirectRoute = 'admin.reports.show';
        } elseif (str_starts_with($currentRoute, 'auditor.')) {
            $redirectRoute = 'auditor.reports.show';
        } elseif (str_starts_with($currentRoute, 'bendahara.')) {
            $redirectRoute = 'bendahara.reports.show';
        }

        if ($existingReport) {
            return redirect()->route($redirectRoute, $existingReport)
                ->with('info', 'Monthly report for this period already exists.');
        }

        // Calculate financial data for the month
        // $transactions = Transaction::where('user_id', Auth::id())
        //     ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
        //     ->get();

        $transactionsQuery = Transaction::query()->whereBetween('date', [$currentMonthStart, $currentMonthEnd]);

        if (Auth::user()->role === 'bendahara') {
            $transactionsQuery->where('user_id', Auth::id());
        }

        // Sistem menarik semua data transaksi yang terjadi di bulan tersebut
        $transactions = $transactionsQuery->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');
        $netIncome = $totalIncome - $totalExpenses;

        $report = Report::create([
            'user_id' => Auth::id(),
            'title' => 'Monthly Report - ' . $currentMonthStart->format('F Y'),
            'type' => 'monthly',
            'period_start' => $currentMonthStart,
            'period_end' => $currentMonthEnd,
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'net_income' => $netIncome,
            'content' => $this->generateReportContent($currentMonthStart, $currentMonthEnd, $transactions, $totalIncome, $totalExpenses, $netIncome),
        ]);

        return redirect()->route($redirectRoute, $report)->with('success', 'Monthly report generated successfully.');
    }

    /**
     * Print the specified report (for printing view).
     */
    public function print(Report $report)
    {
        $user = Auth::user();

        // Allow users to print their own reports
        // Also allow auditors to print reports (for audit purposes)
        // Also allow admins to print all reports
        if ($report->user_id !== Auth::id() && $user->role !== 'auditor' && $user->role !== 'admin') {
            abort(403);
        }

        return view('reports.print', compact('report'));
    }
}
