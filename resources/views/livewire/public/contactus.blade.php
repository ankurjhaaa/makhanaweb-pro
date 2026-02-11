<div class="min-h-screen bg-gray-50">



    <div class="max-w-6xl mx-auto px-6 py-16">

        <div class="grid lg:grid-cols-2 gap-16">

            <!-- Contact Form -->
            <div class="bg-white rounded-xl border border-gray-200 p-10">

                <h2 class="text-xl font-semibold text-gray-900 mb-8">
                    Send a Message
                </h2>

                @if (session()->has('success'))
                    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form wire:submit="submitForm" class="space-y-6">

                    <div class="grid md:grid-cols-2 gap-6">
                        <input type="text" wire:model="name" placeholder="Full Name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-1 focus:ring-gray-400 focus:border-gray-400">

                        <input type="email" wire:model="email" placeholder="Email Address"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-1 focus:ring-gray-400 focus:border-gray-400">
                    </div>

                    <input type="text" wire:model="subject" placeholder="Subject"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-1 focus:ring-gray-400 focus:border-gray-400">

                    <textarea wire:model="message" rows="5" placeholder="Write your message..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-1 focus:ring-gray-400 focus:border-gray-400"></textarea>

                    <button type="submit"
                        class="w-full bg-gray-900 text-white py-3 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                        Submit
                    </button>

                </form>

            </div>

            <!-- Contact Info -->
            <div class="space-y-10">

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">
                        Contact Information
                    </h2>

                    <div class="space-y-6 text-sm text-gray-600">

                        <div>
                            <p class="font-medium text-gray-900">Address</p>
                            <p class="mt-1">
                                Organic Plaza, 2nd Floor<br>
                                Mumbai, Maharashtra<br>
                                India
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-gray-900">Phone</p>
                            <p class="mt-1">
                                +91 98765 43210
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-gray-900">Email</p>
                            <p class="mt-1">
                                hello@yoursbrand.com
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-gray-900">Working Hours</p>
                            <p class="mt-1">
                                Monday – Saturday<br>
                                9:00 AM – 6:00 PM
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Social -->
                <div>
                    <h3 class="text-sm font-medium text-gray-900 mb-4">
                        Follow Us
                    </h3>

                    <div class="flex gap-4">
                        <div
                            class="w-10 h-10 border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-100 cursor-pointer">
                            <i class="fab fa-facebook-f text-sm text-gray-600"></i>
                        </div>
                        <div
                            class="w-10 h-10 border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-100 cursor-pointer">
                            <i class="fab fa-instagram text-sm text-gray-600"></i>
                        </div>
                        <div
                            class="w-10 h-10 border border-gray-300 rounded-full flex items-center justify-center hover:bg-gray-100 cursor-pointer">
                            <i class="fab fa-youtube text-sm text-gray-600"></i>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>