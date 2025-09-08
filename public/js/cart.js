// Cart Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Handle quantity input fields to ensure numbers only
    const quantityInputs = document.querySelectorAll('.quantity-input');
    
    quantityInputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            // Allow only numbers
            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });
        
        // Update Livewire component when input changes
        input.addEventListener('change', function() {
            const value = parseInt(this.value) || 1;
            if (value < 1) {
                this.value = 1;
            }
            
            // Fire Livewire event to update quantity
            Livewire.dispatch('update-quantity', {
                itemId: this.dataset.itemId,
                quantity: parseInt(this.value)
            });
        });
    });
    
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Coupon code submit on enter
    const couponInput = document.querySelector('input[wire\\:model="couponCode"]');
    if (couponInput) {
        couponInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                Livewire.dispatch('apply-coupon');
            }
        });
    }
});