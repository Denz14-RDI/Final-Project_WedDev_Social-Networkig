{{-- 
Admin Login View
This page allows administrators to sign in
and access the admin dashboard securely.
--}}

@extends('layouts.guest')
@section('title', 'Admin Login')

@section('content')
<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

    {{-- LEFT SIDE (Branding / Image Section) --}}
    {{-- Displays background image and logo for larger screens --}}
    <div
        class="hidden md:flex items-center justify-center relative overflow-hidden"
        style="background-image: url('/images/pupbg.png'); background-size: cover; background-position: center;">
        
        {{-- Gradient overlay for visual effect --}}
        <div class="absolute inset-0 bg-gradient-to-tr from-[#F59E0B]/50 via-[#EF4444]/35 to-[#6C1517]/55"></div>
        <div class="absolute inset-0 bg-black/10"></div>

        {{-- PUPCOM logo --}}
        <img
            src="{{ asset('images/logo.png') }}"
            alt="PUPCOM Logo"
            class="relative z-10 w-60 sm:w-72 lg:w-80 xl:w-96 max-w-[380px] h-auto opacity-95 select-none
            drop-shadow-[0_18px_35px_rgba(0,0,0,.35)]">
    </div>

    {{-- RIGHT SIDE (Login Form Section) --}}
    <div class="flex items-center justify-center bg-[#F2EADA] px-6 py-12">
        <div class="w-full max-w-md bg-white rounded-2xl border border-black/10 shadow-[0_18px_40px_rgba(0,0,0,.10)] p-8">

            {{-- Page title and description --}}
            <h2 class="text-3xl font-extrabold text-black">Admin Login</h2>
            <p class="text-sm text-black mt-1">Sign in to access the admin dashboard</p>

            {{-- Navigation Tabs --}}
            <div class="mt-5 rounded-full bg-[#E9E0E0] p-1 flex gap-1">
                <div class="flex-1 text-center">
                    <span class="block w-full rounded-full bg-white py-2 text-sm font-semibold text-black shadow-sm">
                        Login
                    </span>
                </div>

                {{-- Back button to sign-in choice --}}
                <a
                    href="{{ route('signin.choice') }}"
                    class="flex-1 text-center block rounded-full py-2 text-sm font-semibold text-black hover:text-black">
                    Back
                </a>
            </div>

            {{-- Flash success message --}}
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Validation error messages --}}
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Flash error message --}}
            @if (session('error'))
                <div class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Admin login form --}}
            <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-6 space-y-5">
                @csrf

                {{-- Email input --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-black">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        placeholder="admin only"
                        required
                        class="mt-2 w-full rounded-xl border border-black/10 px-4 py-3 text-black outline-none
                        focus:ring-2 focus:ring-[#6C1517]/15 focus:border-[#6C1517]">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password input --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-black">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="••••••••"
                        required
                        class="mt-2 w-full rounded-xl border border-black/10 px-4 py-3 text-black outline-none
                        focus:ring-2 focus:ring-[#6C1517]/15 focus:border-[#6C1517]">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit button --}}
                <button
                    type="submit"
                    class="w-full rounded-xl bg-[#6C1517] py-3 font-semibold text-white shadow-sm hover:opacity-95 transition">
                    Sign in
                </button>
            </form>

        </div>
    </div>

</div>
@endsection