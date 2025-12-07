@extends('layouts.admin')

@section('header', 'View Invoice')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg" id="invoice-content">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-headline">Invoice #{{ $invoice->id }}</h2>
            <button onclick="printInvoice()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                Print Invoice
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-600 font-semibold">Customer Name:</p>
                <p>{{ $invoice->customer_name }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Amount:</p>
                <p>₱{{ number_format($invoice->amount, 2) }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Due Date:</p>
                <p>{{ $invoice->due_date }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Status:</p>
                <p>
                    <span class="{{ $invoice->status === 'Paid' ? 'bg-green-500' : ($invoice->status === 'Overdue' ? 'bg-red-500' : 'bg-yellow-500') }} text-white py-1 px-3 rounded-full text-xs">
                        {{ $invoice->status }}
                    </span>
                </p>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('admin.billing.index') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition no-print">
                Back to List
            </a>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #invoice-content, #invoice-content * {
                visibility: visible;
            }
            #invoice-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none;
            }
        }
    </style>

    <script>
        function printInvoice() {
            window.print();
        }
    </script>
@endsection
