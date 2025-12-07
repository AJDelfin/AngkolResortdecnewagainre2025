@extends('layouts.admin')

@section('header', 'View Employee')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="mb-6">
            <h2 class="text-2xl font-headline">{{ $employee->name }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-600 font-semibold">Email:</p>
                <p>{{ $employee->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Position:</p>
                <p>{{ $employee->position }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-semibold">Joined On:</p>
                <p>{{ $employee->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('admin.employees.index') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-green-800 transition">
                Back to List
            </a>
        </div>
    </div>
@endsection
