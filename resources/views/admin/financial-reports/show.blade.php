@extends('layouts.admin')

@section('header', 'Financial Report Details')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-headline">{{ $financialReport->title }}</h2>
                <p class="text-gray-600">Report for {{ $financialReport->report_date }}</p>
            </div>
            <a href="{{ route('admin.financial-reports.index') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                 <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Reports
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-green-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-green-800">Total Revenue</h3>
                <p class="text-2xl font-bold text-green-600">{{ number_format($financialReport->items->where('type', 'revenue')->sum('amount'), 2) }}</p>
            </div>
            <div class="bg-red-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-red-800">Total Expenses</h3>
                <p class="text-2xl font-bold text-red-600">{{ number_format($financialReport->items->where('type', 'expense')->sum('amount'), 2) }}</p>
            </div>
            <div class="bg-blue-100 p-4 rounded-lg text-center">
                <h3 class="text-lg font-semibold text-blue-800">Net Profit</h3>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($financialReport->items->where('type', 'revenue')->sum('amount') - $financialReport->items->where('type', 'expense')->sum('amount'), 2) }}</p>
            </div>
        </div>

        <h3 class="text-xl font-headline mb-4">Report Items</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Description</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Type</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Amount</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($financialReport->items as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $item->description }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->type === 'revenue' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($item->type) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 {{ $item->type === 'revenue' ? 'text-green-600' : 'text-red-600' }}">{{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-6 text-gray-500">No items found for this report.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
