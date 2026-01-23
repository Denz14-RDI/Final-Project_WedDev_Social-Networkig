@extends('layouts.guest')
@section('title', 'Admin Sign in')

@section('content')
<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

    <!-- LEFT -->
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

    <!-- RIGHT -->
    <div class="flex items-center justify-center bg-[#F6F6F6] px-6 py-12">
        <div class="w-full max-w-md bg-white rounded-2xl border border-black/10 shadow-[0_18px_40px_rgba(0,0,0,.10)] p-8">

            <h2 class="text-3xl font-extrabold text-black">Admin Login</h2>
            <p class="text-sm text-black mt-1">Sign in to access the admin dashboard</p>

            <!-- Tabs -->
            <div class="mt-5 rounded-full bg-black/5 p-1 flex gap-1">
                <div class="flex-1 text-center">
                    <span class="block w-full rounded-full bg-white py-2 text-sm font-semibold text-black shadow-sm">
                        Admin Login
                    </span>
                </div>

                <a
                    href="{{ route('signin.choice') }}"
                    class="flex-1 text-center block rounded-full py-2 text-sm font-semibold text-black hover:text-black">
                    Back
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

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-6 space-y-5">
                @csrf

                <!-- Email -->
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

                <!-- Password -->
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

                <!-- Remember Me -->
                <div class="flex items-center gap-2">
                    <input
                        id="remember"
                        name="remember"
                        type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-[#6C1517] focus:ring-[#6C1517]/30">
                    <label for="remember" class="text-sm text-black">Remember me</label>
                </div>

                <!-- Submit -->
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
