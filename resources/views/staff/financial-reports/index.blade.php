@extends('layouts.staff')

@section('header', 'Financial Reports')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-headline">All Financial Reports</h2>
        </div>

        <!-- Financial Reports Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Title</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Report Date</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Total Revenue</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Total Expense</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Net Profit</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($financialReports as $report)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $report->title }}</td>
                            <td class="py-3 px-4">{{ $report->report_date }}</td>
                            <td class="py-3 px-4 text-green-600">{{ number_format($report->items->where('type', 'revenue')->sum('amount'), 2) }}</td>
                            <td class="py-3 px-4 text-red-600">{{ number_format($report->items->where('type', 'expense')->sum('amount'), 2) }}</td>
                            <td class="py-3 px-4 font-bold">{{ number_format($report->items->where('type', 'revenue')->sum('amount') - $report->items->where('type', 'expense')->sum('amount'), 2) }}</td>
                            <td class="py-3 px-4 flex items-center space-x-2">
                                <a href="{{ route('staff.financial-reports.show', $report) }}" class="text-green-500 hover:text-green-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">No financial reports found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $financialReports->links() }}
        </div>
    </div>
@endsection
