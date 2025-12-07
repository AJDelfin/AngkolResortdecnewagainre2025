<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-6">Posts</h1>
                    <div class="space-y-8">
                        @forelse ($posts as $post)
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h2 class="text-xl font-bold">{{ $post->title }}</h2>
                                <p class="text-sm text-gray-500 mb-4">{{ $post->created_at->format('d M Y') }}</p>
                                @if ($post->image_path)
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-md mb-4">
                                @endif
                                <div class="prose max-w-none">
                                    {!! $post->content !!}
                                </div>
                            </div>
                        @empty
                            <p>No posts to display.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
