<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Universal Travels Pvt. Ltd. Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD,opsz@400,0,0,24" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        red: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#E61E25', // Brand logo Red
                            800: '#9f1239',
                            900: '#881337',
                        },
                        green: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#00A651', // Brand logo Green
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        brand: {
                            red: '#E61E25',
                            green: '#00A651',
                            dark: '#0f172a',
                            darker: '#090d16'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-slate-50 flex flex-col md:flex-row min-h-screen text-slate-800 antialiased font-sans">

    <!-- Mobile Header -->
    <div class="md:hidden bg-slate-900 border-b border-slate-800 p-4 flex justify-between items-center z-20 shadow-lg">
        <div class="flex items-center gap-3">
            <div class="bg-white p-1 rounded-lg">
                <img src="/images/logo.png" alt="Logo" class="h-8 w-auto">
            </div>
            <div>
                <h1 class="text-xs font-bold text-white tracking-wider uppercase leading-none">New Universal</h1>
                <span class="text-[10px] text-green-500 font-semibold uppercase tracking-wide">Travels</span>
            </div>
        </div>
        <button id="mobile-menu-btn" class="text-slate-300 hover:text-white focus:outline-none bg-slate-800 p-2 rounded-lg transition-colors">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-brand-darker text-slate-300 h-screen flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full md:sticky md:top-0 md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-800/80 shadow-2xl">
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-slate-800/80 flex items-center justify-between relative">
            <div class="text-center w-full">
                <div class="inline-block bg-white p-3 rounded-2xl shadow-inner mb-3 transform hover:scale-105 transition-transform duration-300">
                    <img src="/images/logo.png" alt="Logo" class="h-14 w-auto mx-auto">
                </div>
                <h1 class="text-sm font-extrabold text-white leading-tight uppercase tracking-wider">New Universal Travels</h1>
                <p class="text-[10px] font-semibold text-green-500 mt-0.5 tracking-widest uppercase">Admin Panel</p>
            </div>
            <!-- Mobile Close Button -->
            <button id="close-sidebar" class="md:hidden text-slate-400 hover:text-white absolute right-4 top-4 bg-slate-800/50 hover:bg-slate-800 rounded-full p-1.5 transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
        
        <!-- Sidebar Navigation -->
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto">
            <a href="/admin" class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 group font-medium {{ request()->is('admin') ? 'bg-gradient-to-r from-red-700 to-red-600 text-white shadow-md shadow-red-700/20' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                <span class="material-symbols-outlined text-xl transition-transform group-hover:scale-110">dashboard</span>
                Dashboard
            </a>
            <a href="/admin/bookings" class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 group font-medium {{ request()->is('admin/bookings') ? 'bg-gradient-to-r from-red-700 to-red-600 text-white shadow-md shadow-red-700/20' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                <span class="material-symbols-outlined text-xl transition-transform group-hover:scale-110">book_online</span>
                Bookings
            </a>
            <a href="/admin/requests" class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 group font-medium {{ request()->is('admin/requests') ? 'bg-gradient-to-r from-red-700 to-red-600 text-white shadow-md shadow-red-700/20' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                <span class="material-symbols-outlined text-xl transition-transform group-hover:scale-110">assignment</span>
                Requests
            </a>
            <a href="/admin/users" class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 group font-medium {{ request()->is('admin/users') ? 'bg-gradient-to-r from-red-700 to-red-600 text-white shadow-md shadow-red-700/20' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                <span class="material-symbols-outlined text-xl transition-transform group-hover:scale-110">group</span>
                Users
            </a>
            <a href="/admin/tours" class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 group font-medium {{ request()->is('admin/tours') ? 'bg-gradient-to-r from-red-700 to-red-600 text-white shadow-md shadow-red-700/20' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                <span class="material-symbols-outlined text-xl transition-transform group-hover:scale-110">tour</span>
                Manage Tours
            </a>
            <a href="/admin/win-trip" class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 group font-medium {{ request()->is('admin/win-trip') ? 'bg-gradient-to-r from-red-700 to-red-600 text-white shadow-md shadow-red-700/20' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                <span class="material-symbols-outlined text-xl transition-transform group-hover:scale-110">redeem</span>
                Win Trip
            </a>
            <a href="/admin/cms" class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all duration-200 group font-medium {{ request()->is('admin/cms') ? 'bg-gradient-to-r from-red-700 to-red-600 text-white shadow-md shadow-red-700/20' : 'hover:bg-slate-800/60 hover:text-white text-slate-400' }}">
                <span class="material-symbols-outlined text-xl transition-transform group-hover:scale-110">web</span>
                CMS
            </a>
        </nav>
        
        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800/80">
            <form action="/admin/logout" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:text-white hover:bg-red-700/20 transition-all duration-200 font-bold border border-red-950/50 hover:border-red-900/50">
                    <span class="material-symbols-outlined text-xl">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-30 hidden md:hidden transition-opacity"></div>

    <!-- Global Details Modal -->
    <div id="details-modal" class="fixed inset-0 z-[60] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm" onclick="closeDetailsModal()"></div>
        <div class="bg-white rounded-2xl shadow-2xl z-10 w-full max-w-md mx-4 transform scale-95 transition-transform duration-300 overflow-hidden border border-slate-100">
            <div class="bg-gradient-to-r from-red-700 to-red-600 px-6 py-4 flex justify-between items-center">
                <h2 id="details-modal-title" class="text-lg font-bold text-white tracking-wide">Details</h2>
                <button onclick="closeDetailsModal()" class="text-white/80 hover:text-white transition-colors bg-white/10 rounded-full p-1.5 flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
            <div class="p-6 max-h-[60vh] overflow-y-auto">
                <div id="details-modal-content" class="space-y-1">
                    <!-- Content populated by JS -->
                </div>
            </div>
            <div class="bg-slate-50 px-6 py-4 flex justify-end border-t border-slate-100">
                <button onclick="closeDetailsModal()" class="bg-slate-200 text-slate-800 hover:bg-slate-300 px-5 py-2 rounded-xl font-semibold text-sm transition-colors">Close</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-10 overflow-y-auto h-full w-full">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3.5 rounded-xl mb-6 shadow-sm flex items-center gap-3 animate-pulse">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <span class="font-semibold text-sm">{{ session('success') }}</span>
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
                    <div class="flex justify-between items-start py-3 border-b border-slate-100 last:border-0">
                        <span class="text-slate-400 font-medium text-xs uppercase tracking-wider mt-0.5">${key}</span>
                        <span class="text-slate-800 font-semibold text-sm text-right ml-4 max-w-[65%] break-words">${value}</span>
                    </div>
                `;
            }
            
            detailsModalContent.innerHTML = html;
            
            detailsModal.classList.remove('hidden');
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
