@extends('layouts.admin')

@section('header', 'Billing & Invoices')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-headline">All Invoices</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.billing.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create Invoice
                </a>
                <a href="{{ route('admin.billing.export') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Export to CSV
                </a>
                <button id="bulk-delete-btn" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" style="display: none;">
                    Bulk Delete
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Invoices Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Invoice ID</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Customer Name</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Amount</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Due Date</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($invoices as $invoice)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <input type="checkbox" class="row-checkbox" value="{{ $invoice->id }}">
                            </td>
                            <td class="py-3 px-4">{{ $invoice->id }}</td>
                            <td class="py-3 px-4">{{ $invoice->customer_name }}</td>
                            <td class="py-3 px-4">₱{{ number_format($invoice->amount, 2) }}</td>
                            <td class="py-3 px-4">{{ $invoice->due_date }}</td>
                            <td class="py-3 px-4">
                                <span class="{{ $invoice->status === 'Paid' ? 'bg-green-500' : ($invoice->status === 'Overdue' ? 'bg-red-500' : 'bg-yellow-500') }} text-white py-1 px-3 rounded-full text-xs">{{ $invoice->status }}</span>
                            </td>
                            <td class="py-3 px-4 flex items-center space-x-2">
                                <a href="{{ route('admin.billing.edit', $invoice->id) }}" class="text-blue-500 hover:text-blue-700">
                                    Edit
                                </a>
                                <button class="text-red-500 hover:text-red-700 delete-btn" data-id="{{ $invoice->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-500">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Select All Checkbox
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

            function toggleBulkDeleteBtn() {
                const anyChecked = Array.from(checkboxes).some(c => c.checked);
                bulkDeleteBtn.style.display = anyChecked ? 'block' : 'none';
            }

            selectAll.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                toggleBulkDeleteBtn();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleBulkDeleteBtn);
            });

            // Single Delete
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const invoiceId = this.dataset.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/admin/billing/${invoiceId}`;
                            form.innerHTML = '@csrf @method("DELETE")';
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // Bulk Delete
            bulkDeleteBtn.addEventListener('click', function () {
                const selectedIds = Array.from(checkboxes)
                    .filter(c => c.checked)
                    .map(c => c.value);

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to delete ${selectedIds.length} invoices. You won't be able to revert this!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete them!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route("admin.billing.bulk-destroy") }}';
                            form.innerHTML = `
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="ids" value="${selectedIds.join(',')}">
                            `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
@endsection
