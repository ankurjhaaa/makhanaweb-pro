<div class="min-h-screen bg-gray-50 flex items-center justify-center px-6 py-16">

    <div class="w-full max-w-md">

        <!-- Card -->
        <div class="bg-white border border-gray-200 rounded-xl p-10">

            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-2xl font-semibold text-gray-900">
                    Sign In
                </h1>
                <p class="text-sm text-gray-500 mt-3">
                    Access your account securely
                </p>
            </div>

            <!-- Success Message -->
            @if (session()->has('success'))
                <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Google Button -->
            <button type="button" wire:click="redirectToGoogle"
                class="w-full border border-gray-300 rounded-lg py-3 flex items-center justify-center gap-3 text-sm font-medium hover:bg-gray-50 transition">

                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4"
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853"
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05"
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335"
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>

                Continue with Google
            </button>

            <!-- Divider -->
            <div class="flex items-center gap-4 my-8">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400">OR</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <!-- Form -->
            <form wire:submit.prevent="login" class="space-y-6">

                <!-- Email -->
                <div>
                    <label class="block text-sm text-gray-600 mb-2">
                        Email
                    </label>
                    <input type="email" wire:model.blur="email"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-gray-500"
                        placeholder="you@example.com">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm text-gray-600 mb-2">
                        Password
                    </label>

                    <div class="relative">
                        <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model.blur="password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-gray-500"
                            placeholder="Enter your password">

                        <button type="button" wire:click="togglePasswordVisibility"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-sm">
                            {{ $showPassword ? 'Hide' : 'Show' }}
                        </button>
                    </div>

                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-gray-600">
                        <input type="checkbox" wire:model="remember" class="border-gray-300 rounded">
                        Remember me
                    </label>

                    <a href="#" class="text-gray-600 hover:text-gray-900">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-gray-900 text-white py-3 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                    <span wire:loading.remove>Sign In</span>
                    <span wire:loading>Signing in...</span>
                </button>

            </form>

            <!-- Bottom -->
            <div class="mt-8 text-center text-sm text-gray-600">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-gray-900 font-medium">
                    Create one
                </a>
            </div>

        </div>

        <!-- Back -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-900">
                ← Back to Home
            </a>
        </div>

    </div>

</div>