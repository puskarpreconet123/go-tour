@extends('admin.layout')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Users</h2>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-slate-900 border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">Joined Date</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-xl border bg-purple-50 text-purple-800 border-purple-100 uppercase tracking-wider">
                                        Admin
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-xl border bg-sky-50 text-sky-800 border-sky-100 uppercase tracking-wider">
                                        User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <button onclick="showDetailsModal('User Details', { 'Name': '{{ addslashes($user->name) }}', 'Email': '{{ addslashes($user->email) }}', 'Role': '{{ addslashes($user->role) }}', 'Joined Date': '{{ $user->created_at->format('M d, Y H:i') }}' })" class="text-amber-800 hover:text-amber-900 bg-amber-50 hover:bg-amber-100/80 border border-amber-200/40 px-3.5 py-1.5 rounded-xl transition-all duration-200 text-xs font-bold shadow-sm">Details</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
