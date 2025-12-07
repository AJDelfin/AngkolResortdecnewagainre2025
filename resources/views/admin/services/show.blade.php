@extends('layouts.admin')

@section('header', 'Service Details')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="mb-4">
        <h2 class="text-2xl font-bold">{{ $service->name }}</h2>
        <p class="text-gray-600">{{ $service->description }}</p>
    </div>
    <div class="mb-4">
        <p><span class="font-bold">Price:</span> ${{ number_format($service->price, 2) }}</p>
    </div>
    <div class="mb-4">
        <p><span class="font-bold">Status:</span>
            @if($service->is_available)
                <span class="bg-green-500 text-white py-1 px-3 rounded-full text-xs">Available</span>
            @else
                <span class="bg-red-500 text-white py-1 px-3 rounded-full text-xs">Unavailable</span>
            @endif
        </p>
    </div>
    <div class="flex items-center justify-between mt-6">
        <a href="{{ route('admin.services.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Back to List</a>
        <div>
            <a href="{{ route('admin.services.edit', $service->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>
            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection