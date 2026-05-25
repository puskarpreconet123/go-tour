@extends('admin.layout')

@section('content')
<h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Overview</h2>

<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h3 class="text-gray-500 font-medium">Total Users</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalUsers }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h3 class="text-gray-500 font-medium">Total Bookings</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalBookings }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h3 class="text-gray-500 font-medium">Pending Requests</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalRequests }}</p>
    </div>
</div>

<h3 class="text-xl font-bold text-gray-800 mb-4">Recent Bookings</h3>
<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="p-4 text-sm font-semibold text-gray-600">ID</th>
                <th class="p-4 text-sm font-semibold text-gray-600">User</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Type</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Amount</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentBookings as $booking)
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="p-4 text-sm text-gray-800">#{{ $booking->id }}</td>
                <td class="p-4 text-sm text-gray-800">{{ $booking->user->name ?? 'Unknown' }}</td>
                <td class="p-4 text-sm text-gray-800 capitalize">{{ $booking->type }}</td>
                <td class="p-4 text-sm">
                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">{{ $booking->status }}</span>
                </td>
                <td class="p-4 text-sm text-gray-800">₹{{ number_format($booking->total_amount, 2) }}</td>
                <td class="p-4 text-sm font-medium">
                    <button onclick="alert('ID: {{ $booking->id }}\nUser: {{ addslashes($booking->user->name ?? 'Unknown') }}\nType: {{ addslashes($booking->type) }}\nStatus: {{ addslashes($booking->status) }}\nAmount: ₹{{ number_format($booking->total_amount, 2) }}')" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition-colors">Details</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
