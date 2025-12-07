@extends('layouts.admin')

@section('header', 'Edit Invoice')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <form action="{{ route('admin.billing.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ $invoice->customer_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" name="amount" id="amount" value="{{ $invoice->amount }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                    <input type="date" name="due_date" id="due_date" value="{{ $invoice->due_date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option {{ $invoice->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option {{ $invoice->status === 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option {{ $invoice->status === 'Overdue' ? 'selected' : '' }}>Overdue</option>
                    </select>
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Invoice
                </button>
            </div>
        </form>
    </div>
@endsection
