<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            News & Notifications
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div x-data="{ activeTab: '{{ $view }}' }">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                         <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <a href="#" @click.prevent="activeTab = 'posts'" :class="{ 'border-primary text-primary': activeTab === 'posts', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'posts' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                News & Announcements
                            </a>
                            <a href="#" @click.prevent="activeTab = 'notifications'" :class="{ 'border-primary text-primary': activeTab === 'notifications', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'notifications' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                My Notifications
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-white">
                                        {{ Auth::user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>
                        </nav>
                    </div>

                    <!-- Posts Tab Content -->
                    <div x-show="activeTab === 'posts'">
                        @forelse ($posts as $post)
                            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                                <h2 class="text-2xl font-bold text-dark mb-2">{{ $post->title }}</h2>
                                <p class="text-gray-500 text-sm mb-4">Posted on {{ $post->created_at->format('F d, Y') }}</p>
                                <div class="prose max-w-none text-gray-700">
                                    {!! $post->content !!}
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                                <p class="text-gray-600">No news or announcements at the moment.</p>
                            </div>
                        @endforelse
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    </div>

                    <!-- Notifications Tab Content -->
                    <div x-show="activeTab === 'notifications'">
                         <div class="bg-white shadow-md rounded-lg">
                            @forelse ($notifications as $notification)
                                <div class="flex items-center justify-between p-6 border-b last:border-b-0">
                                    <div>
                                        <p class="text-gray-700">{{ $notification->data['message'] }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        @if (is_null($notification->read_at))
                                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs text-blue-500 hover:underline">Mark as read</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn text-xs text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center">
                                    <p class="text-gray-600">You have no notifications.</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
