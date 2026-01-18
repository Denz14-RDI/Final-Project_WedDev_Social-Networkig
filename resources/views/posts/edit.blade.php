@extends('layouts.app')
@section('title', 'Edit Post')

@section('main_class', 'bg-app-page')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Edit Post</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')

        <!-- Category -->
        <div class="mb-4">
            <label for="category" class="block text-gray-700 font-semibold mb-2">Category</label>
            <select id="category" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">Select a category</option>
                <option value="academic" {{ $post->category === 'academic' ? 'selected' : '' }}>Academic</option>
                <option value="events" {{ $post->category === 'events' ? 'selected' : '' }}>Events</option>
                <option value="announcement" {{ $post->category === 'announcement' ? 'selected' : '' }}>Announcement</option>
                <option value="campus_life" {{ $post->category === 'campus_life' ? 'selected' : '' }}>Campus Life</option>
                <option value="help_wanted" {{ $post->category === 'help_wanted' ? 'selected' : '' }}>Help Wanted</option>
            </select>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Post Content -->
        <div class="mb-4">
            <label for="post_content" class="block text-gray-700 font-semibold mb-2">Post Content</label>
            <textarea id="post_content" name="post_content" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('post_content', $post->post_content) }}</textarea>
            @error('post_content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image -->
        <div class="mb-4">
            @if ($post->image)
                <div class="mb-2">
                    <img src="{{ Storage::url($post->image) }}" alt="Current image" class="w-full h-auto rounded-lg max-h-48 object-cover">
                </div>
            @endif
            <label for="image" class="block text-gray-700 font-semibold mb-2">Change Image (Optional)</label>
            <input type="file" id="image" name="image" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Link -->
        <div class="mb-6">
            <label for="link" class="block text-gray-700 font-semibold mb-2">Link (Optional)</label>
            <input type="url" id="link" name="link" value="{{ old('link', $post->link) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('link')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg">Update Post</button>
            <a href="{{ route('posts.show', $post) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg">Cancel</a>
        </div>
    </form>
</div>
@endsection
