@extends('layouts.admin')
@section('title', 'All Posts')

@section('content')
@php
$posts = [
['name'=>'PUP Central Student Organization','handle'=>'@pupcso','text'=>'📣 ATTENTION ISKOLAR NG BAYAN! Join us for the PUP Foundation Day 2025 celebration! 🎉 ...','meta'=>'3 likes • 1 comments • about 1 year ago'],
['name'=>'Prof. Maria Santos','handle'=>'@mariasantos','text'=>'📚 ACADEMIC ANNOUNCEMENT Reminder to all CCIS students: The deadline for submitting your thesis proposals has been extended...','meta'=>'3 likes • 0 comments • about 1 year ago'],
['name'=>'Juan Dela Cruz','handle'=>'@juandc','text'=>'🔴 LOST ITEM ALERT 🔴 I lost my black JBL earphones somewhere in the CCIS building (3rd floor) yesterday around 4PM...','meta'=>'1 likes • 1 comments • about 1 year ago'],
['name'=>'Juan Dela Cruz','handle'=>'@juandc','text'=>'Finally done with my web development project! 💻 Spent the whole week building this and I’m so proud of the result...','meta'=>'1 likes • 0 comments • about 1 year ago'],
];
@endphp

<div class="max-w-5xl">
    <div class="flex items-start gap-4 mb-6">
        <div class="h-12 w-12 rounded-2xl bg-emerald-50 flex items-center justify-center">
            <svg class="h-6 w-6 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <path d="M14 2v6h6" />
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">All Posts</h1>
            <p class="text-sm text-gray-500 mt-1">View and manage all platform posts</p>
        </div>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-5 mb-5">
        <div class="flex items-center gap-3 rounded-xl border border-black/10 px-4 py-3">
            <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="7" />
                <path d="M21 21l-4.3-4.3" />
            </svg>
            <input class="w-full outline-none text-sm" placeholder="Search posts by content or author..." />
        </div>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-6">
        <div class="mb-4">
            <div class="text-lg font-extrabold text-gray-900">Posts</div>
            <div class="text-sm text-gray-500">{{ count($posts) }} posts found</div>
        </div>

        <div class="space-y-4">
            @foreach($posts as $p)
            <div class="border border-black/10 rounded-2xl p-5">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="h-12 w-12 rounded-full bg-black/5 border border-black/10 flex items-center justify-center font-extrabold text-gray-700">
                            {{ strtoupper(mb_substr($p['name'],0,1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="font-extrabold text-gray-900">{{ $p['name'] }}</div>
                                <div class="text-sm text-gray-500">{{ $p['handle'] }}</div>
                            </div>
                            <div class="text-sm text-gray-700 mt-2">{{ $p['text'] }}</div>
                            <div class="text-xs text-gray-500 mt-3">{{ $p['meta'] }}</div>
                        </div>
                    </div>

                    <button class="h-10 w-10 rounded-xl hover:bg-black/5 flex items-center justify-center text-gray-600">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="5" r="1.8" />
                            <circle cx="12" cy="12" r="1.8" />
                            <circle cx="12" cy="19" r="1.8" />
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection