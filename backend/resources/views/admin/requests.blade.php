@extends('admin.layout')

@section('content')
<h2 class="text-3xl font-bold text-gray-800 mb-6">Visa & Passport Requests</h2>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
    <table class="w-full text-left border-collapse whitespace-nowrap min-w-max">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="p-4 text-sm font-semibold text-gray-600">ID</th>
                <th class="p-4 text-sm font-semibold text-gray-600">User</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Type</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Notes</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Date</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $req)
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="p-4 text-sm text-gray-800">#{{ $req->id }}</td>
                <td class="p-4 text-sm text-gray-800">{{ $req->user->name ?? 'Unknown' }}</td>
                <td class="p-4 text-sm text-gray-800 capitalize">{{ $req->type }}</td>
                <td class="p-4 text-sm">
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-medium">{{ $req->status }}</span>
                </td>
                <td class="p-4 text-sm text-gray-500 max-w-xs truncate">{{ $req->notes ?? '-' }}</td>
                <td class="p-4 text-sm text-gray-500">{{ $req->created_at->format('M d, Y') }}</td>
                <td class="p-4 text-sm font-medium flex items-center">
                    <button onclick="showDetailsModal('Request Details', { 'Request ID': '#{{ $req->id }}', 'User': '{{ addslashes($req->user->name ?? 'Unknown') }}', 'Type': '{{ addslashes($req->type) }}', 'Status': '{{ addslashes($req->status) }}', 'Notes': '{{ addslashes($req->notes ?? '-') }}', 'Date': '{{ $req->created_at->format('M d, Y') }}' })" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition-colors">Details</button>
                    <form action="/admin/requests/{{ $req->id }}/status" method="POST" class="inline-block ml-2">
                        @csrf
                        <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-200 rounded p-1 bg-white text-gray-700 outline-none focus:border-red-500 hover:bg-gray-50 cursor-pointer">
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
