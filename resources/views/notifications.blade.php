@extends('layouts.app')
@section('title','Notifications')

@section('content')
  <div class="min-h-screen bg-[var(--bg)]">
    <div class="max-w-4xl mx-auto px-6 py-10">
      <div class="bg-white rounded-2xl shadow p-6">
        <h1 class="text-xl font-bold mb-4">Notifications</h1>

        <div class="space-y-3">
          <div class="border rounded-xl p-4">
            <div class="font-semibold">@juan_delacruz</div>
            <div class="text-sm text-gray-600">liked your post</div>
            <div class="text-xs text-gray-400 mt-1">Today • 4:34 PM</div>
          </div>

          <div class="border rounded-xl p-4">
            <div class="font-semibold">@pup_csc</div>
            <div class="text-sm text-gray-600">commented on your post</div>
            <div class="text-xs text-gray-400 mt-1">Today • 4:34 PM</div>
          </div>
        </div>

        <div class="mt-6">
          <a href="{{ route('feed') }}" class="text-[#6C1517] font-semibold hover:underline">
            ← Back to Feed
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
