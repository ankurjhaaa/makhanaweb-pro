<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MakhanaWeb</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#d97706',
                        softbg: '#faf7f2'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-softbg pb-20 md:pb-0">

    <!-- ================= NAVBAR ================= -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-5 flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="text-2xl font-bold text-primary tracking-tight">
                MakhanaWeb
            </a>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex gap-8 text-gray-700 font-medium">
                <a href="/" class="hover:text-primary transition">Home</a>
                <a href="/shop" class="hover:text-primary transition">Shop</a>
                <!-- <a href="/recipes" class="hover:text-primary transition">Recipes</a> -->
                <a href="/contact" class="hover:text-primary transition">Contact</a>
            </nav>

            <!-- Desktop Right -->
            <div class="hidden md:flex items-center gap-6">

                <!-- Cart -->
                <a href="{{ route('cart') }}" class="relative text-gray-600 hover:text-gray-900 transition text-lg">
                    <i class="fa-solid fa-cart-shopping"></i>

                    @if($cartCount ?? false)
                        <span class="absolute -top-2 -right-2 bg-black text-white text-[10px] px-1.5 py-0.5 rounded-full">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                @auth
                    <!-- Profile Dropdown -->
                    <div class="relative">

                        <button type="button"
                            onclick="document.getElementById('desktopProfileMenu').classList.toggle('hidden')"
                            class="flex items-center gap-3 px-3 py-2 rounded-full hover:bg-gray-100 transition">

                            <!-- Avatar -->
                            <div
                                class="h-9 w-9 bg-gray-200 rounded-full overflow-hidden flex items-center justify-center text-sm font-medium text-gray-700">

                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" class="h-full w-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>

                            <!-- Name -->
                            <span class="text-sm text-gray-700">
                                {{ Auth::user()->name }}
                            </span>

                            <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                        </button>

                        <!-- Dropdown -->
                        <div id="desktopProfileMenu"
                            class="hidden absolute right-0 mt-3 w-52 bg-white border border-gray-200 rounded-xl shadow-lg py-2 z-50">

                            <a href="{{ route('user.profile') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                My Profile
                            </a>

                            <a href="{{ route('user.orders') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Orders
                            </a>

                            <a href="{{ route('user.addresses') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Addresses
                            </a>

                            <a href="{{ route('user.wishlist') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Wishlist
                            </a>

                            <div class="border-t my-2"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                @else
                    <!-- Login Button -->
                    <a href="{{ route('login') }}"
                        class="bg-black text-white px-5 py-2 rounded-full text-sm hover:bg-gray-800 transition">
                        Login
                    </a>
                @endauth

            </div>

            <!-- Mobile Right (Login Button Only) -->
            <div class="md:hidden">
                <a href="/login" class="text-sm bg-primary text-white px-4 py-2 rounded-lg">
                    Login
                </a>
            </div>

        </div>
    </header>


    <!-- ================= PAGE CONTENT ================= -->
    <!-- User Dashboard Container -->
    <div class="max-w-8xl mx-auto md:px-4 md:py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar -->
            <div class="w-full md:w-64 shrink-0 hidden md:block">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 bg-brand-50 border-b border-gray-200">
                        <div class="flex items-center">
                            <div
                                class="h-12 w-12 rounded-full bg-brand-100 flex items-center justify-center text-brand-600">
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
                            <button type="submit"
                                class="flex w-full items-center px-4 py-3 rounded-md text-gray-700 hover:bg-gray-50">
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
                       
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ================= FOOTER ================= -->
    <footer class="bg-white border-t hidden md:block">
        <div class="max-w-7xl mx-auto px-4 py-14 grid md:grid-cols-4 gap-10">

            <!-- Brand -->
            <div>
                <h2 class="text-xl font-bold text-primary">MakhanaWeb</h2>
                <p class="text-gray-600 mt-4 text-sm leading-relaxed">
                    Fresh roasted makhana & healthy snacks made with love.
                    Pure ingredients, better snacking.
                </p>
            </div>

            <!-- Links -->
            <div>
                <h4 class="font-semibold mb-4 text-gray-800">Quick Links</h4>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li><a href="/shop" class="hover:text-primary">Shop</a></li>
                    <li><a href="/recipes" class="hover:text-primary">Recipes</a></li>
                    <li><a href="/contact" class="hover:text-primary">Contact</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h4 class="font-semibold mb-4 text-gray-800">Support</h4>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li>Shipping Info</li>
                    <li>Returns Policy</li>
                    <li>Privacy Policy</li>
                </ul>
            </div>

            <!-- Subscribe -->
            <div>
                <h4 class="font-semibold mb-4 text-gray-800">Stay Updated</h4>
                <div class="flex">
                    <input type="email" placeholder="Your email"
                        class="flex-1 px-4 py-2 border rounded-l-lg text-sm focus:ring-2 focus:ring-primary outline-none">
                    <button class="bg-primary text-white px-4 rounded-r-lg text-sm">
                        Join
                    </button>
                </div>
            </div>

        </div>

        <div class="text-center text-gray-500 text-xs py-6 border-t">
            © 2026 MakhanaWeb. All rights reserved.
        </div>
    </footer>


    <!-- ================= MOBILE BOTTOM NAV ================= -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t shadow-md z-50">
        <div class="flex justify-around py-3 text-gray-600 text-xs">

            <a href="/" class="flex flex-col items-center hover:text-primary">
                <i class="fa-solid fa-house text-lg"></i>
                <span class="mt-1">Home</span>
            </a>

            <a href="/shop" class="flex flex-col items-center hover:text-primary">
                <i class="fa-solid fa-store text-lg"></i>
                <span class="mt-1">Shop</span>
            </a>

            <a href="/cart" class="flex flex-col items-center hover:text-primary">
                <i class="fa-solid fa-cart-shopping text-lg"></i>
                <span class="mt-1">Cart</span>
            </a>

            <a href="/profile" class="flex flex-col items-center hover:text-primary">
                <i class="fa-solid fa-user text-lg"></i>
                <span class="mt-1">Profile</span>
            </a>

        </div>
    </div>

</body>

</html>