@extends('admin.layout')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">All Reviews</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-3 py-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">ID</th>
                <th class="p-2 border">User</th>
                <th class="p-2 border">Product</th>
                <th class="p-2 border">Rating</th>
                <th class="p-2 border">Comment</th>
                <th class="p-2 border">Date</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td class="p-2 border">{{ $review->id }}</td>
                    <td class="p-2 border">{{ $review->user->name }}</td>
                    <td class="p-2 border">{{ $review->product->name }}</td>
                    <td class="p-2 border text-yellow-500">
                        {{ str_repeat('★', $review->rating) }}
                        {{ str_repeat('☆', 5 - $review->rating) }}
                    </td>
                    <td class="p-2 border">{{ $review->comment }}</td>
                    <td class="p-2 border">{{ $review->created_at->format('d M Y') }}</td>
                    <td class="p-2 border space-x-2">
                        <a href="{{ route('reviews.edit', $review->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>
                        <form action="{{ route('reviews.delete', $review->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $reviews->links() }}
    </div>
</div>
@endsection
