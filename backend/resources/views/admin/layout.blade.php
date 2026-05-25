<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Universal Travels Pvt. Ltd. Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <aside id="sidebar" class="w-72 bg-white h-screen shadow-xl flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out">
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

    <!-- Main Content -->
    <main class="flex-1 p-4 md:p-8 overflow-y-auto h-full w-full">
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
    </script>

</body>
</html>
