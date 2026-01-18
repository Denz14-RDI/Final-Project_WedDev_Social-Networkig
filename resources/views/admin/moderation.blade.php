@extends('layouts.admin')
@section('title', 'Content Moderation')

@section('content')
@php
$tab = request('tab', 'pending');

$data = [
'pending' => [
['handle'=>'@suspicioususer123','tag'=>'Pending','tagClass'=>'bg-amber-100 text-amber-700 border-amber-200','text'=>'This post contains inappropriate content that violates community guidelines and should be reviewed immediately.','meta'=>'Spam or misleading content • Reported by @juandc • about 2 hours ago'],
['handle'=>'@scammer2025','tag'=>'Pending','tagClass'=>'bg-amber-100 text-amber-700 border-amber-200','text'=>'Selling items that seem fraudulent. Contact me at suspicious@email.com for quick cash deals!','meta'=>'Scam or fraud • Reported by @mariasantos • about 5 hours ago'],
['handle'=>'@fakeadmin','tag'=>'Pending','tagClass'=>'bg-amber-100 text-amber-700 border-amber-200','text'=>'OFFICIAL ANNOUNCEMENT: All classes suspended. - PUP Administration (This is a fake post)','meta'=>'Impersonation • Reported by @techclub • 2 days ago'],
],
'reviewed' => [
['handle'=>'@anonymoususer','tag'=>'Reviewed','tagClass'=>'bg-blue-100 text-blue-700 border-blue-200','text'=>'Negative and hateful remarks targeting a specific student organization members...','meta'=>'Harassment or bullying • Reported by @pupcso • 1 day ago'],
],
'resolved' => [
['handle'=>'@freeloader99','tag'=>'Resolved','tagClass'=>'bg-emerald-100 text-emerald-700 border-emerald-200','text'=>'Check out this link for free Netflix accounts! [malicious link]','meta'=>'Spam or misleading content • Reported by @juandc • 3 days ago'],
],
];

$tabs = [
['key'=>'pending','label'=>'Pending','count'=>count($data['pending'])],
['key'=>'reviewed','label'=>'Reviewed','count'=>count($data['reviewed'])],
['key'=>'resolved','label'=>'Resolved','count'=>count($data['resolved'])],
];
@endphp

<div class="max-w-5xl">
    <div class="flex items-start gap-4 mb-6">
        <div class="h-12 w-12 rounded-2xl bg-amber-50 flex items-center justify-center">
            <svg class="h-6 w-6 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 22V4" />
                <path d="M4 4h10l-1 4 4 2-2 4H4" />
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Content Moderation</h1>
            <p class="text-sm text-gray-500 mt-1">Review and manage reported content</p>
        </div>
    </div>

    {{-- tabs --}}
    <div class="inline-flex items-center gap-2 rounded-full bg-black/5 p-1 mb-5">
        @foreach($tabs as $t)
        <a href="{{ route('admin.moderation', ['tab'=>$t['key']]) }}"
            class="px-4 py-2 rounded-full text-sm font-semibold transition
                {{ $tab===$t['key'] ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600 hover:text-gray-900' }}">
            {{ $t['label'] }} ({{ $t['count'] }})
        </a>
        @endforeach
    </div>

    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-6">
        <div class="mb-4">
            <div class="text-lg font-extrabold text-gray-900">
                {{ ucfirst($tab) }} Reports
            </div>
            <div class="text-sm text-gray-500">
                {{ $tab==='pending' ? 'Reports waiting for review and action' : ($tab==='reviewed' ? 'Reports that have been reviewed' : 'Reports that have been handled') }}
            </div>
        </div>

        <div class="space-y-4">
            @foreach($data[$tab] as $r)
            <div class="border border-black/10 rounded-2xl p-5">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <div class="font-extrabold text-gray-900">{{ $r['handle'] }}</div>
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold border {{ $r['tagClass'] }}">
                                {{ $r['tag'] }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-700 mt-2">{{ $r['text'] }}</div>
                        <div class="text-xs text-gray-500 mt-2">
                            <span class="inline-flex items-center gap-2">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 9v4" />
                                    <path d="M12 17h.01" />
                                    <path d="M10 2h4l8 18H2z" />
                                </svg>
                                {{ $r['meta'] }}
                            </span>
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