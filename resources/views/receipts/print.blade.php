<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt - {{ $receipt->receipt_number }}</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #ffffff;
            color: #000;
        }
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #e0e0e0;
            box-shadow: none;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .receipt-title {
            font-size: 28px;
            font-weight: bold;
            color: #d4af37;
            margin: 0;
        }
        .receipt-number {
            font-size: 16px;
            color: #666;
            margin-top: 5px;
        }
        .receipt-date {
            font-size: 16px;
            color: #666;
            margin-top: 5px;
        }
        .receipt-parties {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .receipt-party {
            flex: 1;
        }
        .receipt-party h3 {
            color: #d4af37;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .receipt-details {
            margin-bottom: 30px;
        }
        .receipt-detail-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .receipt-amount {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }
        .receipt-signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        .signature-box {
            text-align: center;
        }
        .signature-line {
            width: 200px;
            height: 1px;
            border-bottom: 1px solid #000;
            margin: 40px auto 10px;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 40px;
            color: #666;
            font-size: 12px;
        }
        @media print {
            body {
                padding: 0;
            }
            .receipt-container {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body onload="window.print();">
    <div class="receipt-container">
        <div class="receipt-header">
            <h1 class="receipt-title">RECEIPT</h1>
            <div class="receipt-number">Receipt #: {{ $receipt->receipt_number }}</div>
            <div class="receipt-date">Date: {{ $receipt->issued_date->format('F j, Y') }}</div>
        </div>

        <div class="receipt-parties">
            <div class="receipt-party">
                <h3>From</h3>
                <p>{{ config('app.name') }}</p>
                <p>Financial Management System</p>
                <p>Jakarta, Indonesia</p>
            </div>
            <div class="receipt-party">
                <h3>To</h3>
                <p>{{ $receipt->recipient_name }}</p>
                @if($receipt->recipient_address)
                    <p>{{ $receipt->recipient_address }}</p>
                @endif
            </div>
        </div>

        <div class="receipt-details">
            <div class="receipt-detail-item">
                <div>Title</div>
                <div>{{ $receipt->title }}</div>
            </div>
            @if($receipt->description)
            <div class="receipt-detail-item">
                <div>Description</div>
                <div>{{ $receipt->description }}</div>
            </div>
            @endif
            <div class="receipt-detail-item">
                <div>Issued By</div>
                <div>{{ $receipt->issued_by }}</div>
            </div>
            <div class="receipt-detail-item">
                <div>Amount</div>
                <div class="receipt-amount">Rp {{ number_format($receipt->amount, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="receipt-signature">
            <div class="signature-box">
                <div>Signature</div>
                <div class="signature-line"></div>
                <div>{{ $receipt->issued_by }}</div>
            </div>
            <div class="signature-box">
                <div>Amount in Words</div>
                <div>{{ ucwords($amountInWords) }} Rupiah</div>
            </div>
        </div>

        <div class="receipt-footer">
            This is a computer-generated receipt. No signature required.
        </div>
    </div>
</body>
</html>