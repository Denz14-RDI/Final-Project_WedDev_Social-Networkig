@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">
  <!-- LEFT (maroon panel) -->
  <div class="hidden md:flex items-center justify-center bg-[#6C1517]">
    <div class="max-w-md px-10">
      <h1 class="text-4xl font-extrabold text-white">Welcome back</h1>
      <p class="mt-2 text-white/80">Sign in to continue.</p>
    </div>
  </div>

  <!-- RIGHT (beige background + form card) -->
  <div class="flex items-center justify-center bg-[#F2EADA] px-6 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
      <!-- Optional small header -->
      <div class="text-center mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="PUPCOM Logo" class="mx-auto h-12 w-auto mb-2">
        <h2 class="text-2xl font-bold text-gray-900">Sign in</h2>
      </div>

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:ring-2 focus:ring-[#6C1517]/40 focus:border-[#6C1517]"
          >
          @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <input
            type="password"
            name="password"
            required
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:ring-2 focus:ring-[#6C1517]/40 focus:border-[#6C1517]"
          >
          @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <button
          type="submit"
          class="w-full rounded-lg bg-[#6C1517] py-2.5 font-semibold text-white hover:opacity-95"
        >
          Sign in
        </button>

        <p class="text-center text-sm text-gray-600 pt-2">
          No account?
          <a href="{{ route('register') }}" class="font-semibold text-[#6C1517] hover:underline">
            Create one
          </a>
        </p>
      </form>
    </div>
  </div>
</div>
@endsection
