@extends('layouts.guest')
@section('title', 'Admin Sign in')

@section('content')
<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

    <!-- LEFT (same as login/register) -->
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

            <h2 class="text-3xl font-extrabold text-gray-900">Login to PUPCOM as Admin</h2>
            <p class="text-sm text-gray-500 mt-1">Frontend preview mode (no authentication yet)</p>

            <!-- Tabs/Pill -->
            <div class="mt-5 rounded-full bg-black/5 p-1 flex gap-1">
                <div class="flex-1 text-center">
                    <span class="block w-full rounded-full bg-white py-2 text-sm font-semibold text-gray-900 shadow-sm">
                        Admin Login
                    </span>
                </div>

                <a
                    href="{{ route('signin.choice') }}"
                    class="flex-1 text-center block rounded-full py-2 text-sm font-semibold text-gray-700 hover:text-gray-900">
                    Back
                </a>
            </div>

            {{-- FRONTEND-ONLY: just go to dashboard --}}
            <form method="GET" action="{{ route('admin.dashboard') }}" class="mt-6 space-y-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-800">Email or Username</label>
                    <input
                        type="text"
                        placeholder="admin@pup.edu.ph"
                        class="mt-2 w-full rounded-xl border border-black/10 px-4 py-3 outline-none
                        focus:ring-2 focus:ring-[#6C1517]/15 focus:border-[#6C1517]">
                    <p class="mt-1 text-xs text-gray-500">This is a UI-only field for now.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800">Password</label>
                    <input
                        type="password"
                        placeholder="Password"
                        class="mt-2 w-full rounded-xl border border-black/10 px-4 py-3 outline-none
                        focus:ring-2 focus:ring-[#6C1517]/15 focus:border-[#6C1517]">
                    <p class="mt-1 text-xs text-gray-500">This is a UI-only field for now.</p>
                </div>

                <div class="flex items-center gap-2">
                    <input
                        id="remember"
                        type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-[#6C1517] focus:ring-[#6C1517]/30">
                    <label for="remember" class="text-sm text-gray-700">Remember me</label>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-[#6C1517] py-3 font-semibold text-white shadow-sm hover:opacity-95">
                    Continue to Admin Dashboard
                </button>

                <div class="text-xs text-gray-500 text-center">
                    You can access admin pages directly: <span class="font-semibold">/admin/dashboard</span>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection