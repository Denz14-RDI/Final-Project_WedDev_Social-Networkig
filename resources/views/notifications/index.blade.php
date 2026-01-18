s@extends('layouts.app')
@section('title', 'Notifications')

@section('main_class', 'bg-app-page')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Notifications</h1>
        @if (\App\Models\Notification::where('user_id', auth()->user()->user_id)->whereNull('read_at')->count() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Mark All as Read</button>
            </form>
        @endif
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-3">
        @forelse ($notifications as $notification)
            <div class="bg-white rounded-lg shadow-md p-4 {{ !$notification->read_at ? 'border-l-4 border-blue-500' : '' }}">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        @if ($notification->notif_type === 'new_comment')
                            <p class="font-semibold">💬 New Comment</p>
                            @php $data = json_decode($notification->notif_data); @endphp
                            <p class="text-gray-700 text-sm">{{ $data->message ?? 'Someone commented on your post' }}</p>
                        @elseif ($notification->notif_type === 'new_like')
                            <p class="font-semibold">❤️ New Like</p>
                            @php $data = json_decode($notification->notif_data); @endphp
                            <p class="text-gray-700 text-sm">{{ $data->message ?? 'Someone liked your post' }}</p>
                        @elseif ($notification->notif_type === 'new_friend')
                            <p class="font-semibold">👥 Friend Request</p>
                            @php $data = json_decode($notification->notif_data); @endphp
                            <p class="text-gray-700 text-sm">{{ $data->message ?? 'Someone sent you a friend request' }}</p>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        @if (!$notification->read_at)
                            <form action="{{ route('notifications.read', $notification) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-blue-500 hover:text-blue-700 text-sm">Mark as Read</button>
                            </form>
                        @endif
                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                        </form>
                    </div>
                </div>
                <p class="text-gray-500 text-xs">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-500 mb-4">No notifications yet.</p>
                <p class="text-gray-400 text-sm">You'll get notifications when people interact with your posts.</p>
            </div>
        @endforelse
    </div>

    @if ($notifications->hasPages())
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
