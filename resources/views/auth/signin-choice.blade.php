@extends('layouts.guest')
@section('title', 'Sign in')

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
    <div class="flex items-center justify-center bg-[#F2EADA] px-6 py-12">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8 border border-black/5">

            <h2 class="text-3xl font-extrabold text-gray-900">Sign in</h2>
            <p class="mt-2 text-sm text-gray-600">Choose how you want to sign in</p>

            <div class="mt-6 space-y-4">
                <!-- Community Member -->
                <a href="{{ route('login') }}"
                    class="block rounded-2xl border border-gray-200 p-5 hover:border-[#6C1517]/30 hover:shadow-md transition">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-[#F5D27A] flex items-center justify-center text-[#6C1517] font-bold">
                            CM
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Community Member</div>
                            <div class="text-sm text-gray-600">Access the community feed and features</div>
                        </div>
                    </div>
                </a>

                <!-- Administrator -->
                <a href="{{ route('admin.login') }}"
                    class="block rounded-2xl border border-gray-200 p-5 hover:border-[#6C1517]/30 hover:shadow-md transition">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-[#6C1517] flex items-center justify-center text-white font-bold">
                            AD
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Administrator</div>
                            <div class="text-sm text-gray-600">Access the admin dashboard</div>
                        </div>
                    </div>
                </a>
            </div>

            <p class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-[#6C1517] hover:underline">Sign up</a>
            </p>

        </div>
    </div>

</div>
@endsection