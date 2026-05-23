<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Tour Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col md:flex-row min-h-screen">

    <!-- Mobile Header -->
    <div class="md:hidden bg-white shadow-md p-4 flex justify-between items-center z-20">
        <h1 class="text-xl font-bold text-red-600">Go Tour Admin</h1>
        <button id="mobile-menu-btn" class="text-gray-700 hover:text-red-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-white h-screen shadow-md flex-col fixed md:relative z-10 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out md:flex">
        <div class="p-6 border-b hidden md:block">
            <h1 class="text-2xl font-bold text-red-600">Go Tour Admin</h1>
        </div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="/admin" class="block px-4 py-2 rounded text-gray-700 hover:bg-red-50 hover:text-red-600">Dashboard</a>
            <a href="/admin/bookings" class="block px-4 py-2 rounded text-gray-700 hover:bg-red-50 hover:text-red-600">Bookings</a>
            <a href="/admin/requests" class="block px-4 py-2 rounded text-gray-700 hover:bg-red-50 hover:text-red-600">Requests</a>
            <a href="/admin/users" class="block px-4 py-2 rounded text-gray-700 hover:bg-red-50 hover:text-red-600">Users</a>
            
            <div class="pt-4 mt-4 border-t border-gray-200">
                <form action="/admin/logout" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded text-red-600 hover:bg-red-50 font-bold">Logout</button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Overlay for mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-0 hidden md:hidden"></div>

    <!-- Main Content -->
    <main class="flex-1 p-4 md:p-8 overflow-y-auto h-full w-full">
        @yield('content')
    </main>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleMenu() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        btn.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);
    </script>

</body>
</html>
