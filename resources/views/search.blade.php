@extends('layouts.app')
@section('title','Search')

@section('content')
  <div class="min-h-screen bg-[var(--bg)]">
    <div class="max-w-4xl mx-auto px-6 py-10">
      <div class="bg-white rounded-2xl shadow p-6">
        <div class="font-bold text-lg mb-3">Search</div>

        <input
          type="text"
          placeholder="Search by full name or username..."
          class="w-full border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]"
        />
      </div>
    </div>
  </div>
@endsection
