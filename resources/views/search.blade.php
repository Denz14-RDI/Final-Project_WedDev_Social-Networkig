@extends('layouts.app')
@section('title','Search')

{{-- match feed background --}}
@section('main_class', 'bg-[#F3F3F3]')

@section('content')
@php
$q = request('q', '');

// demo data (replace with DB later)
$people = [
[
'name' => 'Juan Dela Cruz',
'handle' => '@juandc',
'meta' => 'BSIT Student | Web Developer | Coffee Enthusiast',
'avatar' => 'https://i.pravatar.cc/120?img=12',
'badge' => null,
],
[
'name' => 'PUP Central Student Organization',
'handle' => '@pupcso',
'meta' => 'Official student organization of PUP',
'avatar' => 'https://i.pravatar.cc/120?img=32',
'badge' => 'Organization',
],
[
'name' => 'Prof. Maria Santos',
'handle' => '@mariasantos',
'meta' => 'Associate Professor | CCIS',
'avatar' => 'https://i.pravatar.cc/120?img=49',
'badge' => 'Faculty',
],
[
'name' => 'PUP Tech Club',
'handle' => '@puptechclub',
'meta' => 'Technology and Innovation Club',
'avatar' => 'https://i.pravatar.cc/120?img=15',
'badge' => 'Organization',
],
[
'name' => 'PUP Alumni Association',
'handle' => '@pupalumni',
'meta' => 'Connecting PUP graduates',
'avatar' => 'https://i.pravatar.cc/120?img=8',
'badge' => 'Alumni',
],
];
@endphp

<div class="h-screen overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER (scroll) --}}
    <section class="px-4 sm:px-6 lg:px-10 py-8 overflow-y-auto">
      <div class="w-full max-w-[980px] mx-auto space-y-6">

        {{-- Header --}}
        <div>
          <div class="text-3xl font-extrabold text-gray-900 leading-tight">Search</div>
          <div class="text-sm text-gray-500">Find people, organizations, and trends in PUPCOM</div>
        </div>

        {{-- Search box --}}
        <form action="{{ route('search') }}" method="GET"
          class="bg-white rounded-2xl border border-gray-300 shadow-[0_10px_18px_rgba(0,0,0,.08)] p-4">
          <div class="flex items-center gap-3">
            <span class="text-gray-400">🔍</span>
            <input
              type="text"
              name="q"
              value="{{ $q }}"
              placeholder="Search PUPCOM..."
              class="w-full bg-transparent outline-none text-sm placeholder:text-gray-400" />
          </div>
        </form>

        {{-- Results --}}
        <div class="bg-white rounded-2xl border border-gray-300 shadow-[0_10px_18px_rgba(0,0,0,.08)] p-6">
          <div class="text-lg font-extrabold flex items-center gap-2">
            <span>👥</span>
            <span>People to Follow</span>
          </div>

          <div class="mt-5 space-y-4">
            @foreach($people as $p)
            <div class="flex items-center justify-between rounded-2xl border border-gray-200 bg-white p-4">
              <div class="flex items-center gap-4">
                <img class="h-12 w-12 rounded-full object-cover" src="{{ $p['avatar'] }}" alt="avatar">
                <div class="leading-tight">
                  <div class="flex items-center gap-2">
                    <div class="font-extrabold text-gray-900">{{ $p['name'] }}</div>
                    @if(!empty($p['badge']))
                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">
                      {{ $p['badge'] }}
                    </span>
                    @endif
                  </div>
                  <div class="text-sm text-gray-500">{{ $p['handle'] }}</div>
                  <div class="text-sm text-gray-600 mt-1">{{ $p['meta'] }}</div>
                </div>
              </div>

              <button class="rounded-xl border border-gray-200 px-4 py-2 font-semibold hover:bg-gray-50">
                Follow
              </button>
            </div>
            @endforeach
          </div>
        </div>

      </div>
    </section>

    {{-- RIGHT SIDEBAR (UNIFIED PARTIAL) --}}
    @include('partials.right-sidebar')

  </div>
</div>
@endsection