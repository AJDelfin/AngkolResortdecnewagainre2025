@extends('layouts.admin')

@section('header', 'Guest Management')

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

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-headline">All Guests</h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.guests.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Add New Guest
                </a>
                <form id="bulk-delete-form" action="{{ route('admin.guests.bulk-destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button id="bulk-delete-button" type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-all duration-300 ease-in-out transform opacity-0 scale-95 pointer-events-none">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path></svg>
                        Delete Selected
                    </button>
                </form>
            </div>
        </div>

        <!-- Guests Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4"><input type="checkbox" id="select-all"></th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Email</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Phone Number</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($guests as $guest)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4"><input type="checkbox" class="row-checkbox" name="ids[]" value="{{ $guest->id }}" form="bulk-delete-form"></td>
                            <td class="py-3 px-4">{{ $guest->name }}</td>
                            <td class="py-3 px-4">{{ $guest->email }}</td>
                            <td class="py-3 px-4">{{ $guest->phone_number }}</td>
                            <td class="py-3 px-4 flex items-center space-x-2">
                                <a href="{{ route('admin.guests.edit', $guest) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form class="delete-form" action="{{ route('admin.guests.destroy', $guest) }}" method="POST">
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
                            <td colspan="5" class="text-center py-6 text-gray-500">No guests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $guests->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Single Delete Confirmation --- //
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

            // --- Bulk Delete Functionality --- //
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const bulkDeleteButton = document.getElementById('bulk-delete-button');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');

            function toggleBulkDeleteButton() {
                const anyChecked = Array.from(checkboxes).some(c => c.checked);
                 if (anyChecked) {
                    bulkDeleteButton.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                    bulkDeleteButton.classList.add('opacity-100', 'scale-100');
                } else {
                    bulkDeleteButton.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                    bulkDeleteButton.classList.remove('opacity-100', 'scale-100');
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    toggleBulkDeleteButton();
                });
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleBulkDeleteButton);
            });

            if (bulkDeleteButton) {
                bulkDeleteButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    const anyChecked = Array.from(checkboxes).some(c => c.checked);
                    if (anyChecked) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You want to delete all selected guests?",
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

            toggleBulkDeleteButton(); // Initial check
        });
    </script>
@endsection
