@extends('layouts.app')
@section('title','Friends')

@section('content')
@php
  {{-- Get the currently logged-in user --}}
  $authUser = auth()->user();
@endphp

{{-- Page background + full height --}}
<div class="min-h-screen bg-[var(--bg)]">
  <div class="max-w-4xl mx-auto px-6 py-10">
    <div class="bg-white rounded-2xl shadow p-6">

      {{-- Following List --}}
      <h1 class="text-xl font-bold mb-4">
        Following ({{ $following->total() }})
      </h1>

      {{-- List container --}}
      <div class="space-y-4">
        @forelse($following as $row)
          @php
            $target = $row->following; // user_id_2
          @endphp

          <div class="flex items-center justify-between border rounded-xl p-4">
            <div class="flex items-center gap-4 min-w-0">

              {{-- Profile picture --}}
              <img
                class="h-12 w-12 rounded-full object-cover border border-gray-200"
                src="{{ asset(!empty($target->profile_pic) ? $target->profile_pic : 'images/default.png') }}"
                alt="avatar">

              {{-- Name + Username --}}
              <div class="min-w-0">
                <div class="font-semibold truncate">
                  {{ $target->first_name ?? '' }} {{ $target->last_name ?? '' }}
                </div>

                <div class="text-sm text-gray-600">
                  @if(!empty($target->username))
                    {{ '@' . $target->username }}
                  @else
                    <span class="italic text-gray-400">No username</span>
                  @endif
                </div>
              </div>
            </div>

            {{-- Unfollow button --}}
            <form action="{{ route('friends.unfollow', $row) }}" method="POST" class="inline">
              @csrf
              <button type="submit"
                class="px-4 py-2 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-100 transition">
                Unfollow
              </button>
            </form>
          </div>
        
        {{-- If no following users --}}
        @empty
          <p class="text-gray-500">You are not following anyone yet.</p>
        @endforelse
      </div>

      {{-- Pagination controls --}}
      <div class="mt-6">
        {{ $following->links() }}
      </div>

      {{-- Back to Feed link --}}
      <div class="mt-6">
        <a href="{{ route('feed') }}" class="text-[#6C1517] font-semibold hover:underline">
          ← Back to Feed
        </a>
      </div>

    </div>
  </div>
</div>
@endsection
