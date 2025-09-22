@extends('admin.layout')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Edit Review</h1>

    <form action="{{ route('reviews.update', $review->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block">Rating</label>
            <select name="rating" class="border rounded px-2 py-1">
                @for($i=1;$i<=5;$i++)
                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>
                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                    </option>
                @endfor
            </select>
            @error('rating') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block">Comment</label>
            <textarea name="comment" class="border rounded w-full px-2 py-1">{{ $review->comment }}</textarea>
            @error('comment') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
