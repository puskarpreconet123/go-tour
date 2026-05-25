@extends('admin.layout')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-bold text-gray-800">Content Management System (CMS)</h2>
    <p class="text-gray-500 mt-2">Manage your website's static pages.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Tabs Header -->
    <div class="flex border-b border-gray-100">
        <button onclick="switchTab('about')" id="tab-about" class="cms-tab flex-1 py-4 px-6 text-center font-semibold text-red-600 border-b-2 border-red-600 hover:bg-gray-50 transition-colors">
            About Us
        </button>
        <button onclick="switchTab('privacy')" id="tab-privacy" class="cms-tab flex-1 py-4 px-6 text-center font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:bg-gray-50 transition-colors">
            Privacy Policy
        </button>
        <button onclick="switchTab('terms')" id="tab-terms" class="cms-tab flex-1 py-4 px-6 text-center font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:bg-gray-50 transition-colors">
            Terms &amp; Conditions
        </button>
    </div>

    <!-- Tabs Content -->
    <div class="p-8">
        <!-- About Us Content -->
        <div id="content-about" class="cms-content space-y-6 block">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-800">About Us</h3>
                <div class="flex gap-2">
                    <button id="edit-btn-about" onclick="enableEdit('about')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">edit</span> Edit Content
                    </button>
                    <button id="save-btn-about" onclick="saveContent('about')" class="hidden bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">save</span> Save
                    </button>
                    <button id="cancel-btn-about" onclick="cancelEdit('about')" class="hidden bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">close</span> Cancel
                    </button>
                </div>
            </div>
            <!-- View Mode -->
            <div id="view-about" class="prose max-w-none text-gray-600 bg-gray-50 p-6 rounded-lg border border-gray-100">
                @if(!empty($cmsContents['about']))
                    {!! $cmsContents['about'] !!}
                @else
                <h4 class="text-lg font-bold text-gray-800 mb-2">Our Story</h4>
                <p class="mb-4">Welcome to New Universal Travels Pvt. Ltd. Founded with a passion for exploration, we have been providing world-class travel experiences for over a decade. Our mission is to make international travel accessible, seamless, and unforgettable for everyone.</p>

                <h4 class="text-lg font-bold text-gray-800 mb-2 mt-6">Why Choose Us?</h4>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Expertise in international tour packages and custom itineraries.</li>
                    <li>24/7 dedicated customer support.</li>
                    <li>Comprehensive visa and passport assistance.</li>
                    <li>Exclusive deals and partnerships with top-rated hotels globally.</li>
                </ul>
                @endif
            </div>
            <!-- Edit Mode -->
            <div id="edit-about" class="hidden space-y-3">
                <p class="text-sm text-gray-500">You can use basic HTML tags for formatting (e.g. &lt;h4&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;).</p>
                <textarea id="textarea-about" rows="14" class="w-full border border-gray-300 rounded-lg p-4 text-sm font-mono text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500 resize-y"></textarea>
            </div>
            <!-- Success/Error Message -->
            <div id="msg-about" class="hidden"></div>
        </div>

        <!-- Privacy Policy Content -->
        <div id="content-privacy" class="cms-content space-y-6 hidden">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Privacy Policy</h3>
                <div class="flex gap-2">
                    <button id="edit-btn-privacy" onclick="enableEdit('privacy')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">edit</span> Edit Content
                    </button>
                    <button id="save-btn-privacy" onclick="saveContent('privacy')" class="hidden bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">save</span> Save
                    </button>
                    <button id="cancel-btn-privacy" onclick="cancelEdit('privacy')" class="hidden bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">close</span> Cancel
                    </button>
                </div>
            </div>
            <!-- View Mode -->
            <div id="view-privacy" class="prose max-w-none text-gray-600 bg-gray-50 p-6 rounded-lg border border-gray-100">
                @if(!empty($cmsContents['privacy']))
                    {!! $cmsContents['privacy'] !!}
                @else
                <p class="mb-4 text-sm text-gray-400">Last updated: May 25, 2026</p>
                <h4 class="text-lg font-bold text-gray-800 mb-2">1. Information We Collect</h4>
                <p class="mb-4">We collect personal information that you provide to us when registering, booking a tour, or contacting our support team. This includes your name, email address, phone number, and passport details.</p>

                <h4 class="text-lg font-bold text-gray-800 mb-2">2. How We Use Your Information</h4>
                <p class="mb-4">Your information is used strictly to process bookings, arrange travel logistics, and communicate updates regarding your trips. We do not sell your personal data to third parties.</p>

                <h4 class="text-lg font-bold text-gray-800 mb-2">3. Data Security</h4>
                <p>We implement a variety of security measures to maintain the safety of your personal information when you place a booking or enter, submit, or access your personal information.</p>
                @endif
            </div>
            <!-- Edit Mode -->
            <div id="edit-privacy" class="hidden space-y-3">
                <p class="text-sm text-gray-500">You can use basic HTML tags for formatting (e.g. &lt;h4&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;).</p>
                <textarea id="textarea-privacy" rows="14" class="w-full border border-gray-300 rounded-lg p-4 text-sm font-mono text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500 resize-y"></textarea>
            </div>
            <!-- Success/Error Message -->
            <div id="msg-privacy" class="hidden"></div>
        </div>

        <!-- Terms and Conditions Content -->
        <div id="content-terms" class="cms-content space-y-6 hidden">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Terms and Conditions</h3>
                <div class="flex gap-2">
                    <button id="edit-btn-terms" onclick="enableEdit('terms')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">edit</span> Edit Content
                    </button>
                    <button id="save-btn-terms" onclick="saveContent('terms')" class="hidden bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">save</span> Save
                    </button>
                    <button id="cancel-btn-terms" onclick="cancelEdit('terms')" class="hidden bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">close</span> Cancel
                    </button>
                </div>
            </div>
            <!-- View Mode -->
            <div id="view-terms" class="prose max-w-none text-gray-600 bg-gray-50 p-6 rounded-lg border border-gray-100">
                @if(!empty($cmsContents['terms']))
                    {!! $cmsContents['terms'] !!}
                @else
                <h4 class="text-lg font-bold text-gray-800 mb-2">1. Acceptance of Terms</h4>
                <p class="mb-4">By accessing and using our website and services, you accept and agree to be bound by the terms and provision of this agreement.</p>

                <h4 class="text-lg font-bold text-gray-800 mb-2">2. Booking and Payments</h4>
                <p class="mb-4">All bookings are subject to availability. A deposit is required at the time of booking. Full payment must be received at least 30 days prior to departure. We reserve the right to cancel bookings if payment is not received in time.</p>

                <h4 class="text-lg font-bold text-gray-800 mb-2">3. Cancellations and Refunds</h4>
                <p>Cancellations made 60 days or more before departure are eligible for a full refund minus a small administrative fee. Cancellations made within 30 days of departure are non-refundable.</p>
                @endif
            </div>
            <!-- Edit Mode -->
            <div id="edit-terms" class="hidden space-y-3">
                <p class="text-sm text-gray-500">You can use basic HTML tags for formatting (e.g. &lt;h4&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;).</p>
                <textarea id="textarea-terms" rows="14" class="w-full border border-gray-300 rounded-lg p-4 text-sm font-mono text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500 resize-y"></textarea>
            </div>
            <!-- Success/Error Message -->
            <div id="msg-terms" class="hidden"></div>
        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // Reset all tabs
        document.querySelectorAll('.cms-tab').forEach(tab => {
            tab.classList.remove('text-red-600', 'border-red-600');
            tab.classList.add('text-gray-500', 'border-transparent');
        });

        // Reset all content
        document.querySelectorAll('.cms-content').forEach(content => {
            content.classList.remove('block');
            content.classList.add('hidden');
        });

        // Activate selected tab
        const activeTab = document.getElementById('tab-' + tabId);
        activeTab.classList.remove('text-gray-500', 'border-transparent');
        activeTab.classList.add('text-red-600', 'border-red-600');

        // Show selected content
        const activeContent = document.getElementById('content-' + tabId);
        activeContent.classList.remove('hidden');
        activeContent.classList.add('block');
    }

    function enableEdit(section) {
        const viewEl   = document.getElementById('view-' + section);
        const editEl   = document.getElementById('edit-' + section);
        const textarea = document.getElementById('textarea-' + section);

        // Populate textarea with current HTML content
        textarea.value = viewEl.innerHTML.trim();

        // Toggle visibility
        viewEl.classList.add('hidden');
        editEl.classList.remove('hidden');

        // Toggle buttons
        document.getElementById('edit-btn-' + section).classList.add('hidden');
        document.getElementById('save-btn-' + section).classList.remove('hidden');
        document.getElementById('cancel-btn-' + section).classList.remove('hidden');

        // Clear any previous messages
        const msg = document.getElementById('msg-' + section);
        msg.classList.add('hidden');
        msg.innerHTML = '';
    }

    function cancelEdit(section) {
        const viewEl = document.getElementById('view-' + section);
        const editEl = document.getElementById('edit-' + section);

        // Restore view
        viewEl.classList.remove('hidden');
        editEl.classList.add('hidden');

        // Toggle buttons
        document.getElementById('edit-btn-' + section).classList.remove('hidden');
        document.getElementById('save-btn-' + section).classList.add('hidden');
        document.getElementById('cancel-btn-' + section).classList.add('hidden');

        // Hide message
        const msg = document.getElementById('msg-' + section);
        msg.classList.add('hidden');
        msg.innerHTML = '';
    }

    function saveContent(section) {
        const viewEl   = document.getElementById('view-' + section);
        const textarea = document.getElementById('textarea-' + section);
        const saveBtn  = document.getElementById('save-btn-' + section);
        const msg      = document.getElementById('msg-' + section);

        const newContent = textarea.value.trim();
        if (!newContent) {
            showMessage(section, 'error', 'Content cannot be empty.');
            return;
        }

        // Disable save button while processing
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">autorenew</span> Saving…';

        // Send to backend
        fetch('{{ route("admin.cms.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ section: section, content: newContent })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update view with new content
                viewEl.innerHTML = newContent;
                cancelEdit(section);
                showMessage(section, 'success', 'Content saved successfully!');
            } else {
                showMessage(section, 'error', data.message || 'Failed to save. Please try again.');
            }
        })
        .catch(() => {
            showMessage(section, 'error', 'Network error. Please try again.');
        })
        .finally(() => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<span class="material-symbols-outlined text-sm">save</span> Save';
        });
    }

    function showMessage(section, type, text) {
        const msg = document.getElementById('msg-' + section);
        msg.classList.remove('hidden');
        const isSuccess = type === 'success';
        msg.className = `text-sm px-4 py-3 rounded-lg ${isSuccess ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'}`;
        msg.innerHTML = `<span class="material-symbols-outlined text-sm align-middle mr-1">${isSuccess ? 'check_circle' : 'error'}</span>${text}`;

        if (isSuccess) {
            setTimeout(() => {
                msg.classList.add('hidden');
                msg.innerHTML = '';
            }, 3000);
        }
    }
</script>
@endsection
