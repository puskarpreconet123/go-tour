@extends('admin.layout')

@section('content')
<h2 class="text-3xl font-bold text-gray-800 mb-6">All Bookings</h2>

<div class="bg-white rounded-lg shadow-sm overflow-x-auto border border-gray-100">
    <table class="w-full text-left border-collapse whitespace-nowrap min-w-max">
        <thead>
            <tr class="bg-slate-900 border-b border-slate-800">
                <th class="p-4 text-sm font-semibold text-slate-200">ID</th>
                <th class="p-4 text-sm font-semibold text-slate-200">User</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Type</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Destination</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Status</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Amount</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Date</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="p-4 text-sm text-gray-800">#{{ $booking->id }}</td>
                <td class="p-4 text-sm text-gray-800">{{ $booking->user->name ?? 'Unknown' }}</td>
                <td class="p-4 text-sm text-gray-800 capitalize">{{ $booking->type }}</td>
                <td class="p-4 text-sm text-gray-800">{{ $booking->destination->name ?? 'N/A' }}</td>
                <td class="p-4 text-sm">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">{{ $booking->status }}</span>
                </td>
                <td class="p-4 text-sm text-gray-800">₹{{ number_format($booking->total_amount, 2) }}</td>
                <td class="p-4 text-sm text-gray-500">{{ $booking->created_at->format('M d, Y') }}</td>
                <td class="p-4 text-sm font-medium flex items-center">
                    <button onclick="showDetailsModal('Booking Details', { 'Booking ID': '#{{ $booking->id }}', 'User': '{{ addslashes($booking->user->name ?? 'Unknown') }}', 'Type': '{{ addslashes($booking->type) }}', 'Destination': '{{ addslashes($booking->destination->name ?? 'N/A') }}', 'Status': '{{ addslashes($booking->status) }}', 'Amount': '₹{{ number_format($booking->total_amount, 2) }}', 'Date': '{{ $booking->created_at->format('M d, Y') }}' })" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition-colors">Details</button>
                    <form action="/admin/bookings/{{ $booking->id }}/status" method="POST" class="inline-block ml-2">
                        @csrf
                        <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-200 rounded p-1 bg-white text-gray-700 outline-none focus:border-red-500 hover:bg-gray-50 cursor-pointer">
                            <option value="upcoming" {{ $booking->status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="past" {{ $booking->status == 'past' ? 'selected' : '' }}>Past</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
