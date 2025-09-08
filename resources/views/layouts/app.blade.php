<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your's Snacks</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
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
        h1, h2, h3, h4, h5, h6 {
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
                <a href="{{ route("home") }}" class="text-brand-600 font-bold text-2xl font-poppins tracking-tight">Your's Snacks</a>
                <button id="mobile-menu-button" class="md:hidden text-gray-500 hover:text-brand-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            
            <nav class="hidden md:flex gap-8 text-gray-600 font-medium">
                <a href="#" class="hover:text-brand-600 transition-all">Home</a>
                <a href="#" class="hover:text-brand-600 transition-all">Shop</a>
                <a href="#" class="hover:text-brand-600 transition-all">About</a>
                <a href="#" class="hover:text-brand-600 transition-all">Recipes</a>
                <a href="#" class="hover:text-brand-600 transition-all">Contact</a>
            </nav>
            
            <div class="hidden md:flex items-center gap-4">
                @livewire('public.cart-count')
                @auth
                    <div class="flex items-center gap-3">
                        <span class="text-gray-600 text-sm">Hi, {{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-brand-600 text-sm font-medium transition-all">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-600 font-medium transition-all">Login</a>
                @endauth
                <a href="#" class="bg-brand-600 text-white px-5 py-2 rounded-full hover:bg-brand-700 transition-all">Shop Now</a>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden w-full md:hidden px-4 py-4 border-t border-gray-100">
            <nav class="flex flex-col space-y-3 text-gray-600">
                <a href="#" class="hover:text-brand-600 transition-all py-1">Home</a>
                <a href="#" class="hover:text-brand-600 transition-all py-1">Shop</a>
                <a href="#" class="hover:text-brand-600 transition-all py-1">About</a>
                <a href="#" class="hover:text-brand-600 transition-all py-1">Recipes</a>
                <a href="#" class="hover:text-brand-600 transition-all py-1">Contact</a>
                <div class="flex items-center gap-3 py-2">
                    @livewire('public.cart-count')
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-brand-600 text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 border border-gray-200 rounded-full text-sm">Login</a>
                    @endauth
                    <a href="#" class="bg-brand-600 text-white px-4 py-2 rounded-full">Shop Now</a>
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
</body>
</html>