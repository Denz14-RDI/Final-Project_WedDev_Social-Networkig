@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
@php
use App\Models\User;
use App\Models\Post;
use App\Models\Report;

// Stats from DB
$stats = [
['label'=>'Total Users', 'value'=>User::count(), 'emoji'=>'👥'],
['label'=>'Total Posts', 'value'=>Post::count(), 'emoji'=>'📝'],
['label'=>'Pending Reports', 'value'=>Report::where('status','pending')->count(), 'emoji'=>'🚩'],
['label'=>'Posts Today', 'value'=>Post::whereDate('created_at', today())->count(), 'emoji'=>'📈'],
];

// Get 3 most recent pending reports
$reports = Report::where('status','pending')
->latest()
->take(3)
->get();
@endphp

<div class="w-full max-w-6xl">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-app leading-tight">Dashboard</h1>
        <p class="text-sm text-app-muted mt-1">Overview of PUPCOM platform activity</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($stats as $s)
        <div class="bg-app-card border border-app rounded-2xl shadow-app p-5">
            <div class="h-10 w-10 rounded-2xl bg-app-input border border-app flex items-center justify-center mb-3 text-xl">
                {{ $s['emoji'] }}
            </div>
            <div class="text-2xl font-extrabold text-app">{{ $s['value'] }}</div>
            <div class="text-xs font-semibold text-app-muted mt-1">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Recent Pending Reports --}}
    @if($reports->count() > 0)
    <section class="mt-6 bg-app-card border border-app rounded-2xl shadow-app overflow-hidden">
        <div class="p-6 border-b border-app">
            <div class="flex items-start gap-3">
                <div class="h-10 w-10 rounded-2xl bg-app-input border border-app flex items-center justify-center text-xl">
                    🚨
                </div>
                <div>
                    <div class="text-lg font-extrabold text-app">Recent Pending Reports</div>
                    <div class="text-sm text-app-muted">Reports that need immediate attention</div>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-4">
            @foreach($reports as $r)
            <div class="border border-app rounded-2xl p-5 bg-app-card hover-app transition">
                <div class="flex items-start gap-4">
                    <div class="h-10 w-10 rounded-2xl bg-app-input border border-app flex items-center justify-center text-xl">
                        🚩
                    </div>

                    <div class="flex-1 min-w-0">
                        {{-- Post Owner --}}
                        <div class="font-extrabold text-app truncate">
                            Post by
                            {{ $r->post && $r->post->user ? '@' . $r->post->user->username : 'Deleted User' }}
                        </div>

                        {{-- Reason Badge --}}
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full"
                                style="background: var(--amber-bg); color: var(--amber); border: 1px solid var(--border);">
                                {{ ucfirst($r->reason) }}
                            </span>
                        </div>

                        {{-- Reporter Username --}}
                        <div class="text-xs text-app-muted mt-3">
                            Reported by
                            {{ $r->reporter && $r->reporter->username ? '@' . $r->reporter->username : 'Unknown' }}
                        </div>

                        {{-- Timestamp --}}
                        <div class="text-xs text-app-mutedlight">
                            Reported {{ $r->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- View All Reports Link --}}
            <div class="pt-2 text-right">
                <a href="{{ route('admin.reports.moderation') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-app hover:underline">
                    View All Reports <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </section>
    @endif

</div>
@endsection