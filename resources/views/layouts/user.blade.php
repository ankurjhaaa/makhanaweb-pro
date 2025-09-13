<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Your\'s Snacks' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>

<body class="bg-gray-50 font-inter text-gray-900 antialiased">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-bold font-poppins text-brand-600">
                        Your's<span class="text-gray-800">Snacks</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-10">
                    <a href="/" class="text-gray-600 hover:text-brand-600 transition">Home</a>
                    <a href="/shop" class="text-gray-600 hover:text-brand-600 transition">Shop</a>
                    <a href="/about" class="text-gray-600 hover:text-brand-600 transition">About</a>
                    <a href="/contact" class="text-gray-600 hover:text-brand-600 transition">Contact</a>
                </nav>

                <!-- Account & Cart -->
                <div class="hidden md:flex items-center space-x-6">
                    <div class="relative">
                        <div class="flex items-center space-x-1 cursor-pointer group">
                            <span class="text-gray-700 group-hover:text-brand-600">My Account</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500 group-hover:text-brand-600"></i>
                        </div>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>

                    <a href="/cart" class="text-gray-700 hover:text-brand-600 relative">
                        <i class="fas fa-shopping-bag text-xl"></i>
                        <span class="absolute -top-2 -right-2 bg-brand-600 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs">
                            0
                        </span>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="flex md:hidden">
                    <button id="mobile-menu-button" type="button" class="text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-100">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="block px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-md">Home</a>
                <a href="/shop" class="block px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-md">Shop</a>
                <a href="/about" class="block px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-md">About</a>
                <a href="/contact" class="block px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-md">Contact</a>
                <hr class="my-2">
                <a href="{{ route('user.dashboard') }}" class="block px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-md">Dashboard</a>
                <a href="{{ route('user.profile') }}" class="block px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-md">Profile</a>
                <a href="{{ route('user.orders') }}" class="block px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-md">My Orders</a>
                <a href="{{ route('cart') }}" class="block px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-md">Cart</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-md">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- User Dashboard Container -->
    <div class="max-w-8xl mx-auto px-4 sm:px-6 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar -->
            <div class="w-full md:w-64 shrink-0">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 bg-brand-50 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="h-12 w-12 rounded-full bg-brand-100 flex items-center justify-center text-brand-600">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    <nav class="p-2">
                        <a href="{{ route('user.dashboard') }}" 
                            class="flex items-center px-4 py-3 rounded-md {{ request()->routeIs('user.dashboard') ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('user.orders') }}"
                            class="flex items-center px-4 py-3 rounded-md {{ request()->routeIs('user.orders') ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fas fa-shopping-bag w-5 h-5 mr-3"></i>
                            <span>My Orders</span>
                        </a>
                        <a href="{{ route('user.profile') }}"
                            class="flex items-center px-4 py-3 rounded-md {{ request()->routeIs('user.profile') ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fas fa-user-circle w-5 h-5 mr-3"></i>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('user.addresses') }}"
                            class="flex items-center px-4 py-3 rounded-md {{ request()->routeIs('user.addresses') ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fas fa-map-marker-alt w-5 h-5 mr-3"></i>
                            <span>Addresses</span>
                        </a>
                        <a href="{{ route('user.wishlist') }}"
                            class="flex items-center px-4 py-3 rounded-md {{ request()->routeIs('user.wishlist') ? 'bg-brand-50 text-brand-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fas fa-heart w-5 h-5 mr-3"></i>
                            <span>Wishlist</span>
                        </a>
                        <hr class="my-2 border-gray-200">
                        <form method="POST" action="{{ route('logout') }}" class="p-2">
                            @csrf
                            <button type="submit" class="flex w-full items-center px-4 py-3 rounded-md text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6">
                        @if (isset($header))
                            <h1 class="text-2xl font-semibold text-gray-800 mb-6">{{ $header }}</h1>
                        @endif

                        {{ $slot }}
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Column 1: About -->
                <div>
                    <h5 class="font-bold text-gray-800 mb-4">About Us</h5>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Your's Snacks brings you premium quality, healthy snacks direct from farmers. We believe in natural, 
                        nutritious food that's good for you and the planet.
                    </p>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h5 class="font-bold text-gray-800 mb-4">Quick Links</h5>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-gray-600 hover:text-brand-600">Home</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-600">Shop</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-600">About Us</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-600">Contact</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-600">Blog</a></li>
                    </ul>
                </div>

                <!-- Column 3: Help -->
                <div>
                    <h5 class="font-bold text-gray-800 mb-4">Help</h5>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-gray-600 hover:text-brand-600">FAQs</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-600">Shipping</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-600">Returns</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-600">Track Order</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-brand-600">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Column 4: Newsletter -->
                <div>
                    <h5 class="font-bold text-gray-800 mb-4">Newsletter</h5>
                    <p class="text-gray-600 text-sm mb-4">Subscribe to our newsletter for the latest updates and offers</p>
                    <form class="space-y-2">
                        <div class="flex">
                            <input type="email" placeholder="Your email"
                                class="flex-1 px-4 py-2 text-sm border border-gray-300 rounded-l-md focus:ring-brand-500 focus:border-brand-500">
                            <button type="submit"
                                class="bg-brand-600 text-white px-4 py-2 text-sm rounded-r-md hover:bg-brand-700">
                                Subscribe
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">© 2025 Your's Snacks. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-brand-600">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-brand-600">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-brand-600">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-brand-600">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>

    @livewireScripts
</body>

</html>