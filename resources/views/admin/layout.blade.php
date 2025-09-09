<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite('resources/css/app.css')
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->

</head>

<body>
    <!-- --------------------------- loder wirl Here ---------------- -->
    <!-- Loader HTML -->
    <div id="loaderOverlay" class="fixed inset-0 bg-black/10 bg-opacity-40 hidden items-center justify-center z-[9999]">
        <div class="loader border-4 border-white border-t-[#b1432d] rounded-full w-12 h-12 animate-spin"></div>
    </div>

    <script>
        function showLoader() {
            const overlay = document.getElementById('loaderOverlay');
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }
        window.addEventListener('pageshow', function (event) {
            const overlay = document.getElementById('loaderOverlay');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        });
    </script>


    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0  bg-opacity-50 z-40 hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="fixed top-0 left-0 h-full w-72 bg-white shadow-xl z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">

        <div class="bg-white/80 px-6 py-4 text-white rounded-tr-xl mt-6">
            <h2 class="text-2xl font-semibold">Yours Snacks</h2>
        </div>

        <div class="px-6 py-4 border-b border-pink-100">
            <div class="flex items-center space-x-4">


                <div
                    class="w-12 h-12 rounded-full shadow-lg bg-orange-900 text-white flex items-center justify-center text-lg font-semibold">
                    A
                </div>

                <div>
                    <p class="text-base font-semibold text-blue-800">Hi, <span class="text-orange-600">Ankur Jha</span>
                    </p>
                    <p class="text-sm text-gray-900">Admin</p>
                </div>
            </div>
        </div>



        <!-- Sidebar Links -->
        <div class="p-6">
            <ul class="space-y-4">
                <li>
                    <a href="{{ route('admindashboard') }}" onclick="showLoader()"
                        class="flex items-center text-gray-700 hover:bg-blue-100 px-4 py-3 {{ request()->routeIs('admindashboard') ? 'bg-blue-100 border border-orange-900' : '' }} rounded-md transition">
                        <i class="fas fa-tachometer-alt mr-3 text-gray-500"></i>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('adminCategoryPage') }}" onclick="showLoader()"
                        class="flex items-center text-gray-700 hover:bg-blue-100 px-4 py-3 {{ request()->routeIs('adminCategoryPage') ? 'bg-blue-100 border border-orange-900' : '' }} rounded-md transition">
                        <i class="fas fa-folder mr-3 text-gray-500"></i>
                        Category
                    </a>
                </li>

                <li>
                    <a href="{{ route('searchProducts') }}" onclick="showLoader()"
                        class="flex items-center text-gray-700 hover:bg-blue-100 px-4 py-3 {{ request()->routeIs('searchProducts') ? 'bg-blue-100 border border-orange-900' : '' }} rounded-md transition">
                        <i class="fas fa-box mr-3 text-gray-500"></i>
                        All Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('allOrders') }}" onclick="showLoader()"
                        class="flex items-center text-gray-700 hover:bg-blue-100 px-4 py-3 {{ request()->routeIs('allOrders') ? 'bg-blue-100 border border-orange-900' : '' }} rounded-md transition">
                        <i class="fas fa-shopping-cart mr-3 text-gray-500"></i>
                        All Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('allCouponsPage') }}" onclick="showLoader()"
                        class="flex items-center text-gray-700 hover:bg-blue-100 px-4 py-3 {{ request()->routeIs('allCouponsPage') ? 'bg-blue-100 border border-orange-900' : '' }} rounded-md transition">
                        <i class="fas fa-ticket-alt mr-3 text-gray-500"></i>
                        Coupons
                    </a>
                </li>
                <li>
                    <a href="{{ route('allUsers') }}" onclick="showLoader()"
                        class="flex items-center text-gray-700 hover:bg-blue-100 px-4 py-3 {{ request()->routeIs('allUsers') ? 'bg-blue-100 border border-orange-900' : '' }} rounded-md transition">
                        <i class="fas fa-users mr-3 text-gray-500"></i>
                        All Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" onclick="showLoader()"
                        class="flex items-center text-gray-700 hover:bg-red-100 px-4 py-3 rounded-md transition">
                        <i class="fas fa-sign-out-alt mr-3 text-gray-500"></i>
                        Logout
                    </a>
                </li>


            </ul>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">

                <div class="text-3xl font-bold">
                    <a href="{{ route('admindashboard') }}" class="flex items-center gap-2" onclick="showLoader()">
                        <div class="text-3xl font-bold flex flex-wrap items-center">
                            <span class="text-blue-800 ml-1">Yours Snacks</span>
                        </div>
                    </a>

                </div>


                <div class="hidden md:flex items-center space-x-7 text-sm font-medium">

                    <a href="{{ route('adminCategoryPage') }}" onclick="showLoader()"
                        class="group relative  text-[17px] transition-all duration-300 hover:text-blue-800 {{ request()->routeIs('adminCategoryPage') ? 'text-blue-800' : '' }}">
                        All Category
                        <span
                            class="{{ request()->routeIs('adminCategoryPage') ? 'absolute left-0 -bottom-1 h-[2px] bg-blue-800 w-full' : 'absolute left-0 -bottom-1 w-0 h-[2px] bg-blue-800 transition-all duration-300 group-hover:w-full' }}"></span>
                    </a>

                    <a href="{{ route('logout') }}"
                        class="ml-2 bg-orange-600 text-white px-5 py-2 rounded-md text-[17px]  hover:bg-orange-700 transition">
                        Logout
                    </a>
                </div>

                <!-- Hamburger (Mobile) -->
                <div class="md:hidden flex items-center">
                    <button onclick="toggleSidebar()" class="text-orange-800 focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
    <!-- Main content -->
    <main class="flex-1 min-h-screen md:ml-72 p-5">
        @yield('content')
    </main>

</body>

</html>