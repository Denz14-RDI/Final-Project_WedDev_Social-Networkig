@extends('layouts.app')
@section('title', 'Edit Comment')

@section('main_class', 'bg-app-page')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Edit Comment</h1>

    <form action="{{ route('comments.update', $comment) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label for="com_content" class="block text-gray-700 font-semibold mb-2">Comment</label>
            <textarea id="com_content" name="com_content" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('com_content', $comment->com_content) }}</textarea>
            @error('com_content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg">Update Comment</button>
            <a href="{{ route('posts.show', $comment->post) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg">Cancel</a>
        </div>
    </form>
</div>
@endsection
