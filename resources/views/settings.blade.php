{{-- Settings View
Allows users to manage account information, change passwords, and toggle display preferences --}}

@extends('layouts.app')
@section('title','Settings')

@section('main_class', 'bg-app-page')

@section('content')

{{-- Logged-in user --}}
@php
    $user = Auth::user(); 
@endphp

<div class="h-screen overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

        {{-- CENTER SECTION (scrollable settings content) --}}
        <section class="px-4 sm:px-6 lg:px-10 py-8 overflow-y-auto">
            <div class="w-full max-w-[840px] mx-auto space-y-6">

                {{-- Page header --}}
                <div>
                    <div class="text-3xl font-extrabold text-app leading-tight">Settings</div>
                    <div class="text-sm text-app-muted">Manage your account and display preferences.</div>
                </div>

                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Validation error messages --}}
                @if($errors->any())
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-xl">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Account Settings --}}
                <section class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">
                    <div class="p-6 border-b border-app">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 text-app-muted text-xl">👤</div>
                            <div>
                                <div class="text-lg font-extrabold text-app">Account</div>
                                <div class="text-sm text-app-muted">Manage your account settings</div>
                            </div>
                        </div>
                    </div>

                    {{-- Account update form --}}
                    <form action="{{ route('profile.update', $user->user_id) }}" method="POST" class="p-6 space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Identify update source as settings page --}}
                        <input type="hidden" name="source" value="settings">

                        {{-- Username field --}}
                        <div>
                            <label class="block text-sm font-semibold text-app mb-2">Username</label>
                            <input
                                type="text"
                                name="username"
                                value="{{ old('username', $user->username) }}"
                                class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
                            @error('username')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Change password section --}}
                        <div class="pt-6 border-t border-app">
                            <div class="text-sm font-semibold text-app">Change Password</div>
                            <div class="text-xs text-app-muted mt-1">Enter your current password and a new one.</div>

                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Current password --}}
                                <div>
                                    <input
                                        type="password"
                                        name="current_password"
                                        placeholder="Current password"
                                        class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
                                    @error('current_password')
                                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- New password --}}
                                <div>
                                    <input
                                        type="password"
                                        name="password"
                                        placeholder="New password"
                                        class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
                                    @error('password')
                                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Confirm new password --}}
                            <div class="mt-4">
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Confirm new password"
                                    class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
                                @error('password_confirmation')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit account updates --}}
                        <div class="mt-4 flex justify-end">
                            <button
                                type="submit"
                                class="w-full md:w-auto inline-flex items-center justify-center rounded-xl btn-brand px-5 py-3 text-sm font-semibold hover:opacity-95 active:opacity-90">
                                Update Account
                            </button>
                        </div>
                    </form>
                </section>

                {{-- DISPLAY SETTINGS --}}
                <section class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">
                    <div class="p-6 border-b border-app">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 text-app-muted text-xl">🎨</div>
                            <div>
                                <div class="text-lg font-extrabold text-app">Display</div>
                                <div class="text-sm text-app-muted">Customize how PUPCOM looks</div>
                            </div>
                        </div>
                    </div>

                    {{-- Dark mode toggle row --}}
                    <button
                        id="themeRow"
                        type="button"
                        class="w-full p-6 text-left flex items-center justify-between gap-6 hover-app transition">
                        <div class="min-w-0">
                            <div class="font-semibold text-app">Dark Mode</div>
                            <div class="text-sm text-app-muted">Black/gray theme for night viewing.</div>
                        </div>

                        {{-- Dark mode switch --}}
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

{{-- Dark mode toggle logic --}}
<script>
    (function() {
        const row = document.getElementById('themeRow');
        const toggle = document.getElementById('themeToggle');
        const track = document.getElementById('themeTrack');
        const knob = document.getElementById('themeKnob');

        // Checks if dark mode is currently enabled
        function isDark() {
            return document.documentElement.classList.contains('dark');
        }

        // Updates toggle UI based on theme state
        function paint() {
            const dark = isDark();
            toggle.checked = dark;
            track.classList.toggle('on', dark);
            knob.classList.toggle('on', dark);
        }
        // Switches between light and dark mode
        function flip() {
            window.setTheme(isDark() ? 'light' : 'dark');
            paint();
        }

        // Event listeners
        row.addEventListener('click', flip);
        toggle.addEventListener('click', (e) => e.stopPropagation());
        toggle.addEventListener('change', flip);

        // Initialize toggle state
        paint();
    })();
</script>
@endsection