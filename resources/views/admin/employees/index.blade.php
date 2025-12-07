@extends('layouts.admin')

@section('header', 'Employee Management')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <form id="bulk-delete-form" action="{{ route('admin.employees.bulk-destroy') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-headline">All Employees</h2>
                <div class="flex items-center space-x-4">
                    <button id="bulk-delete-button" type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-800 transition hidden">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path></svg>
                        Delete Selected
                    </button>
                    <a href="{{ route('admin.employees.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        Add New Employee
                    </a>
                </div>
            </div>

            <!-- Employees Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4"><input type="checkbox" id="select-all"></th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Image</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Email</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Joined On</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($employees as $employee)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-4"><input type="checkbox" name="ids[]" value="{{ $employee->id }}" class="row-checkbox"></td>
                                <td class="py-3 px-4">
                                    @if ($employee->image_path)
                                        <img src="{{ asset('storage/' . $employee->image_path) }}" alt="{{ $employee->name }}" class="h-12 w-12 object-cover rounded-full">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"></path></svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-4">{{ $employee->name }}</td>
                                <td class="py-3 px-4">{{ $employee->email }}</td>
                                <td class="py-3 px-4">{{ $employee->created_at->format('M d, Y') }}</td>
                                <td class="py-3 px-4 flex items-center space-x-2">
                                    <a href="{{ route('admin.employees.edit', $employee) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
                                <td colspan="6" class="text-center py-6 text-gray-500">No employees found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $employees->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const bulkDeleteButton = document.getElementById('bulk-delete-button');

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

            document.getElementById('bulk-delete-form').addEventListener('submit', function (e) {
                if (!confirm('Are you sure you want to delete the selected employees?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
