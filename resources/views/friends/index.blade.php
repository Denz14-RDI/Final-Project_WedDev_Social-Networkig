@extends('layouts.app')
@section('title', 'Friends')

@section('main_class', 'bg-app-page')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Friends</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Friends List -->
        <div class="md:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Your Friends</h2>

            @if ($friends->count() > 0)
                <div class="space-y-4">
                    @foreach ($friends as $friendship)
                        @php
                            $friend = $friendship->user_id_1 === auth()->user()->user_id 
                                ? $friendship->userTwo 
                                : $friendship->userOne;
                        @endphp
                        <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                            <div class="flex items-center gap-4">
                                <img src="{{ $friend->profile_pic ?? 'https://i.pravatar.cc/120?img=' . $friend->user_id }}" alt="{{ $friend->first_name }}" class="w-12 h-12 rounded-full">
                                <div>
                                    <h3 class="font-bold">{{ $friend->first_name }} {{ $friend->last_name }}</h3>
                                    <p class="text-gray-500 text-sm">@{{ $friend->username }}</p>
                                    @if ($friend->bio)
                                        <p class="text-gray-600 text-sm mt-1">{{ $friend->bio }}</p>
                                    @endif
                                </div>
                            </div>
                            <form action="{{ route('friends.unfriend', $friendship) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-4 rounded">Unfriend</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">You don't have any friends yet. Find people to connect with!</p>
            @endif

            @if ($friends->hasPages())
                <div class="mt-6">
                    {{ $friends->links() }}
                </div>
            @endif
        </div>

        <!-- Pending Friend Requests -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Friend Requests</h2>

            @php
                $pendingRequests = \App\Models\Friend::where('user_id_2', auth()->user()->user_id)
                    ->where('status', 'pending')
                    ->with(['userOne'])
                    ->get();
            @endphp

            @if ($pendingRequests->count() > 0)
                <div class="space-y-3">
                    @foreach ($pendingRequests as $request)
                        <div class="p-3 border rounded-lg">
                            <p class="font-semibold text-sm mb-2">{{ $request->userOne->first_name }} {{ $request->userOne->last_name }}</p>
                            <div class="flex gap-2 text-xs">
                                <form action="{{ route('friends.accept', $request) }}" method="POST" style="flex: 1;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-1 rounded">Accept</button>
                                </form>
                                <form action="{{ route('friends.decline', $request) }}" method="POST" style="flex: 1;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 py-1 rounded">Decline</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">No pending friend requests.</p>
            @endif
        </div>
    </div>
</div>
@endsection
