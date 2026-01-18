@extends('layouts.app')
@section('title', $post->post_content ? substr($post->post_content, 0, 30) . '...' : 'Post')

@section('main_class', 'bg-app-page')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Post -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <!-- Post Header -->
        <div class="flex justify-between items-start mb-4">
            <div class="flex items-center">
                <img src="{{ $post->user->profile_pic ?? 'https://i.pravatar.cc/120?img=' . $post->user->user_id }}" alt="{{ $post->user->first_name }}" class="w-12 h-12 rounded-full mr-4">
                <div>
                    <h3 class="font-bold text-lg">{{ $post->user->first_name }} {{ $post->user->last_name }}</h3>
                    <p class="text-gray-500 text-sm">{{ $post->user->username }}</p>
                    <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @if (auth()->user()->user_id === $post->user_id)
                <div class="flex gap-2">
                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Category Badge -->
        <div class="mb-2">
            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full capitalize">{{ str_replace('_', ' ', $post->category) }}</span>
        </div>

        <!-- Post Content -->
        <p class="text-gray-800 mb-4">{{ $post->post_content }}</p>

        <!-- Image -->
        @if ($post->image)
            <img src="{{ Storage::url($post->image) }}" alt="Post image" class="w-full h-auto rounded-lg mb-4 max-h-96 object-cover">
        @endif

        <!-- Link -->
        @if ($post->link)
            <a href="{{ $post->link }}" target="_blank" class="text-blue-500 hover:text-blue-700 mb-4 inline-block">{{ $post->link }}</a>
        @endif

        <!-- Post Stats -->
        <div class="flex gap-6 text-gray-500 text-sm mb-4 border-t pt-4">
            <span>{{ $post->likes()->count() }} Likes</span>
            <span>{{ $post->comments()->count() }} Comments</span>
        </div>

        <!-- Like & Comment Buttons -->
        <div class="flex gap-4 border-t border-b py-2">
            <form action="{{ route('likes.toggle', $post) }}" method="POST" style="flex: 1;">
                @csrf
                <button type="submit" class="w-full text-gray-600 hover:text-blue-500 font-semibold py-2">
                    {{ $post->isLikedByUser(auth()->user()->user_id) ? '❤️ Unlike' : '🤍 Like' }}
                </button>
            </form>
            <button onclick="document.getElementById('comment-form').scrollIntoView({behavior: 'smooth'})" class="flex-1 text-gray-600 hover:text-blue-500 font-semibold py-2">
                💬 Comment
            </button>
        </div>
    </div>

    <!-- Comments -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-xl font-bold mb-4">Comments ({{ $post->comments()->count() }})</h3>

        @if ($post->comments()->count() > 0)
            <div class="space-y-4 mb-6">
                @foreach ($post->comments as $comment)
                    <div class="border-l-4 border-gray-300 pl-4 py-2">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center mb-2">
                                <img src="{{ $comment->user->profile_pic ?? 'https://i.pravatar.cc/120?img=' . $comment->user->user_id }}" alt="{{ $comment->user->first_name }}" class="w-8 h-8 rounded-full mr-2">
                                <div>
                                    <p class="font-semibold">{{ $comment->user->first_name }} {{ $comment->user->last_name }}</p>
                                    <p class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if (auth()->user()->user_id === $comment->user_id)
                                <div class="flex gap-2">
                                    <a href="{{ route('comments.edit', $comment) }}" class="text-blue-500 hover:text-blue-700 text-sm">Edit</a>
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Delete comment?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <p class="text-gray-700">{{ $comment->com_content }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 mb-6">No comments yet. Be the first to comment!</p>
        @endif

        <!-- Comment Form -->
        <div id="comment-form" class="border-t pt-4">
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf
                <div class="flex gap-2 mb-2">
                    <img src="{{ auth()->user()->profile_pic ?? 'https://i.pravatar.cc/120?img=' . auth()->user()->user_id }}" alt="{{ auth()->user()->first_name }}" class="w-8 h-8 rounded-full">
                    <textarea name="com_content" placeholder="Add a comment..." rows="2" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>
                @error('com_content')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">Comment</button>
            </form>
        </div>
    </div>

    <!-- Report Button -->
    <div class="text-center">
        <a href="{{ route('reports.create', $post) }}" class="text-red-500 hover:text-red-700 font-semibold">🚩 Report Post</a>
    </div>
</div>
@endsection
