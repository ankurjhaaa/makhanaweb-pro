<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your's Snacks</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <!-- Vite CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'brand': {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="/css/app.css">
    @endif
    @livewireStyles
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
        }

        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>
    <header class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 flex flex-wrap items-center justify-between">
            <div class="flex items-center gap-4 w-full justify-between md:w-auto">
                <a wire:navigate href="{{ route("home") }}"
                    class="text-brand-600 font-bold text-2xl font-poppins tracking-tight">Your's Snacks</a>
                <button id="mobile-menu-button" class="md:hidden text-gray-500 hover:text-brand-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <nav class="hidden md:flex gap-8 text-gray-600 font-medium">
                <a wire:navigate href="{{ route("home") }}" class="hover:text-brand-600 transition-all">Home</a>
                <a wire:navigate href="{{ route("shop") }}" class="hover:text-brand-600 transition-all">Shop</a>
                <a wire:navigate href="#" class="hover:text-brand-600 transition-all">About</a>
                <a wire:navigate href="{{ route("recipes") }}" class="hover:text-brand-600 transition-all">Recipes</a>
                <a wire:navigate href="{{ route("contact") }}" class="hover:text-brand-600 transition-all">Contact</a>
            </nav>

            <div class="hidden md:flex items-center gap-4">
                @livewire('public.cart-count')
                @auth
                    <div class="relative">
                        <button id="profile-menu-button" type="button"
                            class="flex items-center gap-3 px-3 py-2 rounded-full hover:bg-gray-50 focus:outline-none"
                            aria-expanded="false">
                            <div
                                class="h-8 w-8 bg-gray-100 rounded-full overflow-hidden flex items-center justify-center text-sm font-medium text-gray-700">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="h-full w-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <span class="text-gray-700 text-sm">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div id="profile-menu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-md shadow-sm py-1 z-50">
                            <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                            <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Orders</a>
                            <a href="{{ route('user.addresses') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Addresses</a>
                            <a href="{{ route('user.wishlist') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Wishlist</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}"
                            class="text-gray-600 hover:text-brand-600 font-medium transition-all">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-brand-600 text-white px-4 py-2 rounded-full hover:bg-brand-700 transition-all">Sign
                            Up</a>
                    </div>
                @endauth
                <a href="{{ route('shop') }}"
                    class="bg-brand-600 text-white px-5 py-2 rounded-full hover:bg-brand-700 transition-all">Shop
                    Now</a>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden w-full md:hidden px-4 py-4 border-t border-gray-100">
            <nav class="flex flex-col space-y-3 text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-brand-600 transition-all py-1">Home</a>
                <a href="{{ route('shop') }}" class="hover:text-brand-600 transition-all py-1">Shop</a>
                <a href="#" class="hover:text-brand-600 transition-all py-1">About</a>
                <a href="{{ route('recipes') }}" class="hover:text-brand-600 transition-all py-1">Recipes</a>
                <a href="{{ route('contact') }}" class="hover:text-brand-600 transition-all py-1">Contact</a>
                <div class="flex items-center gap-3 py-2">
                    @livewire('public.cart-count')
                    @auth
                        <div class="flex flex-col">
                            <a href="/profile" class="text-gray-700 py-1">Profile</a>
                            <a href="/orders" class="text-gray-700 py-1">My Orders</a>
                            <a href="/addresses" class="text-gray-700 py-1">Addresses</a>
                            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 border border-gray-200 rounded-full text-sm">Logout</button>
                            </form>
                        </div>
                    @else
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 border border-gray-200 rounded-full text-sm text-center">Login</a>
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 bg-brand-600 text-white rounded-full text-sm text-center">Sign Up</a>
                        </div>
                    @endauth
                    <a href="{{ route('shop') }}" class="bg-brand-600 text-white px-4 py-2 rounded-full">Shop Now</a>
                </div>
            </nav>
        </div>
    </header>
    {{ $slot }}

    @vite(['resources/js/app.js'])
    @livewireScripts

    <!-- Page-specific JS -->
    @if(Route::currentRouteName() === 'cart')
        <script src="{{ asset('js/cart.js') }}"></script>
    @endif
    <script>
        // Profile menu toggle
        document.addEventListener('click', function (e) {
            const btn = document.getElementById('profile-menu-button');
            const menu = document.getElementById('profile-menu');
            if (!btn || !menu) return;

            if (btn.contains(e.target)) {
                menu.classList.toggle('hidden');
            } else if (!menu.contains(e.target)) {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            }
        });
    </script>
</body>

</html>