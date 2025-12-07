@extends('layouts.admin')

@section('header', 'Edit Financial Report')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">

        <form action="{{ route('admin.financial-reports.update', $financialReport) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('title', $financialReport->title) }}" required>
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="report_date" class="block text-gray-700 font-bold mb-2">Report Date</label>
                <input type="date" name="report_date" id="report_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('report_date', $financialReport->report_date) }}" required>
                @error('report_date')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div id="items-container">
                <h3 class="text-lg font-semibold mb-2">Report Items</h3>
                @foreach ($financialReport->items as $index => $item)
                    <div class="item border-gray-200 border-b pb-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Description</label>
                                <input type="text" name="items[{{ $index }}][description]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $item->description }}" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Type</label>
                                <select name="items[{{ $index }}][type]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="revenue" {{ $item->type === 'revenue' ? 'selected' : '' }}>Revenue</option>
                                    <option value="expense" {{ $item->type === 'expense' ? 'selected' : '' }}>Expense</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Amount</label>
                                <input type="number" name="items[{{ $index }}][amount]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $item->amount }}" required>
                            </div>
                        </div>
                        <button type="button" class="remove-item-btn mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Remove Item</button>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-item-btn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Item</button>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Update Report</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemsContainer = document.getElementById('items-container');
            const addItemBtn = document.getElementById('add-item-btn');
            let itemIndex = {{ count($financialReport->items) }};

            addItemBtn.addEventListener('click', function () {
                const itemHTML = `
                    <div class="item border-gray-200 border-b pb-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Description</label>
                                <input type="text" name="items[${itemIndex}][description]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Type</label>
                                <select name="items[${itemIndex}][type]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="revenue">Revenue</option>
                                    <option value="expense">Expense</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Amount</label>
                                <input type="number" name="items[${itemIndex}][amount]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                        </div>
                        <button type="button" class="remove-item-btn mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Remove Item</button>
                    </div>
                `;
                itemsContainer.insertAdjacentHTML('beforeend', itemHTML);
                itemIndex++;
            });

            itemsContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-item-btn')) {
                    e.target.closest('.item').remove();
                }
            });
        });
    </script>
@endsection
