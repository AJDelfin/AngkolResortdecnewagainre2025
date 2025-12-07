@extends('layouts.staff')

@section('header', 'Guests')

@section('content')
<div class="bg-white rounded-lg shadow-xl p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Guest List</h2>
        <div class="flex items-center space-x-2">
            <a href="{{ route('staff.guests.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition-all duration-300 ease-in-out transform hover:scale-105 flex items-center shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add Guest
            </a>
            <button id="bulk-delete-btn" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-all duration-300 ease-in-out transform opacity-0 scale-95 pointer-events-none flex items-center shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Delete Selected
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md shadow-sm" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="border-b-2 border-gray-200 bg-gray-100">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-12">
                        <input type="checkbox" id="select-all" class="form-checkbox h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    </th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone Number</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($guests as $guest)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-5 py-5 bg-white text-sm">
                            <input type="checkbox" name="ids[]" value="{{ $guest->id }}" class="row-checkbox form-checkbox h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        </td>
                        <td class="px-5 py-5 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $guest->name }}</p>
                        </td>
                        <td class="px-5 py-5 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $guest->email }}</p>
                        </td>
                        <td class="px-5 py-5 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $guest->phone_number }}</p>
                        </td>
                        <td class="px-5 py-5 bg-white text-sm flex items-center space-x-2">
                            <a href="{{ route('staff.guests.edit', $guest) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                            <form action="{{ route('staff.guests.destroy', $guest) }}" method="POST" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500">
                            No guests found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<form id="bulk-delete-form" action="{{ route('staff.guests.bulkDestroy') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('select-all');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    const bulkDeleteForm = document.getElementById('bulk-delete-form');
    const bulkDeleteIdsInput = document.getElementById('bulk-delete-ids');
    const deleteForms = document.querySelectorAll('.delete-form');

    function toggleBulkDeleteBtn() {
        const anyChecked = Array.from(rowCheckboxes).some(checkbox => checkbox.checked);
        if (anyChecked) {
            bulkDeleteBtn.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
            bulkDeleteBtn.classList.add('opacity-100', 'scale-100');
        } else {
            bulkDeleteBtn.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            bulkDeleteBtn.classList.remove('opacity-100', 'scale-100');
        }
    }

    selectAllCheckbox.addEventListener('change', function () {
        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleBulkDeleteBtn();
    });

    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (!this.checked) {
                selectAllCheckbox.checked = false;
            }
            toggleBulkDeleteBtn();
        });
    });

    bulkDeleteBtn.addEventListener('click', function () {
        const selectedIds = Array.from(rowCheckboxes)
                                .filter(checkbox => checkbox.checked)
                                .map(checkbox => checkbox.value);

        if (selectedIds.length > 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to permanently delete ${selectedIds.length} guest(s). This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkDeleteIdsInput.value = selectedIds.join(',');
                    bulkDeleteForm.submit();
                }
            });
        }
    });

    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Initial check on page load
    toggleBulkDeleteBtn();
});
</script>
@endpush
