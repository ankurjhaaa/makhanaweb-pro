@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        ✏️ Edit Review
    </h1>

    <form action="{{ route('reviews.update', $review->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Rating -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
            <select name="rating" 
                class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                @for($i=1;$i<=5;$i++)
                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>
                        {{ str_repeat('⭐', $i) }} ({{ $i }})
                    </option>
                @endfor
            </select>
            @error('rating') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
            @enderror
        </div>

        <!-- Comment -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
            <textarea name="comment" rows="4"
                class="w-full border-gray-300 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none">{{ $review->comment }}</textarea>
            @error('comment') 
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('reviews') }}" 
               class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
               Cancel
            </a>
            <button type="submit" 
                class="px-5 py-2 rounded-lg bg-green-600 text-white font-medium shadow hover:bg-green-700 focus:ring-2 focus:ring-green-500 transition">
                Update Review
            </button>
        </div>
    </form>
</div>
@endsection
