@extends('layouts.guest')
@section('title', 'Welcome')

@section('content')
<div
  class="min-h-screen relative flex items-center justify-center px-6 py-10 bg-cover bg-center bg-no-repeat"
  style="background-image: url('{{ asset('images/welcome-bg.png') }}');">
  {{-- overlay (adjust if too dark) --}}
  <div class="absolute inset-0 bg-black/15"></div>

  <div class="relative z-10 w-full max-w-6xl text-center">

    {{-- top pill --}}
    <div class="inline-flex items-center gap-2 rounded-full
            bg-white/75 backdrop-blur
            px-7 py-3 text-lg font-bold text-[#6C1517]
            ring-1 ring-[#6C1517]/10
            shadow-[0_10px_25px_rgba(0,0,0,.18)]">
      <span class="text-xl">🎓</span>
      <span>Welcome to the PUP Community</span>
    </div>

    {{-- main heading --}}
    <h1 class="mt-7 text-7xl md:text-8xl font-bold tracking-tight leading-[1.02] text-[#0F172A]">
      Welcome to
      <span class="block text-[#6C1517] drop-shadow-[0_10px_25px_rgba(0,0,0,.25)]">PUPCOM</span>
    </h1>

    {{-- subtitle --}}
    <p class="mt-6 text-xl md:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed drop-shadow-[0_10px_25px_rgba(0,0,0,.25)]">
      The premier digital home for the
      <span class="font-semibold underline decoration-yellow-300 decoration-4 underline-offset-4">Iskolar ng Bayan</span>.
      Connect with peers, share updates, and discover what's happening across the campus.
    </p>

    {{-- button --}}
    <div class="mt-10 flex items-center justify-center">
      <a href="{{ route('login') }}"
        class="inline-flex items-center justify-center gap-2
          px-10 py-4 rounded-2xl
          bg-[#6C1517] text-white font-semibold text-lg
          shadow-[0_18px_35px_rgba(108,21,23,.35)]
          hover:opacity-95">
        Get Started <span class="text-xl">→</span>
      </a>
    </div>

    {{-- feature cards --}}
    <div class="mt-14 grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
      <div class="bg-white/75 backdrop-blur rounded-3xl border border-white/60 shadow-[0_18px_40px_rgba(0,0,0,.15)] p-10">
        <div class="h-14 w-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">👥</div>
        <h3 class="mt-6 text-xl font-extrabold text-[#0F172A]">Connect</h3>
        <p class="mt-3 text-base text-gray-700 leading-relaxed">
          Find and interact with students from all colleges and branches.
        </p>
      </div>

      <div class="bg-white/75 backdrop-blur rounded-3xl border border-white/60 shadow-[0_18px_40px_rgba(0,0,0,.15)] p-10">
        <div class="h-14 w-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">📣</div>
        <h3 class="mt-6 text-xl font-extrabold text-[#0F172A]">Engage</h3>
        <p class="mt-3 text-base text-gray-700 leading-relaxed">
          Stay updated with official news and student-led initiatives.
        </p>
      </div>

      <div class="bg-white/75 backdrop-blur rounded-3xl border border-white/60 shadow-[0_18px_40px_rgba(0,0,0,.15)] p-10">
        <div class="h-14 w-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">⚡</div>
        <h3 class="mt-6 text-xl font-extrabold text-[#0F172A]">Discover</h3>
        <p class="mt-3 text-base text-gray-700 leading-relaxed">
          Use AI-powered tools to discover relevant academic content.
        </p>
      </div>
    </div>

  </div>
</div>
@endsection