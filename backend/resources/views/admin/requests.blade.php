@extends('admin.layout')

@section('content')
<h2 class="text-3xl font-bold text-gray-800 mb-6">Visa & Passport Requests</h2>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
    <table class="w-full text-left border-collapse whitespace-nowrap min-w-max">
        <thead>
            <tr class="bg-slate-900 border-b border-slate-800">
                <th class="p-4 text-sm font-semibold text-slate-200">ID</th>
                <th class="p-4 text-sm font-semibold text-slate-200">User</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Type</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Status</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Notes</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Date</th>
                <th class="p-4 text-sm font-semibold text-slate-200">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $req)
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="p-4 text-sm text-gray-800">#{{ $req->id }}</td>
                <td class="p-4 text-sm text-gray-800">{{ $req->user->name ?? 'Unknown' }}</td>
                <td class="p-4 text-sm text-gray-800 capitalize">{{ $req->type }}</td>
                <td class="p-4 text-sm">
                    <span class="px-2.5 py-1 text-xs font-bold rounded-xl border uppercase tracking-wider
                        @if($req->status == 'approved' || $req->status == 'completed') bg-emerald-50 text-emerald-800 border-emerald-100
                        @elseif($req->status == 'rejected') bg-rose-50 text-rose-800 border-rose-100
                        @else bg-amber-50 text-amber-800 border-amber-100 @endif">
                        {{ $req->status }}
                    </span>
                </td>
                <td class="p-4 text-sm text-gray-500 max-w-xs truncate">{{ $req->notes ?? '-' }}</td>
                <td class="p-4 text-sm text-gray-500">{{ $req->created_at->format('M d, Y') }}</td>
                <td class="p-4 text-sm font-medium flex items-center gap-2">
                    <button onclick="showDetailsModal('Request Details', { 'Request ID': '#{{ $req->id }}', 'User': '{{ addslashes($req->user->name ?? 'Unknown') }}', 'Type': '{{ addslashes($req->type) }}', 'Status': '{{ addslashes($req->status) }}', 'Notes': '{{ addslashes($req->notes ?? '-') }}', 'Date': '{{ $req->created_at->format('M d, Y') }}' })" class="text-amber-800 hover:text-amber-900 bg-amber-50 hover:bg-amber-100/80 border border-amber-200/40 px-3.5 py-1.5 rounded-xl transition-all duration-200 text-xs font-bold shadow-sm">Details</button>
                    <form action="/admin/requests/{{ $req->id }}/status" method="POST" class="inline-block">
                        @csrf
                        <select name="status" onchange="this.form.submit()" class="text-xs border border-amber-200/50 rounded-xl px-2.5 py-1.5 bg-amber-50/50 text-amber-800 outline-none focus:border-amber-450 hover:bg-amber-100/50 cursor-pointer font-bold transition-all duration-200">
                            <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $req->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $req->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="completed" {{ $req->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
