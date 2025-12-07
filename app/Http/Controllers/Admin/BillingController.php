<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BillingController extends Controller
{
    private function getInvoicesData()
    {
        return collect([
            (object)[
                'id' => 1,
                'customer_name' => 'John Doe',
                'amount' => 150.00,
                'due_date' => '2024-12-01',
                'status' => 'Paid',
            ],
            (object)[
                'id' => 2,
                'customer_name' => 'Jane Smith',
                'amount' => 200.50,
                'due_date' => '2024-11-25',
                'status' => 'Overdue',
            ],
            (object)[
                'id' => 3,
                'customer_name' => 'Peter Jones',
                'amount' => 75.00,
                'due_date' => '2024-12-15',
                'status' => 'Pending',
            ],
        ]);
    }

    public function index()
    {
        $invoices = $this->getInvoicesData();
        return view('admin.billing.index', ['invoices' => $invoices]);
    }

    public function create()
    {
        return view('admin.billing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
            'status' => 'required',
        ]);

        return redirect()->route('admin.billing.index')->with('success', 'Invoice created successfully.');
    }

    public function edit($id)
    {
        $invoice = $this->getInvoicesData()->firstWhere('id', $id);
        return view('admin.billing.edit', ['invoice' => $invoice]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
            'status' => 'required',
        ]);

        return redirect()->route('admin.billing.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.billing.index')->with('success', 'Invoice deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        // In a real application, you would delete the invoices with the given IDs.
        return redirect()->route('admin.billing.index')->with('success', count($ids) . ' invoices deleted successfully.');
    }

    public function export()
    {
        $invoices = $this->getInvoicesData();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="invoices.csv"',
        ];

        $callback = function () use ($invoices) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Invoice ID', 'Customer Name', 'Amount', 'Due Date', 'Status']);

            foreach ($invoices as $invoice) {
                fputcsv($file, [$invoice->id, $invoice->customer_name, $invoice->amount, $invoice->due_date, $invoice->status]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
