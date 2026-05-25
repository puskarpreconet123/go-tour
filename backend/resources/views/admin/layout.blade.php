<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Universal Travels Pvt. Ltd. Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD,opsz@400,0,0,24" rel="stylesheet" />
</head>
<body class="bg-gray-100 flex flex-col md:flex-row min-h-screen">

    <!-- Mobile Header -->
    <div class="md:hidden bg-white shadow-md p-4 flex justify-between items-center z-20">
        <div class="flex items-center gap-2">
            <img src="/images/logo.png" alt="Logo" class="h-8 w-auto">
            <h1 class="text-sm sm:text-base font-bold text-red-600 leading-tight">New Universal Travels</h1>
        </div>
        <button id="mobile-menu-btn" class="text-gray-700 hover:text-red-600 focus:outline-none ml-2 bg-gray-100 p-2 rounded-lg">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-white h-screen shadow-xl flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full md:sticky md:top-0 md:translate-x-0 transition-transform duration-300 ease-in-out">
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div class="text-center w-full">
                <img src="/images/logo.png" alt="Logo" class="h-12 w-auto mx-auto mb-2">
                <h1 class="text-sm font-extrabold text-red-700 leading-tight uppercase tracking-wide">New Universal Travels</h1>
            </div>
            <!-- Mobile Close Button -->
            <button id="close-sidebar" class="md:hidden text-gray-500 hover:text-red-600 absolute right-4 top-4 bg-gray-100 rounded-full p-1 transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
        
        <!-- Sidebar Navigation -->
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="/admin" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all font-medium {{ request()->is('admin') ? 'bg-red-50 text-red-700 font-bold' : '' }}">
                <span class="material-symbols-outlined">dashboard</span>
                Dashboard
            </a>
            <a href="/admin/bookings" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all font-medium {{ request()->is('admin/bookings') ? 'bg-red-50 text-red-700 font-bold' : '' }}">
                <span class="material-symbols-outlined">book_online</span>
                Bookings
            </a>
            <a href="/admin/requests" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all font-medium {{ request()->is('admin/requests') ? 'bg-red-50 text-red-700 font-bold' : '' }}">
                <span class="material-symbols-outlined">assignment</span>
                Requests
            </a>
            <a href="/admin/users" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all font-medium {{ request()->is('admin/users') ? 'bg-red-50 text-red-700 font-bold' : '' }}">
                <span class="material-symbols-outlined">group</span>
                Users
            </a>
            <a href="/admin/tours" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all font-medium {{ request()->is('admin/tours') ? 'bg-red-50 text-red-700 font-bold' : '' }}">
                <span class="material-symbols-outlined">tour</span>
                Manage Tours
            </a>
            <a href="/admin/win-trip" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all font-medium {{ request()->is('admin/win-trip') ? 'bg-red-50 text-red-700 font-bold' : '' }}">
                <span class="material-symbols-outlined">redeem</span>
                Win Trip
            </a>
            <a href="/admin/cms" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-red-50 hover:text-red-700 transition-all font-medium {{ request()->is('admin/cms') ? 'bg-red-50 text-red-700 font-bold' : '' }}">
                <span class="material-symbols-outlined">web</span>
                CMS
            </a>
        </nav>
        
        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-100">
            <form action="/admin/logout" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all font-bold">
                    <span class="material-symbols-outlined">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 hidden md:hidden transition-opacity"></div>

    <!-- Global Details Modal -->
    <div id="details-modal" class="fixed inset-0 z-[60] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeDetailsModal()"></div>
        <div class="bg-white rounded-2xl shadow-2xl z-10 w-full max-w-md mx-4 transform scale-95 transition-transform duration-300 overflow-hidden">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex justify-between items-center">
                <h2 id="details-modal-title" class="text-xl font-bold text-white">Details</h2>
                <button onclick="closeDetailsModal()" class="text-white hover:text-red-200 transition-colors bg-white/10 rounded-full p-1 flex items-center justify-center">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-6">
                <div id="details-modal-content" class="space-y-1">
                    <!-- Content populated by JS -->
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end border-t border-gray-100">
                <button onclick="closeDetailsModal()" class="bg-gray-200 text-gray-800 hover:bg-gray-300 px-6 py-2 rounded-xl font-medium transition-colors">Close</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 p-4 md:p-8 overflow-y-auto h-full w-full">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center gap-3">
                <span class="material-symbols-outlined text-green-500">check_circle</span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @yield('content')
    </main>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const closeBtn = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleMenu() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        btn.addEventListener('click', toggleMenu);
        closeBtn.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);

        // Modal Logic
        const detailsModal = document.getElementById('details-modal');
        const detailsModalTitle = document.getElementById('details-modal-title');
        const detailsModalContent = document.getElementById('details-modal-content');

        function showDetailsModal(title, dataObj) {
            detailsModalTitle.textContent = title;
            
            let html = '';
            for (const [key, value] of Object.entries(dataObj)) {
                html += `
                    <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                        <span class="text-gray-500 font-medium">${key}</span>
                        <span class="text-gray-900 font-semibold text-right ml-4">${value}</span>
                    </div>
                `;
            }
            
            detailsModalContent.innerHTML = html;
            
            detailsModal.classList.remove('hidden');
            // Allow browser to render display block before transition
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    detailsModal.classList.remove('opacity-0');
                    detailsModal.querySelector('.bg-white').classList.remove('scale-95');
                    detailsModal.querySelector('.bg-white').classList.add('scale-100');
                });
            });
        }

        function closeDetailsModal() {
            detailsModal.classList.add('opacity-0');
            detailsModal.querySelector('.bg-white').classList.remove('scale-100');
            detailsModal.querySelector('.bg-white').classList.add('scale-95');
            
            setTimeout(() => {
                detailsModal.classList.add('hidden');
            }, 300);
        }
    </script>

</body>
</html>
