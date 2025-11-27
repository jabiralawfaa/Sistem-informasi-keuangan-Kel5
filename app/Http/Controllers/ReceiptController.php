<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReceiptController extends Controller
{
    /**
     * Display a listing of receipts.
     */
    public function index()
    {
        $receipts = Receipt::orderBy('issued_date', 'desc')->paginate(10);

        return view('receipts.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new receipt.
     */
    public function create()
    {
        return view('receipts.create');
    }

    /**
     * Store a newly created receipt in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'issued_by' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_address' => 'nullable|string',
        ]);

        // Generate unique receipt number
        $receiptNumber = 'RCT-' . Carbon::now()->format('Y') . '-' . str_pad(Receipt::count() + 1, 5, '0', STR_PAD_LEFT);

        $receipt = Receipt::create([
            'receipt_number' => $receiptNumber,
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'issued_date' => Carbon::now(),
            'issued_by' => $request->issued_by,
            'recipient_name' => $request->recipient_name,
            'recipient_address' => $request->recipient_address,
        ]);

        return redirect()->route('receipts.show', $receipt)->with('success', 'Receipt created successfully.');
    }

    /**
     * Display the specified receipt.
     */
    public function show(Receipt $receipt)
    {
        $amountInWords = $this->numberToWords($receipt->amount);
        return view('receipts.show', compact('receipt', 'amountInWords'));
    }

    /**
     * Show the form for editing the specified receipt.
     */
    public function edit(Receipt $receipt)
    {
        return view('receipts.edit', compact('receipt'));
    }

    /**
     * Update the specified receipt in storage.
     */
    public function update(Request $request, Receipt $receipt)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'issued_by' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_address' => 'nullable|string',
        ]);

        $receipt->update([
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'issued_by' => $request->issued_by,
            'recipient_name' => $request->recipient_name,
            'recipient_address' => $request->recipient_address,
        ]);

        return redirect()->route('receipts.show', $receipt)->with('success', 'Receipt updated successfully.');
    }

    /**
     * Remove the specified receipt from storage.
     */
    public function destroy(Receipt $receipt)
    {
        $receipt->delete();

        return redirect()->route('receipts.index')->with('success', 'Receipt deleted successfully.');
    }

    /**
     * Print the specified receipt.
     */
    public function print(Receipt $receipt)
    {
        return view('receipts.print', compact('receipt'));
    }

    /**
     * Generate a receipt for a specific transaction.
     */
    public function createForTransaction(Transaction $transaction)
    {
        // Create a receipt based on a transaction
        $receiptNumber = 'RCT-' . Carbon::now()->format('Y') . '-' . str_pad(Receipt::count() + 1, 5, '0', STR_PAD_LEFT);

        $receipt = Receipt::create([
            'receipt_number' => $receiptNumber,
            'title' => 'Receipt for ' . $transaction->description,
            'description' => $transaction->description,
            'amount' => $transaction->amount,
            'issued_date' => Carbon::now(),
            'issued_by' => $transaction->user->name ?? 'System',
            'recipient_name' => 'Customer',
            'recipient_address' => 'N/A',
        ]);

        // Link the receipt to the transaction
        $transaction->update(['receipt_id' => $receipt->id]);

        return redirect()->route('receipts.show', $receipt)->with('success', 'Receipt generated for transaction.');
    }

    /**
     * Convert number to words.
     */
    private function numberToWords($number)
    {
        $ones = array(
            0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
            18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty',
            50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        );

        if ($number == 0) {
            return $ones[0];
        }

        $num = intval($number);
        $output = '';

        if ($num >= 1000000000) {
            $output .= $this->numberToWords($num / 1000000000) . ' billion ';
            $num %= 1000000000;
        }

        if ($num >= 1000000) {
            $output .= $this->numberToWords($num / 1000000) . ' million ';
            $num %= 1000000;
        }

        if ($num >= 1000) {
            $output .= $this->numberToWords($num / 1000) . ' thousand ';
            $num %= 1000;
        }

        if ($num >= 100) {
            $output .= $ones[$num / 100] . ' hundred ';
            $num %= 100;
        }

        if ($num >= 20) {
            $output .= $ones[$num - $num % 10] . ' ';
            $num %= 10;
        }

        if ($num > 0) {
            $output .= $ones[$num];
        }

        return $output;
    }
}
