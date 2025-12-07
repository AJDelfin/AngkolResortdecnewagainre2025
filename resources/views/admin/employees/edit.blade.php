@extends('layouts.admin')

@section('header', 'Edit Employee')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-headline mb-6">Update Employee Information</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-3 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" required
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" required
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password (optional)</label>
                    <input type="password" name="password" id="password"
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                     <p class="mt-2 text-sm text-gray-500">Leave blank to keep the current password.</p>
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                    <input type="file" name="image" id="image"
                           class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <p class="mt-1 text-sm text-gray-500">Leave blank to keep the current image. PNG, JPG, GIF (MAX. 2MB).</p>
                    @if ($employee->image_path)
                        <div class="mt-4">
                            <img src="{{ asset('storage/' . $employee->image_path) }}" alt="Current Image" class="h-32 w-32 object-cover rounded-md">
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.employees.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition mr-2">
                    Cancel
                </a>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                    Update Employee
                </button>
            </div>
        </form>
    </div>
@endsection
