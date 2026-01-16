@extends('layouts.app')
@section('title','Search')

{{-- admin palette bg --}}
@section('main_class', 'bg-app-page')

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
      <div class="w-full max-w-[840px] mx-auto space-y-5">

        {{-- Header --}}
        <div>
          <div class="text-3xl font-extrabold text-app leading-tight">Search</div>
          <div class="text-sm text-app-muted">Find people, organizations, and trends in PUPCOM</div>
        </div>

        {{-- Search box --}}
        <form action="{{ route('search') }}" method="GET"
          class="bg-app-card rounded-2xl border border-app shadow-[0_10px_18px_rgba(0,0,0,.08)] p-4">
          <div class="flex items-center gap-3 h-11 rounded-full bg-white border border-app px-5">
            <span class="text-app-muted">🔍</span>
            <input
              type="text"
              name="q"
              value="{{ $q }}"
              placeholder="Search PUPCOM..."
              class="w-full bg-transparent outline-none text-sm text-app placeholder:text-app-mutedlight" />
          </div>
        </form>

        {{-- Results --}}
        <div class="bg-app-card rounded-2xl border border-app shadow-[0_10px_18px_rgba(0,0,0,.08)] overflow-hidden">

          <div class="p-6 pb-4 flex items-center justify-between">
            <div class="text-lg font-extrabold flex items-center gap-2 text-app">
              <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-[#6C1517] text-white text-sm">👥</span>
              <span>People to Follow</span>
            </div>

            {{-- optional: small count --}}
            <div class="text-xs text-app-muted">
              {{ count($people) }} results
            </div>
          </div>

          <div class="px-6 pb-6 space-y-4">
            @foreach($people as $p)
            <div class="flex items-center justify-between gap-4 rounded-2xl border border-app bg-white p-4">

              <div class="flex items-center gap-4 min-w-0">
                <img
                  class="h-12 w-12 rounded-full object-cover border border-app"
                  src="{{ $p['avatar'] }}"
                  alt="avatar">

                <div class="leading-tight min-w-0">
                  <div class="flex items-center gap-2 flex-wrap">
                    <div class="font-extrabold text-app truncate">{{ $p['name'] }}</div>

                    @if(!empty($p['badge']))
                    <span class="rounded-full bg-amber-50 border border-app px-2.5 py-1 text-xs font-semibold text-[#D97706]">
                      {{ $p['badge'] }}
                    </span>
                    @endif
                  </div>

                  <div class="text-sm text-app-muted">{{ $p['handle'] }}</div>
                  <div class="text-sm text-app-muted mt-1">{{ $p['meta'] }}</div>
                </div>
              </div>

              <button
                type="button"
                class="shrink-0 px-4 py-2 rounded-full border border-app bg-white text-sm font-semibold text-app hover:bg-black/5">
                Follow
              </button>

            </div>
            @endforeach
          </div>

        </div>

      </div>
    </section>

    {{-- RIGHT SIDEBAR --}}
    @include('partials.right-sidebar')

  </div>
</div>
@endsection