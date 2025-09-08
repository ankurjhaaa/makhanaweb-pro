<div>
    <a href="{{ route('cart') }}" class="px-4 py-2 border border-gray-200 rounded-full text-sm hover:border-brand-600 transition-all">
        Cart (<span wire:loading.class="opacity-50" wire:target="refreshCount">{{ $count }}</span>)
    </a>
</div>
