@props(['color' => 'text-white'])

<div x-data="{ dropdownOpen: false, notificationCount: {{ auth()->user()->unreadNotifications()->count() }} }" class="relative">
    <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-md p-2 focus:outline-none">
        <svg class="h-6 w-6 {{ $color }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <template x-if="notificationCount > 0">
            <div class="absolute top-0 right-0 -mt-1 -mr-1 px-2 py-1 bg-red-500 text-white text-xs rounded-full" x-text="notificationCount"></div>
        </template>
    </button>

    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-20">
        <div class="py-2">
            @forelse (auth()->user()->unreadNotifications as $notification)
                <div class="flex items-center px-4 py-3 border-b hover:bg-gray-100 -mx-2">
                    <p class="text-gray-600 text-sm mx-2">
                        {{ $notification->data['message'] }}
                    </p>
                    @if (is_null($notification->read_at))
                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-blue-500 hover:underline">Mark as read</button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-gray-600 text-sm mx-2 px-4 py-3">No new notifications</p>
            @endforelse
        </div>
        @php
            $seeAllUrl = '#';
            if (auth()->user()->hasRole('admin')) {
                $seeAllUrl = route('admin.posts.index', ['view' => 'notifications']);
            } elseif (auth()->user()->hasRole('staff')) {
                $seeAllUrl = route('staff.posts.index', ['view' => 'notifications']);
            } elseif (auth()->user()->hasRole('customer')) {
                $seeAllUrl = route('customer.posts.index', ['view' => 'notifications']);
            }
        @endphp
        <a href="{{ $seeAllUrl }}" class="block bg-gray-800 text-white text-center font-bold py-2">See all notifications</a>
    </div>
</div>
