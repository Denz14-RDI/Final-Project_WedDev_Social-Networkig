@extends('layouts.app')
@section('title','Settings')

@section('main_class', 'bg-app-page')

@section('content')
@php
// demo values (replace with Auth::user() later)
$username = 'juandc';

// demo toggle (persist later)
$darkMode = false;
@endphp

<div class="h-screen overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

        {{-- CENTER (scroll) --}}
        <section class="px-4 sm:px-6 lg:px-10 py-8 overflow-y-auto">
            <div class="w-full max-w-[840px] mx-auto space-y-6">

                {{-- Header --}}
                <div>
                    <div class="text-3xl font-extrabold text-app leading-tight">Settings</div>
                    <div class="text-sm text-app-muted">Manage your account and display preferences.</div>
                </div>

                {{-- ACCOUNT --}}
                <section class="bg-app-card rounded-2xl border border-app shadow-[0_10px_18px_rgba(0,0,0,.08)] overflow-hidden">
                    <div class="p-6 border-b border-app">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 text-app-muted">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-extrabold text-app">Account</div>
                                <div class="text-sm text-app-muted">Manage your account settings</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        {{-- Username only --}}
                        <div>
                            <label class="block text-sm font-semibold text-app mb-2">Username</label>
                            <input
                                value="{{ $username }}"
                                disabled
                                class="w-full rounded-xl bg-white px-4 py-3 text-sm text-app ring-1 ring-[var(--border)] outline-none opacity-90" />
                            <p class="mt-2 text-xs text-app-muted">Your username is currently read-only (demo).</p>
                        </div>

                        {{-- Change Password --}}
                        <div class="pt-6 border-t border-app">
                            <div class="text-sm font-semibold text-app">Change Password</div>
                            <div class="text-xs text-app-muted mt-1">Use at least 8 characters for a stronger password.</div>

                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input
                                    type="password"
                                    placeholder="New password"
                                    class="w-full rounded-xl bg-white px-4 py-3 text-sm text-app ring-1 ring-[var(--border)] outline-none focus:ring-2 focus:ring-[#6C1517]" />
                                <input
                                    type="password"
                                    placeholder="Confirm new password"
                                    class="w-full rounded-xl bg-white px-4 py-3 text-sm text-app ring-1 ring-[var(--border)] outline-none focus:ring-2 focus:ring-[#6C1517]" />
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

                {{-- DISPLAY --}}
                <section class="bg-app-card rounded-2xl border border-app shadow-[0_10px_18px_rgba(0,0,0,.08)] overflow-hidden">
                    <div class="p-6 border-b border-app">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 text-app-muted">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 3a9 9 0 1 0 9 9" />
                                    <path d="M21 12a9 9 0 0 0-9-9" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-extrabold text-app">Display</div>
                                <div class="text-sm text-app-muted">Customize how PUPCOM looks</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 flex items-center justify-between gap-6">
                        <div>
                            <div class="font-semibold text-app">Dark Mode</div>
                            <div class="text-sm text-app-muted">Reduce brightness and improve night viewing.</div>
                        </div>

                        {{-- demo toggle (wire later) --}}
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" class="sr-only peer" @if($darkMode) checked @endif>
                            <div class="w-12 h-7 bg-black/10 rounded-full peer-checked:bg-[#6C1517] transition-colors"></div>
                            <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-transform peer-checked:translate-x-5 shadow-sm"></div>
                        </label>
                    </div>
                </section>

            </div>
        </section>

        {{-- RIGHT SIDEBAR --}}
        @include('partials.right-sidebar')

    </div>
</div>
@endsection