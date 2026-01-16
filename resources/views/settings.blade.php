@extends('layouts.app')
@section('title','Settings')

@section('main_class', 'bg-app-page')

@section('content')
@php
$username = 'juandc';
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
                <section class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">
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
                        <div>
                            <label class="block text-sm font-semibold text-app mb-2">Username</label>
                            <input
                                value="{{ $username }}"
                                disabled
                                class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none opacity-90" />
                            <p class="mt-2 text-xs text-app-muted">Your username is currently read-only (demo).</p>
                        </div>

                        <div class="pt-6 border-t border-app">
                            <div class="text-sm font-semibold text-app">Change Password</div>
                            <div class="text-xs text-app-muted mt-1">Use at least 8 characters for a stronger password.</div>

                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input
                                    type="password"
                                    placeholder="New password"
                                    class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
                                <input
                                    type="password"
                                    placeholder="Confirm new password"
                                    class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
                            </div>

                            <div class="mt-4 flex justify-end">
                                <button
                                    type="button"
                                    class="w-full md:w-auto inline-flex items-center justify-center rounded-xl btn-brand px-5 py-3 text-sm font-semibold hover:opacity-95 active:opacity-90">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- DISPLAY --}}
                <section class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">
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

                    {{-- clickable row (ChatGPT-ish) --}}
                    <button
                        id="themeRow"
                        type="button"
                        class="w-full p-6 text-left flex items-center justify-between gap-6 hover-app transition">
                        <div class="min-w-0">
                            <div class="font-semibold text-app">Dark Mode</div>
                            <div class="text-sm text-app-muted">Black/gray theme for night viewing.</div>
                        </div>

                        {{-- switch --}}
                        <div class="relative inline-flex items-center select-none">
                            <input id="themeToggle" type="checkbox" class="sr-only">
                            <div id="themeTrack" class="theme-track"></div>
                            <div id="themeKnob" class="theme-knob"></div>
                        </div>
                    </button>
                </section>

            </div>
        </section>

        {{-- RIGHT SIDEBAR --}}
        @include('partials.right-sidebar')

    </div>
</div>

<script>
    (function() {
        const row = document.getElementById('themeRow');
        const toggle = document.getElementById('themeToggle');
        const track = document.getElementById('themeTrack');
        const knob = document.getElementById('themeKnob');

        function isDark() {
            return document.documentElement.classList.contains('dark');
        }

        function paint() {
            const dark = isDark();
            toggle.checked = dark;
            track.classList.toggle('on', dark);
            knob.classList.toggle('on', dark);
        }

        function flip() {
            window.setTheme(isDark() ? 'light' : 'dark');
            paint();
        }

        // whole row clickable
        row.addEventListener('click', flip);

        // checkbox doesn't double-trigger row
        toggle.addEventListener('click', (e) => e.stopPropagation());
        toggle.addEventListener('change', flip);

        paint();
    })();
</script>
@endsection