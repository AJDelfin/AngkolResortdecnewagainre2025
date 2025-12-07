@extends('layouts.staff')

@section('header', 'Reservation Management')

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
            <h2 class="text-2xl font-headline">All Reservations</h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('staff.reservations.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Add New Reservation
                </a>
                <button id="bulkDeleteBtn" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-all duration-300 ease-in-out transform opacity-0 scale-95 pointer-events-none">Delete Selected</button>
            </div>
        </div>

        <!-- Reservations Table -->
        <div class="overflow-x-auto">
            <form id="bulk-delete-form" action="{{ route('staff.reservations.bulkDestroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4"><input type="checkbox" id="selectAll"></th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Guest</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Phone Number</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Accommodation</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Check-in</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Check-out</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($reservations as $reservation)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-4"><input type="checkbox" name="ids[]" value="{{ $reservation->id }}" class="reservation-checkbox"></td>
                                <td class="py-3 px-4">{{ $reservation->user->name ?? 'N/A' }}</td>
                                <td class="py-3 px-4">{{ $reservation->phone_number ?? 'N/A' }}</td>
                                <td class="py-3 px-4">
                                    @if ($reservation->room)
                                        Room: {{ $reservation->room->room_number }}
                                    @elseif ($reservation->cottage)
                                        Cottage: {{ $reservation->cottage->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="py-3 px-4">{{ $reservation->check_in_date }}</td>
                                <td class="py-3 px-4">{{ $reservation->check_out_date }}</td>
                                <td class="py-3 px-4">{{ $reservation->status }}</td>
                                <td class="py-3 px-4 flex items-center space-x-2">
                                    <a href="{{ route('staff.reservations.show', $reservation) }}" class="text-green-500 hover:text-green-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <a href="{{ route('staff.reservations.edit', $reservation) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form class="delete-form" action="{{ route('staff.reservations.destroy', $reservation) }}" method="POST">
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
                                <td colspan="8" class="text-center py-6 text-gray-500">No reservations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Single delete confirmation
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
                        form.submit();
                    }
                });
            });
        });

        // Bulk delete functionality
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.reservation-checkbox');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const bulkDeleteForm = document.getElementById('bulk-delete-form');

        function toggleBulkDeleteButton() {
            const anyChecked = Array.from(checkboxes).some(c => c.checked);
            if (anyChecked) {
                bulkDeleteBtn.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                bulkDeleteBtn.classList.add('opacity-100', 'scale-100');
            } else {
                bulkDeleteBtn.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                bulkDeleteBtn.classList.remove('opacity-100', 'scale-100');
            }
        }

        selectAll.addEventListener('change', function () {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkDeleteButton();
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', toggleBulkDeleteButton);
        });

        bulkDeleteBtn.addEventListener('click', function () {
            const anyChecked = Array.from(checkboxes).some(c => c.checked);
            if (anyChecked) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete the selected reservations?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        bulkDeleteForm.submit();
                    }
                })
            }
        });
    });
</script>
@endpush
