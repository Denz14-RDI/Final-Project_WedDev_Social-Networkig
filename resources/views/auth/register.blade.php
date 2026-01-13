@extends('layouts.guest')
@section('title', 'Create your account')

@section('content')
<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

  <!-- LEFT (PUP background image panel) -->
  <div
    class="hidden md:flex relative items-center justify-center overflow-hidden"
    style="
      background-image: url('{{ asset('images/pupbg.png') }}');
      background-size: cover;
      background-position: center;
    ">
    {{-- warm overlay like login --}}
    <div class="absolute inset-0 bg-gradient-to-tr from-[#F59E0B]/50 via-[#EF4444]/35 to-[#6C1517]/55"></div>
    <div class="absolute inset-0 bg-black/10"></div>

    {{-- Logo --}}
    <img
      src="{{ asset('images/logo.png') }}"
      alt="PUPCOM Logo"
      class="relative z-10 w-[1000px] h-auto opacity-95 select-none drop-shadow-[0_20px_40px_rgba(0,0,0,.25)]">
  </div>

  <!-- RIGHT (beige background + register card) -->
  <div class="flex items-center justify-center bg-[#F2EADA] px-6 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

      <h2 class="text-3xl font-extrabold text-gray-900">Create your account</h2>

      {{-- Tabs/Pill --}}
      <div class="mt-5 rounded-full bg-[#E9E0E0] p-1 flex gap-1">
        <a
          href="{{ route('login') }}"
          class="flex-1 text-center block rounded-full py-2 text-sm font-semibold text-gray-700 hover:text-gray-900">
          Sign in
        </a>

        <div class="flex-1 text-center">
          <span class="block w-full rounded-full bg-white py-2 text-sm font-semibold text-gray-900 shadow-sm">
            Create account
          </span>
        </div>
      </div>

      <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
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
              class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/25 focus:border-[#6C1517]"
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
              class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/25 focus:border-[#6C1517]"
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
            class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/25 focus:border-[#6C1517]"
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
            class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/25 focus:border-[#6C1517]"
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
            class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/25 focus:border-[#6C1517]"
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
            class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/25 focus:border-[#6C1517]"
            required>
        </div>

        {{-- Role --}}
        <div>
          <label class="block text-sm font-semibold text-gray-800 mb-1">Role</label>
          <select
            name="role"
            class="w-full rounded-xl border border-gray-200 px-4 py-3 bg-white outline-none focus:ring-2 focus:ring-[#6C1517]/25 focus:border-[#6C1517]"
            required>
            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select role...</option>
            <option value="User" {{ old('role') === 'User' ? 'selected' : '' }}>User</option>
            <option value="Admin" {{ old('role') === 'Admin' ? 'selected' : '' }}>Admin</option>
          </select>
          @error('role')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Button --}}
        <button
          type="submit"
          class="w-full mt-2 rounded-xl bg-[#6C1517] py-3 font-semibold text-white shadow-sm hover:opacity-95">
          Create Account
        </button>
      </form>
    </div>
  </div>

</div>
@endsection