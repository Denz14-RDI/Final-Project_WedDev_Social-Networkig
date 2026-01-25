{{-- 
Sign-in Choice View
Allows users to choose between Community Member login
or Administrator login.
--}}

@extends('layouts.guest')
@section('title', 'Sign in')

@section('content')
<div class="min-h-screen grid grid-cols-1 md:grid-cols-2">

    {{-- LEFT SIDE: Branding image and logo (same as login/register) --}}
    {{-- Visible only on medium and larger screens --}}
    <div
        class="hidden md:flex items-center justify-center relative overflow-hidden"
        style="background-image: url('/images/pupbg.png'); background-size: cover; background-position: center;">
        
        {{-- Gradient overlays for visual styling --}}
        <div class="absolute inset-0 bg-gradient-to-tr from-[#F59E0B]/50 via-[#EF4444]/35 to-[#6C1517]/55"></div>
        <div class="absolute inset-0 bg-black/10"></div>

        {{-- PUPCOM logo --}}
        <img
            src="{{ asset('images/logo.png') }}"
            alt="PUPCOM Logo"
            class="relative z-10 w-60 sm:w-72 lg:w-80 xl:w-96 max-w-[380px] h-auto opacity-95 select-none
        drop-shadow-[0_18px_35px_rgba(0,0,0,.35)]">
    </div>

    {{-- RIGHT SIDE: Sign-in options --}}
    <div class="flex items-center justify-center bg-[#F2EADA] px-6 py-12">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8 border border-black/5">

            {{-- Page title --}}
            <h2 class="text-3xl font-extrabold text-gray-900">Sign in</h2>
            <p class="mt-2 text-sm text-gray-600">Choose how you want to sign in</p>

            {{-- Sign-in role options --}}
            <div class="mt-6 space-y-4">

                {{-- Community Member login option --}}
                <a href="{{ route('login') }}"
                    class="block rounded-2xl border border-gray-200 p-5 hover:border-[#6C1517]/30 hover:shadow-md transition">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-[#F5D27A] flex items-center justify-center overflow-hidden">
                            <img
                                src="{{ asset('images/roles/community_member_logo.png') }}"
                                alt="Community Member"
                                class="h-10 w-10 object-contain select-none"
                                loading="lazy">
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Community Member</div>
                            <div class="text-sm text-gray-600">Access the community feed and features</div>
                        </div>
                    </div>
                </a>

                {{-- Administrator login option --}}
                <a href="{{ route('admin.login') }}"
                    class="block rounded-2xl border border-gray-200 p-5 hover:border-[#6C1517]/30 hover:shadow-md transition">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-[#6C1517] flex items-center justify-center overflow-hidden">
                            <img
                                src="{{ asset('images/roles/administrator_logo.png') }}"
                                alt="Administrator"
                                class="h-10 w-10 object-contain select-none"
                                loading="lazy">
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Administrator</div>
                            <div class="text-sm text-gray-600">Access the admin dashboard</div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Registration link --}}
            <p class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-[#6C1517] hover:underline">Sign up</a>
            </p>

        </div>
    </div>

</div>
@endsection