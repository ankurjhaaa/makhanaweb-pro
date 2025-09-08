<div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
    <h2 class="text-2xl font-bold text-center mb-6">Create Account</h2>

    <form wire:submit.prevent="register" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Name</label>
            <input type="text" wire:model="name" class="w-full border rounded px-3 py-2">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" wire:model="email" class="w-full border rounded px-3 py-2">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Password</label>
            <input type="password" wire:model="password" class="w-full border rounded px-3 py-2">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Confirm Password</label>
            <input type="password" wire:model="password_confirmation" class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" class="w-full bg-brand-600 text-white py-2 rounded hover:bg-brand-700">
            Sign Up
        </button>
    </form>

    <p class="text-center text-sm mt-4">
        Already have an account?
        <a href="{{ route('login') }}" class="text-brand-600 hover:underline">Login</a>
    </p>
</div>
