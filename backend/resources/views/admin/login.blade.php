<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - New Universal Travels Pvt. Ltd.</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <img src="/images/logo.png" alt="New Universal Travels Pvt. Ltd. Logo" class="h-20 w-auto mx-auto mb-4">
            <h1 class="text-2xl font-bold text-red-600 leading-tight">New Universal Travels Pvt. Ltd.</h1>
            <p class="text-gray-500 mt-2">Sign in to manage bookings and requests</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-4 border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        <form action="/admin/login" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email Address
                </label>
                <input class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" id="email" name="email" type="email" placeholder="admin@gotour.com" required>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" id="password" name="password" type="password" placeholder="••••••••" required>
            </div>
            
            <div class="flex items-center justify-between">
                <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-200" type="submit">
                    Sign In
                </button>
            </div>
        </form>
    </div>

</body>
</html>
