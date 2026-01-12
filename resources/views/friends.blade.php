@extends('layouts.app')
@section('title','Friends')

@section('content')
  <div class="min-h-screen bg-[var(--bg)]">
    <div class="max-w-4xl mx-auto px-6 py-10">
      <div class="bg-white rounded-2xl shadow p-6">
        <h1 class="text-xl font-bold mb-4">Friends</h1>

        <div class="space-y-4">
          <div class="flex items-center justify-between border rounded-xl p-4">
            <div>
              <div class="font-semibold">PUP Administration</div>
              <div class="text-sm text-gray-600">@pup_admin • Admin</div>
            </div>
            <button class="px-4 py-2 rounded-xl border border-[#6C1517] text-[#6C1517] font-semibold hover:bg-[#6C1517] hover:text-white transition">
              Add Friend
            </button>
          </div>

          <div class="flex items-center justify-between border rounded-xl p-4">
            <div>
              <div class="font-semibold">Juan Dela Cruz</div>
              <div class="text-sm text-gray-600">@juan_delacruz • Student</div>
            </div>
            <button class="px-4 py-2 rounded-xl border border-[#6C1517] text-[#6C1517] font-semibold hover:bg-[#6C1517] hover:text-white transition">
              Add Friend
            </button>
          </div>

          <div class="flex items-center justify-between border rounded-xl p-4">
            <div>
              <div class="font-semibold">Central Student Council</div>
              <div class="text-sm text-gray-600">@pup_csc • Organization</div>
            </div>
            <button class="px-4 py-2 rounded-xl border border-[#6C1517] text-[#6C1517] font-semibold hover:bg-[#6C1517] hover:text-white transition">
              Add Friend
            </button>
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
