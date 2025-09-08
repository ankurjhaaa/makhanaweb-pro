<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Admin Dashboard')</title>
    @vite('resources/css/app.css')  {{-- Tailwind CSS --}}
  
</head>
<body class="bg-gray-100 flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white shadow-lg min-h-screen hidden md:block">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-green-600">Admin</h2>
        </div>
        <nav class="mt-6">
            <a href="/admin/dashboard" class="block px-6 py-2 hover:bg-gray-100">Dashboard</a>
            <a href="/admin/category" class="block px-6 py-2 hover:bg-gray-100">Category</a>
            <a href="" class="block px-6 py-2 hover:bg-gray-100">Users</a>
            <a href="" class="block px-6 py-2 hover:bg-gray-100">Products</a>
            <a href="" class="block px-6 py-2 hover:bg-gray-100">Orders</a>
            <a href="/admin/settings" class="block px-6 py-2 hover:bg-gray-100">Settings</a>
        </nav>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">
        {{-- Top Navbar --}}
        <header class="bg-white shadow h-16 flex items-center justify-between px-6">
            <div class="flex items-center space-x-2">
                {{-- Mobile Menu Button --}}
                <button class="md:hidden p-2 rounded hover:bg-gray-200" id="menuToggle">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <span class="font-semibold text-lg">Admin Panel</span>
            </div>

            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Welcome, Admin</span>
                <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Logout</button>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>


    {{-- Simple Mobile Menu Script --}}
    <script>
        const btn = document.getElementById('menuToggle');
        const sidebar = document.querySelector('aside');

        btn?.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    </script>
</body>
</html>
