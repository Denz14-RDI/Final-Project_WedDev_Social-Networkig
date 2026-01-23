@extends('layouts.admin')
@section('title', 'Settings')

@section('content')
<div class="max-w-4xl">
    {{-- Header --}}
    <div class="flex items-start gap-4 mb-6">
        <div class="h-12 w-12 rounded-2xl bg-black/5 flex items-center justify-center text-2xl">⚙️</div>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Admin Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Configure platform settings</p>
        </div>
    </div>

    {{-- Display Settings --}}
    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-6 mb-5">
        <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-2xl bg-black/5 flex items-center justify-center text-xl">🖥️</div>
            <div class="flex-1">
                <div class="font-extrabold text-gray-900">Display</div>
                <div class="text-sm text-gray-500">Choose your preferred admin panel theme</div>

                <div class="mt-4 flex items-center gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="theme" value="light" class="hidden peer">
                        <span class="peer-checked:bg-[#6C1517] peer-checked:text-white px-4 py-2 rounded-xl bg-black/5 text-sm font-bold">🌞 Light</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="theme" value="dark" class="hidden peer">
                        <span class="peer-checked:bg-[#6C1517] peer-checked:text-white px-4 py-2 rounded-xl bg-black/5 text-sm font-bold">🌙 Dark</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="theme" value="system" class="hidden peer">
                        <span class="peer-checked:bg-[#6C1517] peer-checked:text-white px-4 py-2 rounded-xl bg-black/5 text-sm font-bold">🖥️ System</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    {{-- Admin Credentials --}}
    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-6 mb-5">
        <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-2xl bg-black/5 flex items-center justify-center text-xl">🔐</div>
            <div class="flex-1">
                <div class="font-extrabold text-gray-900">Admin Credentials</div>
                <div class="text-sm text-gray-500">Update your login password securely</div>

                <form method="POST" action="{{ route('admin.updatePassword') }}" class="mt-5 space-y-4">
                    @csrf

                    <div>
                        <label class="text-sm font-bold text-gray-900">Current Password</label>
                        <input type="password" name="current_password"
                            class="mt-2 w-full rounded-xl border border-black/10 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/20 focus:border-[#6C1517]"
                            placeholder="Enter current password" required>
                        @error('current_password')
                            <div class="text-sm text-red-600 mt-1">❌ {{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-900">New Password</label>
                        <input type="password" name="new_password"
                            class="mt-2 w-full rounded-xl border border-black/10 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/20 focus:border-[#6C1517]"
                            placeholder="Enter new password" required>
                        @error('new_password')
                            <div class="text-sm text-red-600 mt-1">❌ {{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-900">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation"
                            class="mt-2 w-full rounded-xl border border-black/10 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/20 focus:border-[#6C1517]"
                            placeholder="Confirm new password" required>
                        @error('new_password_confirmation')
                            <div class="text-sm text-red-600 mt-1">❌ {{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-[#6C1517] text-white font-bold hover:opacity-95">
                        🔒 Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection