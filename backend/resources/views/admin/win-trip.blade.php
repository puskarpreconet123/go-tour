@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-bold text-gray-800">Win Trip Campaigns</h2>
    <button onclick="toggleCreateForm()" class="bg-gradient-to-r from-red-700 to-red-600 text-white font-bold px-5 py-2.5 rounded-xl shadow-md hover:from-red-800 hover:to-red-700 transition-all duration-200 flex items-center gap-2 text-sm">
        <span class="material-symbols-outlined text-sm">add</span>
        Create Campaign
    </button>
</div>

<!-- Errors display -->
@if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
        <ul class="list-disc pl-5 text-sm font-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Create Campaign Card (collapsible) -->
<div id="create-campaign-card" class="hidden bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 transition-all duration-300">
    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-red-700">card_giftcard</span>
        New Lucky Draw Campaign
    </h3>
    <form action="/admin/win-trip" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Select Destination/Package -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Select Package</label>
                <select name="destination_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500">
                    <option value="" disabled selected>Choose a trip...</option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination->id }}">{{ $destination->title }} (ID: {{ $destination->id }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Ticket Price -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Ticket Price (₹)</label>
                <input type="number" name="ticket_price" step="0.01" min="0" placeholder="0.00" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500">
            </div>

            <!-- Start Date -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Start Date</label>
                <input type="datetime-local" name="start_date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500">
            </div>

            <!-- End Date -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">End Date</label>
                <input type="datetime-local" name="end_date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500">
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="toggleCreateForm()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl font-bold text-sm transition-colors">Cancel</button>
            <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-colors shadow-sm">Save Campaign</button>
        </div>
    </form>
</div>

<!-- Campaigns List Table -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-900 border-b border-slate-800">
                <th class="p-4 text-xs font-bold text-slate-200 uppercase tracking-wider">ID</th>
                <th class="p-4 text-xs font-bold text-slate-200 uppercase tracking-wider">Trip Package</th>
                <th class="p-4 text-xs font-bold text-slate-200 uppercase tracking-wider">Ticket Price</th>
                <th class="p-4 text-xs font-bold text-slate-200 uppercase tracking-wider">Dates</th>
                <th class="p-4 text-xs font-bold text-slate-200 uppercase tracking-wider">Tickets Bought</th>
                <th class="p-4 text-xs font-bold text-slate-200 uppercase tracking-wider">Winner</th>
                <th class="p-4 text-xs font-bold text-slate-200 uppercase tracking-wider text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($luckyDraws as $draw)
            <tr class="hover:bg-slate-50/55 transition-colors">
                <td class="p-4 text-sm font-semibold text-gray-500">#{{ $draw->id }}</td>
                <td class="p-4">
                    <span class="text-sm font-bold text-gray-800 block">{{ $draw->destination->title ?? 'N/A' }}</span>
                    <span class="text-xs text-slate-400">Loc: {{ $draw->destination->location ?? 'N/A' }}</span>
                </td>
                <td class="p-4 text-sm font-bold text-slate-700">₹{{ number_format($draw->ticket_price, 2) }}</td>
                <td class="p-4 text-xs">
                    <div class="text-slate-600 font-medium">Start: {{ $draw->start_date->format('M d, Y h:i A') }}</div>
                    <div class="text-slate-400 mt-0.5">End: {{ $draw->end_date->format('M d, Y h:i A') }}</div>
                </td>
                <td class="p-4">
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                        {{ $draw->tickets->count() }} Tickets
                    </span>
                </td>
                <td class="p-4">
                    @if($draw->status == 'finished')
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-green-600 text-lg">workspace_premium</span>
                            <div>
                                <span class="text-sm font-bold text-green-700 block leading-tight">{{ $draw->winner->name ?? 'Unknown User' }}</span>
                                <span class="text-[10px] text-slate-400">{{ $draw->winner->email ?? 'N/A' }}</span>
                            </div>
                        </div>
                    @else
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 border border-amber-100">
                            Active / Drawing Pending
                        </span>
                    @endif
                </td>
                <td class="p-4 text-right">
                    <div class="flex justify-end items-center gap-2">
                        @if($draw->status == 'active')
                            <!-- Draw Winner Action -->
                            <form action="/admin/win-trip/{{ $draw->id }}/draw" method="POST" onsubmit="return confirm('Are you sure you want to DRAW a random winner for this campaign? This action is irreversible.');">
                                @csrf
                                <button type="submit" class="bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1 shadow-sm">
                                    <span class="material-symbols-outlined text-xs">emoji_events</span>
                                    Draw Winner
                                </button>
                            </form>

                            <!-- Extend Date Trigger -->
                            <button onclick="openExtendModal({{ $draw->id }}, '{{ $draw->end_date->format('Y-m-d\TH:i') }}')" class="bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1 shadow-sm">
                                <span class="material-symbols-outlined text-xs">schedule</span>
                                Extend Date
                            </button>
                        @endif

                        <!-- Remove Action -->
                        <form action="/admin/win-trip/{{ $draw->id }}" method="POST" onsubmit="return confirm('Are you sure you want to REMOVE this campaign? All tickets and logs will be permanently deleted.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1 shadow-sm">
                                <span class="material-symbols-outlined text-xs">delete</span>
                                Remove
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="p-12 text-center">
                    <div class="flex flex-col items-center justify-center text-slate-400">
                        <span class="material-symbols-outlined text-5xl mb-3 text-slate-300">card_giftcard</span>
                        <h4 class="font-bold text-slate-700">No campaigns found</h4>
                        <p class="text-xs mt-1">Create a new lucky draw campaign to start promotions!</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Extend Modal -->
<div id="extend-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm" onclick="closeExtendModal()"></div>
    <div class="bg-white rounded-2xl shadow-xl z-10 w-full max-w-sm mx-4 overflow-hidden border border-slate-100 transform scale-95 transition-transform duration-200">
        <div class="bg-slate-900 px-6 py-4 flex justify-between items-center">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-400 text-base">schedule</span>
                Extend End Date
            </h3>
            <button onclick="closeExtendModal()" class="text-slate-400 hover:text-white transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
        <form id="extend-form" method="POST">
            @csrf
            <div class="p-6">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">New End Date</label>
                <input type="datetime-local" name="end_date" id="modal-end-date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500">
            </div>
            <div class="bg-slate-50 px-6 py-4 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeExtendModal()" class="bg-slate-200 text-slate-800 hover:bg-slate-300 px-4 py-2 rounded-xl text-xs font-semibold transition-colors">Cancel</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-semibold transition-colors shadow-sm">Save Extension</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleCreateForm() {
        const formCard = document.getElementById('create-campaign-card');
        formCard.classList.toggle('hidden');
    }

    function openExtendModal(id, currentEndDate) {
        const modal = document.getElementById('extend-modal');
        const form = document.getElementById('extend-form');
        const input = document.getElementById('modal-end-date');
        
        form.action = `/admin/win-trip/${id}/extend`;
        input.value = currentEndDate;

        modal.classList.remove('hidden');
    }

    function closeExtendModal() {
        const modal = document.getElementById('extend-modal');
        modal.classList.add('hidden');
    }
</script>
@endsection
