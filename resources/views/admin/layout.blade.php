<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .sidebar-menu {
            font-family: 'Poppins', sans-serif;
        }
        .stat-card {
            transition: transform 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>
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
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="fixed top-0 left-0 h-full w-72 bg-gradient-to-b from-gray-800 to-gray-900 shadow-xl z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">

        <div class="px-6 py-6 flex items-center justify-between">
            <h2 class="text-xl font-bold text-white">Yours<span class="text-blue-400">Snacks</span></h2>
            <button class="text-gray-400 hover:text-white md:hidden" onclick="toggleSidebar()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="px-6 py-4 border-b border-gray-700">
            <div class="flex items-center space-x-4">
                <div
                    class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white flex items-center justify-center text-lg font-semibold shadow-lg">
                    A
                </div>

                <div>
                    <p class="text-white font-medium">Hi, <span class="text-blue-400">Ankur Jha</span></p>
                    <p class="text-xs text-gray-400">Administrator</p>
                </div>
            </div>
        </div>



        <!-- Sidebar Links -->
        <div class="p-4 sidebar-menu">
            <p class="text-xs uppercase text-gray-500 font-semibold pb-4 pl-4">Main Menu</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admindashboard') }}" onclick="showLoader()"
                        class="flex items-center text-gray-300 hover:bg-gray-700 hover:text-white px-4 py-3 {{ request()->routeIs('admindashboard') ? 'bg-blue-600 text-white' : '' }} rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-chart-line mr-3 {{ request()->routeIs('admindashboard') ? 'text-white' : 'text-gray-400' }}"></i>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('adminCategoryPage') }}" onclick="showLoader()"
                        class="flex items-center text-gray-300 hover:bg-gray-700 hover:text-white px-4 py-3 {{ request()->routeIs('adminCategoryPage') ? 'bg-blue-600 text-white' : '' }} rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-folder mr-3 {{ request()->routeIs('adminCategoryPage') ? 'text-white' : 'text-gray-400' }}"></i>
                        Categories
                    </a>
                </li>

                <li>
                    <a href="{{ route('searchProducts') }}" onclick="showLoader()"
                        class="flex items-center text-gray-300 hover:bg-gray-700 hover:text-white px-4 py-3 {{ request()->routeIs('searchProducts') ? 'bg-blue-600 text-white' : '' }} rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-box mr-3 {{ request()->routeIs('searchProducts') ? 'text-white' : 'text-gray-400' }}"></i>
                        Products
                    </a>
                </li>
                
                <p class="text-xs uppercase text-gray-500 font-semibold py-4 pl-4 mt-2">Sales</p>
                
                <li>
                    <a href="{{ route('allOrders') }}" onclick="showLoader()"
                        class="flex items-center text-gray-300 hover:bg-gray-700 hover:text-white px-4 py-3 {{ request()->routeIs('allOrders') ? 'bg-blue-600 text-white' : '' }} rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-shopping-cart mr-3 {{ request()->routeIs('allOrders') ? 'text-white' : 'text-gray-400' }}"></i>
                        Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('allCouponsPage') }}" onclick="showLoader()"
                        class="flex items-center text-gray-300 hover:bg-gray-700 hover:text-white px-4 py-3 {{ request()->routeIs('allCouponsPage') ? 'bg-blue-600 text-white' : '' }} rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-ticket-alt mr-3 {{ request()->routeIs('allCouponsPage') ? 'text-white' : 'text-gray-400' }}"></i>
                        Coupons
                    </a>
                </li>
                <li>
                    <a href="{{ route('productComboPage') }}" onclick="showLoader()"
                        class="flex items-center text-gray-300 hover:bg-gray-700 hover:text-white px-4 py-3 {{ request()->routeIs('productComboPage') ? 'bg-blue-600 text-white' : '' }} rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-gift mr-3 {{ request()->routeIs('productComboPage') ? 'text-white' : 'text-gray-400' }}"></i>
                        Combo Packs
                    </a>
                </li>
                
                <p class="text-xs uppercase text-gray-500 font-semibold py-4 pl-4 mt-2">Users</p>
                
                <li>
                    <a href="{{ route('allUsers') }}" onclick="showLoader()"
                        class="flex items-center text-gray-300 hover:bg-gray-700 hover:text-white px-4 py-3 {{ request()->routeIs('allUsers') ? 'bg-blue-600 text-white' : '' }} rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-users mr-3 {{ request()->routeIs('allUsers') ? 'text-white' : 'text-gray-400' }}"></i>
                        All Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" onclick="showLoader()"
                        class="flex items-center text-gray-300 hover:bg-red-600 hover:text-white px-4 py-3 rounded-md transition duration-150 ease-in-out mt-6">
                        <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                        Logout
                    </a>
                </li>


            </ul>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="bg-white shadow-sm fixed w-full top-0 z-40 ">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">

                <div class="flex items-center">
                    <!-- Mobile menu button-->
                    <button onclick="toggleSidebar()" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="hidden md:block text-xl font-bold">
                        <a href="{{ route('admindashboard') }}" class="flex items-center gap-2" onclick="showLoader()">
                            <span class="text-gray-800">Admin Dashboard</span>
                        </a>
                    </div>
                </div>

                <!-- Search bar -->
                <div class="flex-1 px-4 flex justify-center lg:justify-end max-w-xs lg:max-w-lg mx-auto">
                    <div class="w-full">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input id="search" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-md leading-5 bg-gray-100 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Search..." type="search">
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="p-1 rounded-full text-gray-600 hover:text-blue-600 focus:outline-none">
                        <span class="sr-only">View notifications</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </button>

                    <!-- Profile dropdown -->
                    <div class="relative">
                        <div>
                            <button class="flex items-center text-sm rounded-full focus:outline-none">
                                <span class="sr-only">Open user menu</span>
                                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium">A</div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Function to toggle sidebar for mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            
            // Prevent body scrolling when sidebar is open on mobile
            if (!sidebar.classList.contains('-translate-x-full')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }
        
        // Handle responsive behavior
        function handleResponsiveLayout() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            if (window.innerWidth >= 768) { // md breakpoint
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            } else {
                if (!sidebar.classList.contains('-translate-x-full')) {
                    // If sidebar is open on mobile and we're switching to desktop
                    sidebar.classList.add('-translate-x-full');
                }
            }
        }
        
        // Close sidebar on window resize
        window.addEventListener('resize', handleResponsiveLayout);
        
        // Initialize responsive layout on load
        document.addEventListener('DOMContentLoaded', function() {
            handleResponsiveLayout();
            
            // Detect swipe gestures for mobile sidebar
            let touchStartX = 0;
            let touchEndX = 0;
            
            document.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
            }, false);
            
            document.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, false);
            
            function handleSwipe() {
                const sidebar = document.getElementById('sidebar');
                // Swipe right to open sidebar (from left edge)
                if (touchEndX - touchStartX > 100 && touchStartX < 50) {
                    if (sidebar.classList.contains('-translate-x-full')) {
                        toggleSidebar();
                    }
                }
                
                // Swipe left to close sidebar
                if (touchStartX - touchEndX > 100) {
                    if (!sidebar.classList.contains('-translate-x-full')) {
                        toggleSidebar();
                    }
                }
            }
        });
    </script>
    <!-- Main content -->
    <main class="flex-1 min-h-screen md:ml-72 p-6 bg-gray-50">
        @yield('content')
    </main>
    @if(session('success'))
        <div id="toast-success"
            class="fixed bottom-6 right-6 flex items-center w-full max-w-xs p-4 mb-2 text-green-800 bg-green-100 border-l-4 border-green-600 rounded-lg shadow-lg"
            role="alert">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414L9 14.414 5.293 10.707a1 1 0 011.414-1.414L9 11.586l6.293-6.293a1 1 0 011.414 0z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 items-center justify-center" onclick="document.getElementById('toast-success').style.display='none';">
                <span class="sr-only">Close</span>
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div id="toast-error"
            class="fixed bottom-6 right-6 flex items-center w-full max-w-xs p-4 mb-2 text-red-800 bg-red-100 border-l-4 border-red-600 rounded-lg shadow-lg"
            role="alert">
            <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-5h2v2H9v-2zm0-6h2v5H9V7z"
                    clip-rule="evenodd">
                </path>
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 items-center justify-center" onclick="document.getElementById('toast-error').style.display='none';">
                <span class="sr-only">Close</span>
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif
    <script>
        setTimeout(() => {
            const success = document.getElementById('toast-success');
            const error = document.getElementById('toast-error');
            if (success) success.style.display = 'none';
            if (error) error.style.display = 'none';
        }, 10000); // 3 sec me gayab ho jayega
    </script>
</body>

</html>