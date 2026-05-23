<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Tour Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white h-screen shadow-md flex flex-col">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-red-600">Go Tour Admin</h1>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="/admin" class="block px-4 py-2 rounded text-gray-700 hover:bg-red-50 hover:text-red-600">Dashboard</a>
            <a href="/admin/bookings" class="block px-4 py-2 rounded text-gray-700 hover:bg-red-50 hover:text-red-600">Bookings</a>
            <a href="/admin/requests" class="block px-4 py-2 rounded text-gray-700 hover:bg-red-50 hover:text-red-600">Requests</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto h-screen">
        @yield('content')
    </main>

</body>
</html>
