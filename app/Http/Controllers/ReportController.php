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
        $reports = Report::where('user_id', Auth::id())
            ->orderBy('period_end', 'desc')
            ->paginate(10);

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
        ]);

        // Calculate financial data for the period
        $transactions = Transaction::where('user_id', Auth::id())
            ->whereBetween('date', [$request->period_start, $request->period_end])
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');
        $netIncome = $totalIncome - $totalExpenses;

        $report = Report::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'type' => $request->type,
            'period_start' => $request->period_start,
            'period_end' => $request->period_end,
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'net_income' => $netIncome,
            'content' => $this->generateReportContent($request->period_start, $request->period_end, $transactions, $totalIncome, $totalExpenses, $netIncome),
        ]);

        return redirect()->route('reports.show', $report)->with('success', 'Report generated successfully.');
    }

    /**
     * Display the specified report.
     */
    public function show(Report $report)
    {
        // Ensure user can only view their own reports
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reports.show', compact('report'));
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

        // Check if report for this month already exists
        $existingReport = Report::where('user_id', Auth::id())
            ->where('type', 'monthly')
            ->where('period_start', $currentMonthStart)
            ->first();

        if ($existingReport) {
            return redirect()->route('reports.show', $existingReport)
                ->with('info', 'Monthly report for this period already exists.');
        }

        // Calculate financial data for the month
        $transactions = Transaction::where('user_id', Auth::id())
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->get();

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

        return redirect()->route('reports.show', $report)->with('success', 'Monthly report generated successfully.');
    }
}
