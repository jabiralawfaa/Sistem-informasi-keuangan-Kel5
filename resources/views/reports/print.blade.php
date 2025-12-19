<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Report - {{ $report->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .report-title {
            font-size: 24px;
            font-weight: bold;
            color: #d97706;
            margin-bottom: 5px;
        }
        .report-period {
            font-size: 16px;
            color: #666;
        }
        .summary {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .summary-item {
            margin: 8px 0;
            font-size: 16px;
        }
        .summary-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .summary-value {
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .positive {
            color: green;
        }
        .negative {
            color: red;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-style: italic;
            color: #666;
        }
        @media print {
            body {
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="report-title">{{ $report->title }}</div>
        <div class="report-period">Period: {{ $report->period_start->format('M j, Y') }} - {{ $report->period_end->format('M j, Y') }}</div>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Report Type:</span>
            <span class="summary-value">{{ ucfirst($report->type) }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Total Income:</span>
            <span class="summary-value positive">Rp {{ number_format($report->total_income, 0, ',', '.') }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Total Expenses:</span>
            <span class="summary-value negative">Rp {{ number_format($report->total_expenses, 0, ',', '.') }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Net Income:</span>
            <span class="summary-value {{ $report->net_income >= 0 ? 'positive' : 'negative' }}">Rp {{ number_format($report->net_income, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="content">
        {!! $report->content !!}
    </div>

    <div class="footer">
        Generated on: {{ now()->format('M j, Y H:i:s') }}
    </div>

    <button class="no-print" onclick="window.print()" style="position: fixed; top: 20px; right: 20px; padding: 10px 20px; background-color: #d97706; color: white; border: none; border-radius: 5px; cursor: pointer;">Print Report</button>
</body>
</html>