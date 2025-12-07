@extends('layouts.admin')

@section('header', 'View Post')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
                <p class="text-gray-600">Posted by {{ optional($post->user)->name ?? 'N/A' }} on {{ $post->created_at->format('M d, Y') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.posts.edit', $post) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @if ($post->image_path)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="h-auto rounded-lg" style="width: 250px;">
            </div>
        @endif

        <div class="prose max-w-none">
            {!! $post->content !!}
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.posts.index') }}" class="text-blue-500 hover:underline">Back to all posts</a>
        </div>
    </div>
@endsection
