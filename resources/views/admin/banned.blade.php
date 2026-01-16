@extends('layouts.admin')
@section('title', 'Banned Users')

@section('content')
@php
$banned = [
['name'=>'Spam Bot','handle'=>'@spambot2024','reason'=>'Automated spam posting','meta'=>'Banned 7 days ago • by @admin','initial'=>'S'],
['name'=>'Anonymous Hater','handle'=>'@hater_account','reason'=>'Repeated harassment and hate speech','meta'=>'Banned 3 days ago • by @admin','initial'=>'A'],
];
@endphp

<div class="max-w-5xl">
    <div class="flex items-start gap-4 mb-6">
        <div class="h-12 w-12 rounded-2xl bg-red-50 flex items-center justify-center">
            <svg class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <path d="M7 7l10 10" />
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Banned Users</h1>
            <p class="text-sm text-gray-500 mt-1">Manage banned user accounts</p>
        </div>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-6">
        <div class="mb-4">
            <div class="text-lg font-extrabold text-gray-900">Banned Accounts</div>
            <div class="text-sm text-gray-500">{{ count($banned) }} users currently banned</div>
        </div>

        <div class="space-y-4">
            @foreach($banned as $b)
            <div class="border border-red-200 bg-red-50/60 rounded-2xl p-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-white border border-red-200 flex items-center justify-center font-extrabold text-red-600">
                            {{ $b['initial'] }}
                        </div>
                        <div class="leading-tight">
                            <div class="font-extrabold text-gray-900">{{ $b['name'] }}</div>
                            <div class="text-sm text-gray-600">{{ $b['handle'] }}</div>
                            <div class="text-sm text-red-600 font-semibold mt-1">{{ $b['reason'] }}</div>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="text-xs text-gray-500 mb-2">{{ $b['meta'] }}</div>
                        <button class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-black/10 bg-white hover:bg-black/5 text-sm font-semibold">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="8.5" cy="7" r="4" />
                                <path d="M20 8v6" />
                                <path d="M23 11h-6" />
                            </svg>
                            Unban
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection