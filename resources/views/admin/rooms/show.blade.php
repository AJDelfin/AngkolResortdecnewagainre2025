@extends('layouts.admin')

@section('header', 'Room Details')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-headline">Room Details</h2>
            <a href="{{ route('admin.rooms.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Back to List
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Room Information</h3>
                <dl class="mt-4 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Room Number</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $room->room_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $room->type }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Price Per Night</dt>
                        <dd class="mt-1 text-sm text-gray-900">${{ number_format($room->price_per_night, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @switch($room->status)
                                    @case('available')
                                        bg-green-100 text-green-800
                                        @break
                                    @case('occupied')
                                        bg-red-100 text-red-800
                                        @break
                                    @case('maintenance')
                                        bg-yellow-100 text-yellow-800
                                        @break
                                @endswitch
                            ">
                                {{ ucfirst($room->status) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $room->description }}</dd>
                    </div>
                </dl>
            </div>
            @if($room->image_path)
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Room Image</h3>
                    <div class="mt-4">
                        <img src="{{ $room->image_path }}" alt="Room image" class="h-64 w-auto rounded-md shadow-lg">
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
