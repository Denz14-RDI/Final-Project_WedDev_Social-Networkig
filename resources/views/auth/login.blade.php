@extends('layouts.guest')
@section('title', 'Sign in')

@section('content')
<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">
  <!-- LEFT (maroon panel) - logo only -->
  <div class="hidden md:flex items-center justify-center bg-[#6C1517]">
    <img
      src="{{ asset('images/logo.png') }}"
      alt="PUPCOM Logo"
      class="w-[1000px] h-auto opacity-95 select-none"
    >
  </div>

  <!-- RIGHT (beige background + login card like your screenshot) -->
  <div class="flex items-center justify-center bg-[#F2EADA] px-6 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
      <!-- Title (changed) -->
      <h2 class="text-3xl font-extrabold text-gray-900">Sign in to PUPCOM</h2>

      <!-- Tabs/Pill -->
      <div class="mt-5 rounded-full bg-[#E9E0E0] p-1 flex gap-1">
        <!-- Active tab (Login) -->
        <div class="flex-1 text-center">
          <span class="block w-full rounded-full bg-white py-2 text-sm font-semibold text-gray-900 shadow-sm">
            Sign in
          </span>
        </div>

        <!-- Link tab (Sign Up) -->
        <a
          href="{{ route('register') }}"
          class="flex-1 text-center block rounded-full py-2 text-sm font-semibold text-gray-700 hover:text-gray-900"
        >
          Create account
        </a>
      </div>

      <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf

        <!-- Email or Username -->
        <div>
          <label class="block text-sm font-semibold text-gray-800">Email or Username</label>
          <input
            type="text"
            name="login"
            value="{{ old('login') }}"
            placeholder="iskolar@pup.edu.ph"
            required
            class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/25 focus:border-[#6C1517]"
          >
          @error('login')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password + Forgot -->
        <div>
          <div class="flex items-center justify-between">
            <label class="block text-sm font-semibold text-gray-800">Password</label>

            <a href="#" class="text-sm font-semibold text-[#6C1517] hover:underline">
              Forgot password?
            </a>
          </div>

          <input
            type="password"
            name="password"
            placeholder="Password"
            required
            class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/25 focus:border-[#6C1517]"
          >
          @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Remember me -->
        <div class="flex items-center gap-2">
          <input
            id="remember"
            type="checkbox"
            name="remember"
            class="h-4 w-4 rounded border-gray-300 text-[#6C1517] focus:ring-[#6C1517]/30"
          >
          <label for="remember" class="text-sm text-gray-700">Remember me</label>
        </div>

        <!-- Button -->
        <button
          type="submit"
          class="w-full rounded-xl bg-[#6C1517] py-3 font-semibold text-white shadow-sm hover:opacity-95"
        >
          Sign In
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
