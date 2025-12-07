@extends('layouts.admin')

@section('header', 'Create Financial Report')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <form action="{{ route('admin.financial-reports.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <div class="mb-4">
                <label for="report_date" class="block text-sm font-medium text-gray-700">Report Date</label>
                <input type="date" name="report_date" id="report_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>

            <div id="items-container">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Report Items</h3>
                <div class="space-y-4">
                    <!-- Item template -->
                </div>
            </div>

            <button type="button" id="add-item" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add Item</button>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800">Create Report</button>
            </div>
        </form>
    </div>

    <template id="item-template">
        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
            <div class="flex-1">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <input type="text" name="items[][description]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
            </div>
            <div class="flex-1">
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select name="items[][type]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required>
                    <option value="revenue">Revenue</option>
                    <option value="expense">Expense</option>
                </select>
            </div>
            <div class="flex-1">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" name="items[][amount]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" step="0.01" required>
            </div>
            <button type="button" class="remove-item text-red-500 hover:text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path></svg>
            </button>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemsContainer = document.querySelector('#items-container .space-y-4');
            const addItemButton = document.getElementById('add-item');
            const itemTemplate = document.getElementById('item-template');

            addItemButton.addEventListener('click', () => {
                const newItem = itemTemplate.content.cloneNode(true);
                itemsContainer.appendChild(newItem);
            });

            itemsContainer.addEventListener('click', (e) => {
                if (e.target.closest('.remove-item')) {
                    e.target.closest('.flex').remove();
                }
            });
        });
    </script>
@endsection
