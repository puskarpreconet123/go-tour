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
                    <span class="px-2.5 py-1 text-xs font-bold rounded-xl border uppercase tracking-wider
                        @if($booking->status == 'upcoming' || $booking->status == 'approved' || $booking->status == 'completed') bg-emerald-50 text-emerald-800 border-emerald-100
                        @elseif($booking->status == 'cancelled' || $booking->status == 'rejected') bg-rose-50 text-rose-800 border-rose-100
                        @else bg-amber-50 text-amber-800 border-amber-100 @endif">
                        {{ $booking->status }}
                    </span>
                </td>
                <td class="p-4 text-sm text-gray-800">₹{{ number_format($booking->total_amount, 2) }}</td>
                <td class="p-4 text-sm text-gray-500">{{ $booking->created_at->format('M d, Y') }}</td>
                <td class="p-4 text-sm font-medium flex items-center gap-2">
                    <button onclick="showDetailsModal('Booking Details', { 'Booking ID': '#{{ $booking->id }}', 'User': '{{ addslashes($booking->user->name ?? 'Unknown') }}', 'Type': '{{ addslashes($booking->type) }}', 'Destination': '{{ addslashes($booking->destination->name ?? 'N/A') }}', 'Status': '{{ addslashes($booking->status) }}', 'Amount': '₹{{ number_format($booking->total_amount, 2) }}', 'Date': '{{ $booking->created_at->format('M d, Y') }}' })" class="text-amber-800 hover:text-amber-900 bg-amber-50 hover:bg-amber-100/80 border border-amber-200/40 px-3.5 py-1.5 rounded-xl transition-all duration-200 text-xs font-bold shadow-sm">Details</button>
                    <form action="/admin/bookings/{{ $booking->id }}/status" method="POST" class="inline-block">
                        @csrf
                        <select name="status" onchange="this.form.submit()" class="text-xs border border-amber-200/50 rounded-xl px-2.5 py-1.5 bg-amber-50/50 text-amber-800 outline-none focus:border-amber-450 hover:bg-amber-100/50 cursor-pointer font-bold transition-all duration-200">
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
