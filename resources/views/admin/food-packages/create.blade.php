@extends('layouts.admin')

@section('header', 'Create Food Package')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-headline mb-6">Add New Food Package</h2>

        <form action="{{ route('admin.food-packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                <input type="text" name="name" id="name" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" required></textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">Price</label>
                <input type="number" name="price" id="price" step="0.01" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">Image</label>
                <input type="file" name="image" id="image" class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.food-packages.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">Cancel</a>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">Add Package</button>
            </div>
        </form>
    </div>
@endsection
