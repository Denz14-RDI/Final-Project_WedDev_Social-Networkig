{{--
Admin Settings View
Allows administrators to customize display preferences
and securely update their account password.
--}}

@extends('layouts.admin')
@section('title', 'Settings')

@section('content')
<div class="w-full max-w-[840px] mx-auto space-y-6">

    {{-- Page Header --}}
    <div>
        <div class="text-3xl font-extrabold text-app leading-tight">Admin Settings</div>
        <div class="text-sm text-app-muted">Configure platform settings.</div>
    </div>

    {{-- DISPLAY SETTINGS SECTION --}}
    {{-- Allows admin to toggle visual preferences like dark mode --}}
    <section class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">
        <div class="p-6 border-b border-app">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 text-app-muted text-xl">🎨</div>
                <div>
                    <div class="text-lg font-extrabold text-app">Display</div>
                    <div class="text-sm text-app-muted">Customize how the admin panel looks</div>
                </div>
            </div>
        </div>

        {{-- Clickable row for dark mode toggle --}}
        <button
            id="adminThemeRow"
            type="button"
            class="w-full p-6 text-left flex items-center justify-between gap-6 hover-app transition">
            <div class="min-w-0">
                <div class="font-semibold text-app">Dark Mode</div>
                <div class="text-sm text-app-muted">Black/gray theme for night viewing.</div>
            </div>

            {{-- Toggle switch UI --}}
            <div class="relative inline-flex items-center select-none">
                <input id="adminThemeToggle" type="checkbox" class="sr-only">
                <div id="adminThemeTrack" class="theme-track"></div>
                <div id="adminThemeKnob" class="theme-knob"></div>
            </div>
        </button>
    </section>

    {{-- ADMIN CREDENTIALS --}}
    {{-- Allows admin to update account password securely --}}
    <section class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">
        <div class="p-6 border-b border-app">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 text-app-muted text-xl">🔐</div>
                <div>
                    <div class="text-lg font-extrabold text-app">Admin Credentials</div>
                    <div class="text-sm text-app-muted">Update your login password securely</div>
                </div>
            </div>
        </div>

        {{-- Password update form --}}
        <form method="POST" action="{{ route('admin.updatePassword') }}" class="p-6 space-y-6">
            @csrf

            {{-- Current password input --}}
            <div>
                <label class="block text-sm font-semibold text-app mb-2">Current Password</label>
                <input
                    type="password"
                    name="current_password"
                    placeholder="Current password"
                    class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]"
                    required>
                @error('current_password')
                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- New password and confirmation --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-app mb-2">New Password</label>
                    <input
                        type="password"
                        name="new_password"
                        placeholder="New password"
                        class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]"
                        required>
                    @error('new_password')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-app mb-2">Confirm New Password</label>
                    <input
                        type="password"
                        name="new_password_confirmation"
                        placeholder="Confirm new password"
                        class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]"
                        required>
                    @error('new_password_confirmation')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Submit button --}}
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="w-full md:w-auto inline-flex items-center justify-center rounded-xl btn-brand px-5 py-3 text-sm font-semibold hover:opacity-95 active:opacity-90">
                    Update Password
                </button>
            </div>
        </form>
    </section>

</div>

{{-- Script that handles admin dark mode toggle --}}
{{-- Uses the same theme logic as user settings --}}
<script>
    (function() {
        const row = document.getElementById('adminThemeRow');
        const toggle = document.getElementById('adminThemeToggle');
        const track = document.getElementById('adminThemeTrack');
        const knob = document.getElementById('adminThemeKnob');

        // Checks if dark mode is currently enabled
        function isDark() {
            return document.documentElement.classList.contains('dark');
        }

        // Updates the toggle UI based on current theme
        function paint() {
            const dark = isDark();
            toggle.checked = dark;
            track.classList.toggle('on', dark);
            knob.classList.toggle('on', dark);
        }

        // Switches between light and dark theme
        function flip() {
            // relies on window.setTheme from your app.js (same as user settings)
            window.setTheme(isDark() ? 'light' : 'dark');
            paint();
        }

        row.addEventListener('click', flip);
        toggle.addEventListener('click', (e) => e.stopPropagation());
        toggle.addEventListener('change', flip);

        paint();
    })();
</script>
@endsection