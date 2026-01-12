@extends('layouts.guest')
@section('title', 'Register')

@section('content')
<div class="min-h-screen bg-[#F2EADA] flex">
  {{-- Left panel --}}
  <div class="hidden lg:flex lg:w-1/2 bg-[#6C1517] text-white relative">
    <div class="w-full flex flex-col justify-center px-16">
      <h1 class="text-4xl font-bold mb-3">Create your account</h1>
      <p class="text-white/80">Join the PUP community feed.</p>
    </div>
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
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Register</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
          @csrf

          {{-- Name --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input
              type="text"
              name="name"
              value="{{ old('name') }}"
              class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#6C1517]/40 focus:border-[#6C1517]"
              placeholder="Juan Dela Cruz"
              required
            >
            @error('name')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Email --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
              type="email"
              name="email"
              value="{{ old('email') }}"
              class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#6C1517]/40 focus:border-[#6C1517]"
              placeholder="iskolar@pup.edu.ph"
              required
            >
            @error('email')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Password --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
              type="password"
              name="password"
              class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#6C1517]/40 focus:border-[#6C1517]"
              placeholder="••••••••"
              required
            >
            @error('password')
              <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Confirm Password (Laravel usually expects this) --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input
              type="password"
              name="password_confirmation"
              class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#6C1517]/40 focus:border-[#6C1517]"
              placeholder="••••••••"
              required
            >
          </div>

          <button
            type="submit"
            class="w-full mt-2 bg-[#6C1517] text-white font-semibold py-3 rounded-lg hover:bg-[#5a1113] transition"
          >
            Create account
          </button>

          <p class="text-center text-sm text-gray-500 mt-4">
            Already have an account?
            <a href="{{ route('login') }}" class="text-[#6C1517] font-semibold hover:underline">Sign in</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
