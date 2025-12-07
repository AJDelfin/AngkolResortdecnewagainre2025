<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Suspicious Activities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Suspicious Activity Report
                    </div>

                    <div class="mt-6">
                        <table class="table-auto w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">User</th>
                                    <th class="px-4 py-2">IP Address</th>
                                    <th class="px-4 py-2">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activities as $activity)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $activity->user->name ?? 'N/A' }}</td>
                                        <td class="border px-4 py-2">{{ $activity->ip_address }}</td>
                                        <td class="border px-4 py-2">{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="border px-4 py-2 text-center">No suspicious activities recorded.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{-- $activities->links() --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
