<div class="min-h-screen bg-gray-50 flex items-center justify-center px-6 py-16">

    <div class="w-full max-w-md">

        <div class="bg-white border border-gray-200 rounded-2xl p-10">

            <!-- Header -->
            <div class="text-center mb-10">
                <h2 class="text-2xl font-semibold text-gray-900">
                    Create your account
                </h2>
                <p class="text-sm text-gray-500 mt-3">
                    Already registered?
                    <a href="{{ route('login') }}" class="text-gray-900 font-medium hover:underline">
                        Sign in
                    </a>
                </p>
            </div>

            <!-- Form -->
            <form wire:submit.prevent="register" class="space-y-6">

                <!-- Name Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm text-gray-600 mb-2">
                            First Name
                        </label>
                        <input type="text"
                            wire:model.blur="first_name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-gray-500"
                            placeholder="First name">
                        @error('first_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-2">
                            Last Name
                        </label>
                        <input type="text"
                            wire:model.blur="last_name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-gray-500"
                            placeholder="Last name">
                        @error('last_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm text-gray-600 mb-2">
                        Email Address
                    </label>
                    <input type="email"
                        wire:model.blur="email"
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
                        <input type="{{ $showPassword ? 'text' : 'password' }}"
                            wire:model="password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-12 text-sm focus:outline-none focus:border-gray-500"
                            placeholder="Create password">

                        <button type="button"
                            wire:click="togglePasswordVisibility"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-700">
                            👁
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm text-gray-600 mb-2">
                        Confirm Password
                    </label>
                    <div class="relative">
                        <input type="{{ $showPasswordConfirmation ? 'text' : 'password' }}"
                            wire:model="password_confirmation"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-12 text-sm focus:outline-none focus:border-gray-500"
                            placeholder="Re-enter password">

                        <button type="button"
                            wire:click="togglePasswordConfirmationVisibility"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-700">
                            👁
                        </button>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full bg-gray-900 text-white py-3 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                    <span wire:loading.remove>Create Account</span>
                    <span wire:loading>Creating account...</span>
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs text-gray-400 bg-white px-4">
                        OR
                    </div>
                </div>

                <!-- Google Button -->
                <button type="button"
                    wire:click="redirectToGoogle"
                    class="w-full border border-gray-300 py-3 rounded-lg text-sm font-medium hover:bg-gray-50 transition flex items-center justify-center gap-3">
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

            </form>

        </div>

    </div>

</div>