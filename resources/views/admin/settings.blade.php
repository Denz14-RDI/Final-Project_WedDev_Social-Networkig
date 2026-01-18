@extends('layouts.admin')
@section('title', 'Settings')

@section('content')
<div class="max-w-4xl">
    <div class="flex items-start gap-4 mb-6">
        <div class="h-12 w-12 rounded-2xl bg-black/5 flex items-center justify-center">
            <svg class="h-6 w-6 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                <path d="M19.4 15a7.9 7.9 0 0 0 .1-1 7.9 7.9 0 0 0-.1-1l2-1.5-2-3.5-2.3.8a8 8 0 0 0-1.7-1l-.3-2.4H11l-.3 2.4a8 8 0 0 0-1.7 1l-2.3-.8-2 3.5 2 1.5a7.9 7.9 0 0 0-.1 1 7.9 7.9 0 0 0 .1 1l-2 1.5 2 3.5 2.3-.8a8 8 0 0 0 1.7 1l.3 2.4h4l.3-2.4a8 8 0 0 0 1.7-1l2.3.8 2-3.5-2-1.5Z" />
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Admin Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Configure platform settings</p>
        </div>
    </div>

    {{-- Appearance --}}
    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-6 mb-5">
        <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-2xl bg-black/5 flex items-center justify-center">
                <svg class="h-5 w-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="4" />
                    <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="font-extrabold text-gray-900">Appearance</div>
                <div class="text-sm text-gray-500">Customize the admin panel appearance</div>

                <div class="mt-4 inline-flex items-center gap-2 rounded-2xl bg-black/5 p-1">
                    <button class="px-5 py-2 rounded-xl bg-[#6C1517] text-white text-sm font-bold">Light</button>
                    <button class="px-5 py-2 rounded-xl bg-white text-gray-800 text-sm font-bold border border-black/10">Dark</button>
                    <button class="px-5 py-2 rounded-xl bg-white text-gray-800 text-sm font-bold border border-black/10">System</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Notifications --}}
    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-6 mb-5">
        <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-2xl bg-black/5 flex items-center justify-center">
                <svg class="h-5 w-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8a6 6 0 10-12 0c0 7-3 7-3 7h18s-3 0-3-7" />
                    <path d="M13.7 21a2 2 0 01-3.4 0" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="font-extrabold text-gray-900">Notifications</div>
                <div class="text-sm text-gray-500">Configure admin notification preferences</div>

                <div class="mt-4 space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">Email Notifications</div>
                            <div class="text-sm text-gray-500">Receive email alerts for important events</div>
                        </div>
                        <div class="h-6 w-12 rounded-full bg-[#6C1517] relative">
                            <span class="absolute right-1 top-1 h-4 w-4 rounded-full bg-white"></span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">Report Notifications</div>
                            <div class="text-sm text-gray-500">Get notified when new reports are submitted</div>
                        </div>
                        <div class="h-6 w-12 rounded-full bg-[#6C1517] relative">
                            <span class="absolute right-1 top-1 h-4 w-4 rounded-full bg-white"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Security & Moderation --}}
    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-6 mb-5">
        <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-2xl bg-black/5 flex items-center justify-center">
                <svg class="h-5 w-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2l7 4v6c0 5-3 9-7 10-4-1-7-5-7-10V6l7-4z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="font-extrabold text-gray-900">Security &amp; Moderation</div>
                <div class="text-sm text-gray-500">Platform security and content moderation settings</div>

                <div class="mt-4 space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">Auto-Moderation</div>
                            <div class="text-sm text-gray-500">Automatically filter inappropriate content</div>
                        </div>
                        <div class="h-6 w-12 rounded-full bg-black/10 relative">
                            <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white border border-black/10"></span>
                        </div>
                    </div>

                    <div class="h-px bg-black/10"></div>

                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">Require Email Verification</div>
                            <div class="text-sm text-gray-500">Users must verify their email to post</div>
                        </div>
                        <div class="h-6 w-12 rounded-full bg-[#6C1517] relative">
                            <span class="absolute right-1 top-1 h-4 w-4 rounded-full bg-white"></span>
                        </div>
                    </div>

                    <div class="h-px bg-black/10"></div>

                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">Allow Guest Viewing</div>
                            <div class="text-sm text-gray-500">Allow non-logged-in users to view posts</div>
                        </div>
                        <div class="h-6 w-12 rounded-full bg-black/10 relative">
                            <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white border border-black/10"></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Admin Credentials --}}
    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-6 mb-5">
        <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-2xl bg-black/5 flex items-center justify-center">
                <svg class="h-5 w-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 17a5 5 0 1 0-5-5" />
                    <path d="M7 12h10" />
                    <path d="M17 12v8" />
                    <path d="M17 20h4" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="font-extrabold text-gray-900">Admin Credentials</div>
                <div class="text-sm text-gray-500">Update admin login credentials</div>

                <div class="mt-5 space-y-4">
                    <div>
                        <label class="text-sm font-bold text-gray-900">Current Password</label>
                        <input class="mt-2 w-full rounded-xl border border-black/10 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/20 focus:border-[#6C1517]"
                            placeholder="Enter current password" />
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-900">New Password</label>
                        <input class="mt-2 w-full rounded-xl border border-black/10 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/20 focus:border-[#6C1517]"
                            placeholder="Enter new password" />
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-900">Confirm New Password</label>
                        <input class="mt-2 w-full rounded-xl border border-black/10 px-4 py-3 outline-none focus:ring-2 focus:ring-[#6C1517]/20 focus:border-[#6C1517]"
                            placeholder="Confirm new password" />
                    </div>

                    <button class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-[#6C1517] text-white font-bold hover:opacity-95">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 17a5 5 0 1 0-5-5" />
                            <path d="M7 12h10" />
                            <path d="M17 12v8" />
                            <path d="M17 20h4" />
                        </svg>
                        Update Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Danger Zone (simple placeholder) --}}
    <div class="border border-red-200 bg-red-50/60 rounded-2xl p-6">
        <div class="text-red-600 font-extrabold text-lg">Danger Zone</div>
        <div class="text-sm text-gray-600 mt-1">Irreversible platform actions</div>
    </div>
</div>
@endsection