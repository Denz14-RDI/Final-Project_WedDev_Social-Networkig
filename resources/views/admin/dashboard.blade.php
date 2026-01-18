@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
@php
$stats = [
['label'=>'Total Users', 'value'=>'1,247', 'icon'=>'users', 'tone'=>'blue'],
['label'=>'Total Posts', 'value'=>'3,892', 'icon'=>'file', 'tone'=>'green'],
['label'=>'Pending Reports', 'value'=>'3', 'icon'=>'flag', 'tone'=>'amber'],
['label'=>'Banned Users', 'value'=>'2', 'icon'=>'ban', 'tone'=>'red'],
['label'=>'Active Today', 'value'=>'342', 'icon'=>'pulse', 'tone'=>'purple'],
['label'=>'Posts Today', 'value'=>'87', 'icon'=>'trend', 'tone'=>'rose'],
];

$reports = [
[
'handle' => '@suspicioususer123',
'text' => 'This post contains inappropriate content that violates community guidelines and should be reviewed immediately.',
'meta' => 'Reason: Spam or misleading content • Reported by @juandc',
],
[
'handle' => '@scammer2025',
'text' => 'Selling items that seem fraudulent. Contact me at suspicious@email.com for quick cash deals!',
'meta' => 'Reason: Scam or fraud • Reported by @mariasantos',
],
[
'handle' => '@fakeadmin',
'text' => 'OFFICIAL ANNOUNCEMENT: All classes suspended. - PUP Administration (This is a fake post)',
'meta' => 'Reason: Impersonation • Reported by @techclub',
],
];
@endphp

<div class="max-w-6xl">
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Overview of PUPCOM platform activity</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
        @foreach($stats as $s)
        <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-5">
            <div class="h-10 w-10 rounded-full bg-black/5 flex items-center justify-center mb-3">
                {{-- simple icons --}}
                @if($s['icon']==='users')
                <svg class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                @elseif($s['icon']==='file')
                <svg class="h-5 w-5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <path d="M14 2v6h6" />
                </svg>
                @elseif($s['icon']==='flag')
                <svg class="h-5 w-5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 22V4" />
                    <path d="M4 4h10l-1 4 4 2-2 4H4" />
                </svg>
                @elseif($s['icon']==='ban')
                <svg class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M7 7l10 10" />
                </svg>
                @elseif($s['icon']==='pulse')
                <svg class="h-5 w-5 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12h4l2-5 4 10 2-5h6" />
                </svg>
                @else
                <svg class="h-5 w-5 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 17l6-6 4 4 7-7" />
                    <path d="M14 7h6v6" />
                </svg>
                @endif
            </div>

            <div class="text-2xl font-extrabold text-gray-900">{{ $s['value'] }}</div>
            <div class="text-xs font-semibold text-gray-500 mt-1">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="mt-6 bg-white border border-black/10 rounded-2xl shadow-sm p-6">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-full bg-amber-50 flex items-center justify-center">
                <svg class="h-5 w-5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 22V4" />
                    <path d="M4 4h10l-1 4 4 2-2 4H4" />
                </svg>
            </div>
            <div>
                <div class="text-lg font-extrabold text-gray-900">Recent Pending Reports</div>
                <div class="text-sm text-gray-500">Reports that need immediate attention</div>
            </div>
        </div>

        <div class="mt-5 space-y-4">
            @foreach($reports as $r)
            <div class="border border-black/10 rounded-2xl p-5">
                <div class="flex items-start gap-4">
                    <div class="h-10 w-10 rounded-full bg-amber-50 flex items-center justify-center">
                        <svg class="h-5 w-5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 22V4" />
                            <path d="M4 4h10l-1 4 4 2-2 4H4" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-extrabold text-gray-900">{{ $r['handle'] }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ $r['text'] }}</div>
                        <div class="text-xs text-gray-500 mt-2">{{ $r['meta'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection