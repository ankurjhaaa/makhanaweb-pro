<div class="newsletter-signup py-8 bg-white">
    <div class="container mx-auto px-4">
        <h4 class="text-lg font-semibold">Subscribe & Get 10% Off</h4>
        @if (session()->has('message'))
            <div class="mt-2 text-green-600">{{ session('message') }}</div>
        @endif
        <form wire:submit.prevent="subscribe" class="mt-4 flex gap-2">
            <input wire:model.defer="email" type="email" placeholder="Enter your email" class="input" required>
            <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
    </div>
</div>
