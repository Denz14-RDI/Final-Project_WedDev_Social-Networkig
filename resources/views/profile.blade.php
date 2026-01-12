@extends('layouts.app')
@section('title','Profile')

@section('content')
  <div class="min-h-screen bg-[var(--bg)]">
    <div class="max-w-4xl mx-auto px-6 py-10">
      <div class="bg-white rounded-2xl shadow p-6">
        <h1 class="text-xl font-bold mb-4">Profile</h1>

        <div class="flex items-start gap-6">
          <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
            IMG
          </div>

          <div class="flex-1">
            <div class="text-lg font-bold">Juan Dela Cruz</div>
            <div class="text-sm text-gray-600">@juan_delacruz • Student</div>
            <p class="mt-3 text-sm text-gray-700">
              Hello! I’m part of the PUP community.
            </p>

            <div class="mt-4 flex gap-6 text-sm">
              <div><span class="font-bold">0</span> Followers</div>
              <div><span class="font-bold">0</span> Following</div>
              <div><span class="font-bold">0</span> Posts</div>
            </div>
          </div>

          <button class="px-4 py-2 rounded-xl bg-[#6C1517] text-white font-semibold hover:opacity-90 transition">
            Edit Profile
          </button>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="border rounded-2xl p-4">
            <div class="font-bold mb-2">Recent Activity</div>
            <div class="text-sm text-gray-600">This user hasn't posted anything yet.</div>
          </div>

          <div class="border rounded-2xl p-4">
            <div class="font-bold mb-2">Photos</div>
            <div class="grid grid-cols-2 gap-3">
              <div class="h-20 rounded-xl bg-gray-200"></div>
              <div class="h-20 rounded-xl bg-gray-200"></div>
              <div class="h-20 rounded-xl bg-gray-200"></div>
              <div class="h-20 rounded-xl bg-gray-200"></div>
            </div>
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
