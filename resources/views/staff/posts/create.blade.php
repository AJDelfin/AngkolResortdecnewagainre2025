@extends('layouts.staff')

@section('header', 'Add New Post')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-headline mb-6">Post Information</h2>

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

        <form action="{{ route('staff.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" rows="8" required
                              class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">{{ old('content') }}</textarea>
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Featured Image</label>
                    <input type="file" name="image" id="image"
                           class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF (MAX. 2MB).</p>
                </div>

                <!-- Visibility -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Visibility</label>
                    <div class="mt-2 flex items-center">
                        <input type="radio" name="visibility" id="visibility_public" value="public" checked class="mr-2">
                        <label for="visibility_public" class="mr-4">Public</label>
                        <input type="radio" name="visibility" id="visibility_private" value="private" class="mr-2">
                        <label for="visibility_private">Private</label>
                    </div>
                </div>

                <!-- User Selection -->
                <div id="user_selection" class="hidden">
                    <label class="block text-sm font-medium text-gray-700">Select Users</label>
                    <div class="mt-2 border border-gray-300 rounded-md">
                        <div class="flex border-b border-gray-300">
                            <button type="button" id="admin_tab" class="px-4 py-2 bg-gray-100 w-full text-left font-medium">Admins</button>
                            <button type="button" id="customer_tab" class="px-4 py-2 w-full text-left">Customers</button>
                        </div>
                        <div id="admin_list" class="p-4">
                            @foreach ($admins as $user)
                                <div class="flex items-center">
                                    <input type="checkbox" name="users[]" value="{{ $user->id }}" id="user_{{ $user->id }}" class="mr-2">
                                    <label for="user_{{ $user->id }}">{{ $user->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div id="customer_list" class="p-4 hidden">
                            @foreach ($customers as $user)
                                <div class="flex items-center">
                                    <input type="checkbox" name="users[]" value="{{ $user->id }}" id="user_{{ $user->id }}" class="mr-2">
                                    <label for="user_{{ $user->id }}">{{ $user->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('staff.posts.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition mr-2">
                    Cancel
                </a>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                    Create Post
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const visibilityRadios = document.querySelectorAll('input[name="visibility"]');
        const userSelection = document.getElementById('user_selection');
        const adminTab = document.getElementById('admin_tab');
        const customerTab = document.getElementById('customer_tab');
        const adminList = document.getElementById('admin_list');
        const customerList = document.getElementById('customer_.list');

        visibilityRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (document.getElementById('visibility_private').checked) {
                    userSelection.classList.remove('hidden');
                } else {
                    userSelection.classList.add('hidden');
                }
            });
        });

        adminTab.addEventListener('click', () => {
            adminList.classList.remove('hidden');
            customerList.classList.add('hidden');
            adminTab.classList.add('bg-gray-100');
            customerTab.classList.remove('bg-gray-100');
        });

        customerTab.addEventListener('click', () => {
            customerList.classList.remove('hidden');
            adminList.classList.add('hidden');
            customerTab.classList.add('bg-gray-100');
            adminTab.classList.remove('bg-gray-100');
        });
    });
</script>
@endpush
