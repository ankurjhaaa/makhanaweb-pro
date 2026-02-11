<div class="md:hidden min-h-screen bg-gray-50 flex flex-col">

    {{-- ================= HEADER ================= --}}
    <div class="bg-white px-5 pt-8 pb-6 border-b border-gray-100">

        @auth
            <div class="flex items-center gap-4">

                <!-- Avatar -->
                <div class="h-16 w-16 rounded-full bg-brand-50 flex items-center justify-center text-brand-600 text-2xl font-semibold overflow-hidden">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ auth()->user()->email }}
                    </p>
                </div>

            </div>
        @else
            <div class="text-center space-y-3">
                <h2 class="text-lg font-semibold text-gray-800">
                    Welcome to Your Account
                </h2>

                <div class="flex gap-3 justify-center mt-4">
                    <a href="{{ route('login') }}"
                       class="px-6 py-2.5 rounded-full bg-brand-600 text-white text-sm font-medium">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-6 py-2.5 rounded-full border border-gray-300 text-sm font-medium text-gray-700">
                        Register
                    </a>
                </div>
            </div>
        @endauth

    </div>


    {{-- ================= MAIN MENU ================= --}}
    <div class="flex-1 px-4 py-6 space-y-6 overflow-y-auto">

        @auth
        <!-- Account Section -->
        <div class="space-y-3">

            <a href="{{ route('user.orders') }}"
               class="flex items-center justify-between bg-white px-4 py-4 rounded-xl shadow-sm active:scale-95 transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-box text-brand-600"></i>
                    <span class="text-sm font-medium text-gray-700">My Orders</span>
                </div>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            </a>

            <a href="{{ route('user.wishlist') }}"
               class="flex items-center justify-between bg-white px-4 py-4 rounded-xl shadow-sm active:scale-95 transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-heart text-brand-600"></i>
                    <span class="text-sm font-medium text-gray-700">Wishlist</span>
                </div>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            </a>

            <a href="{{ route('user.addresses') }}"
               class="flex items-center justify-between bg-white px-4 py-4 rounded-xl shadow-sm active:scale-95 transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-map-marker-alt text-brand-600"></i>
                    <span class="text-sm font-medium text-gray-700">My Addresses</span>
                </div>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            </a>

            <a href="{{ route('user.profile') }}"
               class="flex items-center justify-between bg-white px-4 py-4 rounded-xl shadow-sm active:scale-95 transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-user text-brand-600"></i>
                    <span class="text-sm font-medium text-gray-700">Profile Settings</span>
                </div>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            </a>

        </div>
        @endif


        <!-- Support Section -->
        <div class="space-y-3">

            <a href="{{ route('contact') }}"
               class="flex items-center justify-between bg-white px-4 py-4 rounded-xl shadow-sm active:scale-95 transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-headset text-brand-600"></i>
                    <span class="text-sm font-medium text-gray-700">Contact Us</span>
                </div>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            </a>

            <a href=""
               class="flex items-center justify-between bg-white px-4 py-4 rounded-xl shadow-sm active:scale-95 transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-question-circle text-brand-600"></i>
                    <span class="text-sm font-medium text-gray-700">FAQ</span>
                </div>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            </a>

            <a href=""
               class="flex items-center justify-between bg-white px-4 py-4 rounded-xl shadow-sm active:scale-95 transition">
                <div class="flex items-center gap-4">
                    <i class="fas fa-info-circle text-brand-600"></i>
                    <span class="text-sm font-medium text-gray-700">About Us</span>
                </div>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            </a>

        </div>

    </div>


    {{-- ================= LOGOUT / LOGIN FOOTER ================= --}}
    <div class="px-4 pb-8">

        @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-3 bg-red-50 text-red-600 py-3 rounded-xl font-medium border border-red-100 active:scale-95 transition">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}"
               class="w-full block text-center bg-brand-600 text-white py-3 rounded-xl font-medium">
                Login to Continue
            </a>
        @endauth

    </div>

</div>