@extends('layouts.app')
@section('title','Settings')

@section('main_class', 'bg-[#F2EADA]')

@section('content')
@php
// demo values (replace with Auth::user() later)
$email = 'juan.delacruz@pup.edu.ph';
$username = 'juandc';
@endphp

<div class="h-screen overflow-hidden bg-[#F2EADA]">
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

        {{-- CENTER (scroll) --}}
        <main class="h-full overflow-y-auto">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <div class="max-w-4xl mx-auto space-y-6">

                    {{-- Page Header --}}
                    <div>
                        <h1 class="text-3xl font-extrabold tracking-tight text-neutral-900">Settings</h1>
                        <p class="mt-1 text-sm text-neutral-500">
                            Manage your account, notifications, and privacy preferences.
                        </p>
                    </div>

                    {{-- Account --}}
                    <section class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200">
                        <div class="p-6 border-b border-neutral-200">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 text-neutral-700">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-lg font-extrabold text-neutral-900">Account</div>
                                    <div class="text-sm text-neutral-500">Manage your account settings</div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-6">
                            {{-- Email + Username --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-neutral-800 mb-2">Email</label>
                                    <input
                                        value="{{ $email }}"
                                        disabled
                                        class="w-full rounded-xl bg-neutral-50 px-4 py-3 text-sm text-neutral-600 ring-1 ring-neutral-200 outline-none" />
                                    <p class="mt-2 text-xs text-neutral-500">Contact support to change your email</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-neutral-800 mb-2">Username</label>
                                    <input
                                        value="{{ $username }}"
                                        disabled
                                        class="w-full rounded-xl bg-neutral-50 px-4 py-3 text-sm text-neutral-600 ring-1 ring-neutral-200 outline-none" />
                                </div>
                            </div>

                            {{-- Change Password --}}
                            <div class="pt-6 border-t border-neutral-200">
                                <div class="text-sm font-semibold text-neutral-900">Change Password</div>
                                <div class="text-xs text-neutral-500 mt-1">Use at least 8 characters for a stronger password.</div>

                                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input
                                        type="password"
                                        placeholder="New password"
                                        class="w-full rounded-xl bg-white px-4 py-3 text-sm ring-1 ring-neutral-200 outline-none focus:ring-2 focus:ring-[#6C1517]" />
                                    <input
                                        type="password"
                                        placeholder="Confirm new password"
                                        class="w-full rounded-xl bg-white px-4 py-3 text-sm ring-1 ring-neutral-200 outline-none focus:ring-2 focus:ring-[#6C1517]" />
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <button
                                        type="button"
                                        class="w-full md:w-auto inline-flex items-center justify-center rounded-xl bg-[#6C1517] px-5 py-3 text-sm font-semibold text-white hover:opacity-95 active:opacity-90">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Notifications --}}
                    <section class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200">
                        <div class="p-6 border-b border-neutral-200">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 text-neutral-700">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 8a6 6 0 10-12 0c0 7-3 7-3 7h18s-3 0-3-7" />
                                        <path d="M13.7 21a2 2 0 01-3.4 0" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-lg font-extrabold text-neutral-900">Notifications</div>
                                    <div class="text-sm text-neutral-500">Configure how you receive notifications</div>
                                </div>
                            </div>
                        </div>

                        <div class="divide-y divide-neutral-200">
                            <div class="p-6 flex items-center justify-between gap-6">
                                <div>
                                    <div class="font-semibold text-neutral-900">Email Notifications</div>
                                    <div class="text-sm text-neutral-500">Receive notifications via email</div>
                                </div>

                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-12 h-7 bg-neutral-200 rounded-full peer-checked:bg-[#6C1517] transition-colors"></div>
                                    <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-transform peer-checked:translate-x-5 shadow-sm"></div>
                                </label>
                            </div>

                            <div class="p-6 flex items-center justify-between gap-6">
                                <div>
                                    <div class="font-semibold text-neutral-900">Push Notifications</div>
                                    <div class="text-sm text-neutral-500">Receive push notifications</div>
                                </div>

                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-12 h-7 bg-neutral-200 rounded-full peer-checked:bg-[#6C1517] transition-colors"></div>
                                    <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-transform peer-checked:translate-x-5 shadow-sm"></div>
                                </label>
                            </div>
                        </div>
                    </section>

                    {{-- Privacy --}}
                    <section class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200">
                        <div class="p-6 border-b border-neutral-200">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 text-neutral-700">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-lg font-extrabold text-neutral-900">Privacy</div>
                                    <div class="text-sm text-neutral-500">Control your privacy settings</div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 flex items-center justify-between gap-6">
                            <div>
                                <div class="font-semibold text-neutral-900">Private Profile</div>
                                <div class="text-sm text-neutral-500">Only followers can see your posts</div>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer select-none">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-12 h-7 bg-neutral-200 rounded-full peer-checked:bg-[#6C1517] transition-colors"></div>
                                <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-transform peer-checked:translate-x-5 shadow-sm"></div>
                            </label>
                        </div>
                    </section>

                    {{-- Danger Zone --}}
                    <section class="bg-white rounded-2xl shadow-sm ring-1 ring-red-300">
                        <div class="p-6 border-b border-red-200">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 text-red-600">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-lg font-extrabold text-red-600">Danger Zone</div>
                                    <div class="text-sm text-neutral-500">Irreversible actions</div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-5">
                            <div class="flex items-center justify-between gap-6">
                                <div>
                                    <div class="font-semibold text-neutral-900">Log Out</div>
                                    <div class="text-sm text-neutral-500">Sign out of your account</div>
                                </div>

                                <button type="button"
                                    class="w-full md:w-auto rounded-xl border border-neutral-200 px-5 py-2 font-semibold hover:bg-neutral-50">
                                    Log Out
                                </button>
                            </div>

                            <div class="pt-5 border-t border-neutral-200 flex items-center justify-between gap-6">
                                <div>
                                    <div class="font-semibold text-red-600">Delete Account</div>
                                    <div class="text-sm text-neutral-500">Permanently delete your account and data</div>
                                </div>

                                <button type="button"
                                    class="w-full md:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2 font-semibold text-white hover:bg-red-700">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4h8v2" />
                                        <path d="M19 6l-1 14H6L5 6" />
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </main>

        {{-- RIGHT SIDEBAR (UNIFIED PARTIAL) --}}
        @include('partials.right-sidebar')

    </div>
</div>
@endsection