@extends('layouts.app')
@section('title','Friends')

@section('content')
  @php
  $authUser = auth()->user();
  $friends = $authUser->friends()->get();
  $pendingRequests = $authUser->friendRequestsReceived()->where('status', 'pending')->get();
  @endphp
  <div class="min-h-screen bg-[var(--bg)]">
    <div class="max-w-4xl mx-auto px-6 py-10">
      <div class="bg-white rounded-2xl shadow p-6">
        <h1 class="text-xl font-bold mb-4">Friends ({{ $friends->count() }})</h1>

        <div class="space-y-4">
          @forelse($friends as $friend)
          <div class="flex items-center justify-between border rounded-xl p-4">
            <div>
              <div class="font-semibold">{{ $friend->first_name }} {{ $friend->last_name }}</div>
              <div class="text-sm text-gray-600">@{{ $friend->username }}</div>
            </div>
            <form action="{{ route('friends.unfriend', $friend->user_id) }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="px-4 py-2 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">
                Unfriend
              </button>
            </form>
          </div>
          @empty
          <p class="text-gray-500">No friends yet. Start adding friends!</p>
          @endforelse

        <div class="mt-6">
          <a href="{{ route('feed') }}" class="text-[#6C1517] font-semibold hover:underline">
            ← Back to Feed
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
