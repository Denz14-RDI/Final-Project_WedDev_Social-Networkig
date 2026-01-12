@extends('layouts.guest')
@section('title', 'Create your account')

@section('content')
<div class="min-h-screen bg-[#F2EADA] flex">
  {{-- Left panel (maroon) --}}
  <div class="hidden lg:flex lg:w-1/2 bg-[#6C1517] relative items-center justify-center">
    {{-- Big centered logo (X-style) --}}
    <img
      src="{{ asset('images/logo.png') }}"
      alt="PUPCOM Logo"
      class="w-[1000px] h-auto opacity-95 select-none">
  </div>

  {{-- Right panel --}}
  <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-md">
      {{-- optional small logo on mobile --}}
      <div class="lg:hidden flex flex-col items-center mb-8">
        <img src="{{ asset('images/logo.png') }}" alt="PUPCOM Logo" class="h-16 w-auto mb-3">
        <div class="text-2xl font-extrabold text-[#6C1517] tracking-wide">PUPCOM</div>
        <div class="text-sm text-gray-500">Connect with your fellow Iskolar ng Bayan</div>
      </div>

      <div class="bg-white rounded-2xl shadow-[0_18px_40px_rgba(0,0,0,.12)] border border-gray-100 p-8">
        <h2 class="text-3xl font-extrabold text-gray-900">Create your account</h2>

        {{-- Login / Sign Up pill tabs (only ONCE) --}}
        <div class="mt-4 rounded-full bg-[#E9E0E0] p-1 flex gap-1">
          <a
            href="{{ route('login') }}"
            class="flex-1 text-center block rounded-full py-2 text-sm font-semibold text-gray-700 hover:text-gray-900">
            Sign in
          </a>

          <span class="flex-1 text-center block rounded-full bg-white py-2 text-sm font-semibold text-gray-900 shadow-sm">
            Create account
          </span>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4 mt-6">
          @csrf

          {{-- First + Last name --}}
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-800 mb-1">First Name</label>
              <input
                type="text"
                name="first_name"
                value="{{ old('first_name') }}"
                placeholder="Juan"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/30 focus:border-[#6C1517]"
                required>
              @error('first_name')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-800 mb-1">Last Name</label>
              <input
                type="text"
                name="last_name"
                value="{{ old('last_name') }}"
                placeholder="Dela Cruz"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/30 focus:border-[#6C1517]"
                required>
              @error('last_name')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          {{-- Username --}}
          <div>
            <label class="block text-sm font-semibold text-gray-800 mb-1">Username</label>
            <input
              type="text"
              name="username"
              value="{{ old('username') }}"
              placeholder="juan_dc"
              class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/30 focus:border-[#6C1517]"
              required>
            @error('username')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          {{-- Email --}}
          <div>
            <label class="block text-sm font-semibold text-gray-800 mb-1">Email</label>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="iskolar@pup.edu.ph"
              class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/30 focus:border-[#6C1517]"
              required>
            @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          {{-- Password --}}
          <div>
            <label class="block text-sm font-semibold text-gray-800 mb-1">Password</label>
            <input
              type="password"
              name="password"
              placeholder="••••••••"
              class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/30 focus:border-[#6C1517]"
              required>
            @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          {{-- Confirm Password --}}
          <div>
            <label class="block text-sm font-semibold text-gray-800 mb-1">Confirm Password</label>
            <input
              type="password"
              name="password_confirmation"
              placeholder="••••••••"
              class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/30 focus:border-[#6C1517]"
              required>
          </div>

          {{-- Button --}}
          <button
            type="submit"
            class="w-full mt-2 rounded-xl bg-[#6C1517] py-3 font-semibold text-white hover:opacity-95">
            Create Account
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection