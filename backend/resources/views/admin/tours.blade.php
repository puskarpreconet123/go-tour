@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-gray-800">Manage Tours</h2>
    <button class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition-colors flex items-center gap-2">
        <span class="material-symbols-outlined text-sm">add</span> Add Tour
    </button>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="p-4 text-sm font-semibold text-gray-600">ID</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Name</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Category</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Price</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tours as $tour)
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="p-4 text-sm text-gray-800">#{{ $tour->id }}</td>
                <td class="p-4 text-sm text-gray-800 font-medium">{{ $tour->name }}</td>
                <td class="p-4 text-sm text-gray-800 capitalize">{{ $tour->category ?? 'General' }}</td>
                <td class="p-4 text-sm text-gray-800">₹{{ number_format($tour->price ?? 0, 2) }}</td>
                <td class="p-4 text-sm font-medium flex gap-2">
                    <button class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md transition-colors">Edit</button>
                    <button class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition-colors">Delete</button>
                </td>
            </tr>
            @endforeach
            @if($tours->isEmpty())
            <tr>
                <td colspan="5" class="p-8 text-center text-gray-500">No tours available.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
