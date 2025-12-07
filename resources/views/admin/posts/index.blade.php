<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="bulk-delete-form" action="{{ route('admin.posts.bulk-destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-between items-center">
                            <h1 class="text-2xl font-bold">Posts</h1>
                            <div>
                                <button id="bulk-delete-button" type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hidden">Delete Selected</button>
                                <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md">Create Post</a>
                            </div>
                        </div>
                        <div class="mt-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input type="checkbox" id="select-all">
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Created At
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="ids[]" value="{{ $post->id }}" class="row-checkbox">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $post->title }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $post->created_at->format('d M Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.posts.edit', $post) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const bulkDeleteButton = document.getElementById('bulk-delete-button');

            function toggleBulkDeleteButton() {
                const anyChecked = Array.from(checkboxes).some(c => c.checked);
                bulkDeleteButton.classList.toggle('hidden', !anyChecked);
            }

            selectAll.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                toggleBulkDeleteButton();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    if (!this.checked) {
                        selectAll.checked = false;
                    }
                    toggleBulkDeleteButton();
                });
            });

            document.getElementById('bulk-delete-form').addEventListener('submit', function (e) {
                if (!confirm('Are you sure you want to delete the selected posts?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</x-admin-layout>
