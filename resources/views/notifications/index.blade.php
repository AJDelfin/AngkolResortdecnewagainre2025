@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Notifications</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        @forelse ($notifications as $notification)
            <div class="flex items-center justify-between py-4 border-b">
                <div>
                    <p class="text-gray-600">{{ $notification->data['message'] }}</p>
                    <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                @if (is_null($notification->read_at))
                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-blue-500">Mark as read</button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-gray-600">No notifications</p>
        @endforelse

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection
