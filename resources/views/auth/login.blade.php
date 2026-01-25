@extends('layouts.guest')
@section('title', 'Log in')

@section('content')
<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

  <!-- LEFT (background image panel) -->
  <div
    class="hidden md:flex items-center justify-center relative overflow-hidden"
    style="background-image: url('/images/pupbg.png'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-gradient-to-tr from-[#F59E0B]/50 via-[#EF4444]/35 to-[#6C1517]/55"></div>
    <div class="absolute inset-0 bg-black/10"></div>

    <img
      src="{{ asset('images/logo.png') }}"
      alt="PUPCOM Logo"
      class="relative z-10 w-60 sm:w-72 lg:w-80 xl:w-96 max-w-[380px] h-auto opacity-95 select-none
    drop-shadow-[0_18px_35px_rgba(0,0,0,.35)]">
  </div>

  <!-- RIGHT (beige background + login card) -->
  <div class="flex items-center justify-center bg-[#F2EADA] px-6 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

      <!-- ✅ Return button -->
      <a
        href="{{ route('signin.choice') }}"
        class="inline-flex items-center gap-2 text-sm font-semibold text-[#6C1517] hover:underline">
        <span aria-hidden="true">←</span>
        Return to Sign in choice
      </a>

      <h2 class="mt-3 text-3xl font-extrabold text-gray-900">Login to PUPCOM</h2>

      <!-- Tabs/Pill -->
      <div class="mt-5 rounded-full bg-[#E9E0E0] p-1 flex gap-1">
        <div class="flex-1 text-center">
          <span class="block w-full rounded-full bg-white py-2 text-sm font-semibold text-gray-900 shadow-sm">
            Login
          </span>
        </div>

        <a
          href="{{ route('register') }}"
          class="flex-1 text-center block rounded-full py-2 text-sm font-semibold text-gray-700 hover:text-gray-900">
          Create Account
        </a>
      </div>

      <!-- ✅ Flash Messages -->
      @if (session('success'))
      <div class="mb-4 rounded-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3">
        {{ session('success') }}
      </div>
      @endif

      @if ($errors->any())
      <div class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      @if (session('error'))
      <div class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3">
        {{ session('error') }}
      </div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf

        <!-- Email or Username -->
        <div>
          <label class="block text-sm font-semibold text-gray-800">Email or Username</label>
          <input
            type="text"
            name="login"
            value="{{ old('login') }}"
            placeholder="@iskolarngbayan.pup.edu.ph"
            required
            class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 outline-none text-black focus:ring-2 focus:ring-[#6C1517]/25 focus:border-[#6C1517]">
          @error('login')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm font-semibold text-gray-800">Password</label>
          <input
            type="password"
            name="password"
            placeholder="Password"
            required
            class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 outline-none text-black focus:ring-2 focus:ring-[#6C1517]/25 focus:border-[#6C1517]">
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
            class="h-4 w-4 rounded border-gray-300 text-[#6C1517] focus:ring-[#6C1517]/30">
          <label for="remember" class="text-sm text-gray-700">Remember me</label>
        </div>

        <!-- Button -->
        <button
          type="submit"
          class="w-full rounded-xl bg-[#6C1517] py-3 font-semibold text-white shadow-sm hover:opacity-95">
          Login
        </button>
      </form>

    </div>
  </div>

</div>
@endsection