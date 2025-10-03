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
   
        <link rel="stylesheet" href="/css/app.css">
    @livewireStyles
    <script>
        window.addEventListener('redirect', event => {
            window.location.href = event.detail.url;
        });
    </script>
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
                            <a href="{{ route('user.profile') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                            <a href="{{ route('user.orders') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Orders</a>
                            <a href="{{ route('user.addresses') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Addresses</a>
                            <a href="{{ route('user.wishlist') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Wishlist</a>
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
                <a wire:navigate href="{{ route('shop') }}"
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
                            <a wire:navigate href="/profile" class="text-gray-700 py-1">Profile</a>
                            <a wire:navigate href="/orders" class="text-gray-700 py-1">My Orders</a>
                            <a wire:navigate href="/addresses" class="text-gray-700 py-1">Addresses</a>
                            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                                @csrf
                                <button wire:navigate type="submit"
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

    @livewireScripts

    <!-- Page-specific JS -->
    @if(Route::currentRouteName() === 'cart')
        <script src="{{ asset('js/cart.js') }}"></script>
    @endif
    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-100 py-12 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="text-brand-600 font-poppins font-bold text-xl">Your's Snacks</div>
                    <p class="text-gray-600 mt-4">Bringing pure, natural, and nutritious snacks to every home with
                        quality sourced ingredients.</p>
                    <div class="mt-6 flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-brand-600 transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-brand-600 transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-brand-600 transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="lg:ml-auto">
                    <h4 class="font-poppins font-semibold text-lg">Quick Links</h4>
                    <ul class="mt-4 space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-brand-600 transition-all">About Us</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Shop</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Recipes</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-poppins font-semibold text-lg">Customer Service</h4>
                    <ul class="mt-4 space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-brand-600 transition-all">FAQ</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Shipping Info</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Returns</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-all">Track Order</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-poppins font-semibold text-lg">Stay Connected</h4>
                    <p class="text-gray-600 mt-4">care@yoursnacks.com</p>
                    <div class="mt-4">
                        <form class="flex flex-col space-y-3">
                            <input type="email" placeholder="Enter your email"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                            <button type="submit"
                                class="w-full bg-brand-600 text-white py-3 px-4 rounded-lg hover:bg-brand-700 transition-all font-medium">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-12 pt-8 border-t border-gray-200 text-center text-gray-500">
            © 2024 Your's Snacks. All rights reserved. <a href="{{ route('admindashboard') }}">admin login</a>
        </div>
    </footer>
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
<script>
    window.addEventListener('redirect', event => {
        window.location.href = event.detail.url;
    });
</script>