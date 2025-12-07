@extends('layouts.admin')

@section('header', 'Financial Reports')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                    });
                });
            </script>
        @endif

        <form id="bulk-delete-form" action="{{ route('admin.financial-reports.bulk-destroy') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-headline">All Financial Reports</h2>
                <div class="flex items-center space-x-4">
                    <button id="bulk-delete-button" type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-800 transition hidden">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path></svg>
                        Delete Selected
                    </button>
                    <a href="{{ route('admin.financial-reports.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        Create Report
                    </a>
                     <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-800 transition">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        Export
                    </a>
                </div>
            </div>

            <!-- Financial Reports Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4"><input type="checkbox" id="select-all"></th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Title</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Report Date</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Total Revenue</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Total Expense</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Net Profit</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($financialReports as $report)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-4"><input type="checkbox" name="ids[]" value="{{ $report->id }}" class="row-checkbox"></td>
                                <td class="py-3 px-4">{{ $report->title }}</td>
                                <td class="py-3 px-4">{{ $report->report_date }}</td>
                                <td class="py-3 px-4 text-green-600">{{ number_format($report->items->where('type', 'revenue')->sum('amount'), 2) }}</td>
                                <td class="py-3 px-4 text-red-600">{{ number_format($report->items->where('type', 'expense')->sum('amount'), 2) }}</td>
                                <td class="py-3 px-4 font-bold">{{ number_format($report->items->where('type', 'revenue')->sum('amount') - $report->items->where('type', 'expense')->sum('amount'), 2) }}</td>
                                <td class="py-3 px-4 flex items-center space-x-2">
                                    <a href="{{ route('admin.financial-reports.show', $report) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <form class="delete-form" action="{{ route('admin.financial-reports.destroy', $report) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500">No financial reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $financialReports->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Your existing script for checkboxes and delete confirmations
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const bulkDeleteButton = document.getElementById('bulk-delete-button');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');

            function toggleBulkDeleteButton() {
                const anyChecked = Array.from(checkboxes).some(c => c.checked);
                bulkDeleteButton.classList.toggle('hidden', !anyChecked);
            }

            selectAll.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                toggleBulkDeleteButton();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    if (!this.checked) {
                        selectAll.checked = false;
                    }
                    toggleBulkDeleteButton();
                });
            });

            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
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
                            this.submit();
                        }
                    })
                });
            });

            if(bulkDeleteButton) {
                bulkDeleteButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    const anyChecked = Array.from(checkboxes).some(c => c.checked);
                    if (anyChecked) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You want to delete the selected reports?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete them!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                bulkDeleteForm.submit();
                            }
                        })
                    }
                });
            }
        });
    </script>
@endsection
