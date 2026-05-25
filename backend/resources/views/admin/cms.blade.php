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
            Terms & Conditions
        </button>
    </div>

    <!-- Tabs Content -->
    <div class="p-8">
        <!-- About Us Content -->
        <div id="content-about" class="cms-content space-y-6 block">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-800">About Us</h3>
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">edit</span> Edit Content
                </button>
            </div>
            <div class="prose max-w-none text-gray-600 bg-gray-50 p-6 rounded-lg border border-gray-100">
                <h4 class="text-lg font-bold text-gray-800 mb-2">Our Story</h4>
                <p class="mb-4">Welcome to New Universal Travels Pvt. Ltd. Founded with a passion for exploration, we have been providing world-class travel experiences for over a decade. Our mission is to make international travel accessible, seamless, and unforgettable for everyone.</p>
                
                <h4 class="text-lg font-bold text-gray-800 mb-2 mt-6">Why Choose Us?</h4>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Expertise in international tour packages and custom itineraries.</li>
                    <li>24/7 dedicated customer support.</li>
                    <li>Comprehensive visa and passport assistance.</li>
                    <li>Exclusive deals and partnerships with top-rated hotels globally.</li>
                </ul>
            </div>
        </div>

        <!-- Privacy Policy Content -->
        <div id="content-privacy" class="cms-content space-y-6 hidden">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Privacy Policy</h3>
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">edit</span> Edit Content
                </button>
            </div>
            <div class="prose max-w-none text-gray-600 bg-gray-50 p-6 rounded-lg border border-gray-100">
                <p class="mb-4 text-sm text-gray-400">Last updated: May 25, 2026</p>
                <h4 class="text-lg font-bold text-gray-800 mb-2">1. Information We Collect</h4>
                <p class="mb-4">We collect personal information that you provide to us when registering, booking a tour, or contacting our support team. This includes your name, email address, phone number, and passport details.</p>
                
                <h4 class="text-lg font-bold text-gray-800 mb-2">2. How We Use Your Information</h4>
                <p class="mb-4">Your information is used strictly to process bookings, arrange travel logistics, and communicate updates regarding your trips. We do not sell your personal data to third parties.</p>
                
                <h4 class="text-lg font-bold text-gray-800 mb-2">3. Data Security</h4>
                <p>We implement a variety of security measures to maintain the safety of your personal information when you place a booking or enter, submit, or access your personal information.</p>
            </div>
        </div>

        <!-- Terms and Conditions Content -->
        <div id="content-terms" class="cms-content space-y-6 hidden">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Terms and Conditions</h3>
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">edit</span> Edit Content
                </button>
            </div>
            <div class="prose max-w-none text-gray-600 bg-gray-50 p-6 rounded-lg border border-gray-100">
                <h4 class="text-lg font-bold text-gray-800 mb-2">1. Acceptance of Terms</h4>
                <p class="mb-4">By accessing and using our website and services, you accept and agree to be bound by the terms and provision of this agreement.</p>
                
                <h4 class="text-lg font-bold text-gray-800 mb-2">2. Booking and Payments</h4>
                <p class="mb-4">All bookings are subject to availability. A deposit is required at the time of booking. Full payment must be received at least 30 days prior to departure. We reserve the right to cancel bookings if payment is not received in time.</p>
                
                <h4 class="text-lg font-bold text-gray-800 mb-2">3. Cancellations and Refunds</h4>
                <p>Cancellations made 60 days or more before departure are eligible for a full refund minus a small administrative fee. Cancellations made within 30 days of departure are non-refundable.</p>
            </div>
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
</script>
@endsection
