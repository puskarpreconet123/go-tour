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

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-[350px] flex flex-col">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Revenue Overview</h3>
        <div class="flex-1 relative w-full min-h-0">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-[350px] flex flex-col">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Bookings by Category</h3>
        <div class="flex-1 relative w-full min-h-0 flex justify-center">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

<h3 class="text-xl font-bold text-gray-800 mb-4">Recent Bookings</h3>
<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-900 border-b border-slate-800">
                <th class="p-4 text-sm font-semibold text-slate-200">ID</th>
                <th class="p-4 text-sm font-semibold text-slate-200">User</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Type</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Status</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Amount</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentBookings as $booking)
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="p-4 text-sm text-gray-800">#{{ $booking->id }}</td>
                <td class="p-4 text-sm text-gray-800">{{ $booking->user->name ?? 'Unknown' }}</td>
                <td class="p-4 text-sm text-gray-800 capitalize">{{ $booking->type }}</td>
                <td class="p-4 text-sm">
                    <span class="px-2.5 py-1 text-xs font-bold rounded-xl border uppercase tracking-wider
                        @if($booking->status == 'upcoming' || $booking->status == 'approved' || $booking->status == 'completed') bg-emerald-50 text-emerald-800 border-emerald-100
                        @elseif($booking->status == 'cancelled' || $booking->status == 'rejected') bg-rose-50 text-rose-800 border-rose-100
                        @else bg-amber-50 text-amber-800 border-amber-100 @endif">
                        {{ $booking->status }}
                    </span>
                </td>
                <td class="p-4 text-sm text-gray-800">₹{{ number_format($booking->total_amount, 2) }}</td>
                <td class="p-4 text-sm font-medium">
                    <button onclick="showDetailsModal('Booking Details', { 'Booking ID': '#{{ $booking->id }}', 'User': '{{ addslashes($booking->user->name ?? 'Unknown') }}', 'Type': '{{ addslashes($booking->type) }}', 'Status': '{{ addslashes($booking->status) }}', 'Amount': '₹{{ number_format($booking->total_amount, 2) }}' })" class="text-amber-800 hover:text-amber-900 bg-amber-50 hover:bg-amber-100/80 border border-amber-200/40 px-3.5 py-1.5 rounded-xl transition-all duration-200 text-xs font-bold shadow-sm">Details</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart (Line)
        const ctxRev = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRev, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Revenue (₹)',
                    data: [65000, 59000, 80000, 81000, 56000, 95000, 110000],
                    borderColor: '#E61E25',
                    backgroundColor: 'rgba(230, 30, 37, 0.08)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#E61E25',
                    pointHoverBackgroundColor: '#00A651',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Category Chart (Doughnut)
        const ctxCat = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: ['Hotels', 'Flights', 'Trains', 'Events'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: [
                        '#E61E25', // Brand Red
                        '#00A651', // Brand Green
                        '#1e293b', // Dark Slate
                        '#94a3b8'  // Medium Slate
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { 
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
