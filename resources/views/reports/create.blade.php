@extends('layouts.app')
@section('title', 'Report Post')

@section('main_class', 'bg-app-page')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Report Post</h1>

    <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded mb-6">
        Help us keep the PUPCOM community safe. Please report posts that violate our community guidelines.
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="font-bold text-lg mb-2">{{ $post->user->first_name }} {{ $post->user->last_name }}</h3>
        <p class="text-gray-700 mb-2">{{ $post->post_content }}</p>
        @if ($post->image)
            <img src="{{ Storage::url($post->image) }}" alt="Post image" class="w-full h-auto rounded-lg max-h-48 object-cover">
        @endif
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reports.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->post_id }}">

        <!-- Reason -->
        <div class="mb-4">
            <label for="reason" class="block text-gray-700 font-semibold mb-2">Reason for Report</label>
            <select id="reason" name="reason" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">Select a reason</option>
                <option value="spam">Spam</option>
                <option value="harassment">Harassment</option>
                <option value="misinformation">Misinformation</option>
                <option value="inappropriate">Inappropriate Content</option>
                <option value="other">Other</option>
            </select>
            @error('reason')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Details -->
        <div class="mb-6">
            <label for="details" class="block text-gray-700 font-semibold mb-2">Additional Details (Optional)</label>
            <textarea id="details" name="details" rows="4" placeholder="Provide more context about why you're reporting this post..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('details') }}</textarea>
            @error('details')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg">Submit Report</button>
            <a href="{{ route('posts.show', $post) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg">Cancel</a>
        </div>
    </form>
</div>
@endsection
