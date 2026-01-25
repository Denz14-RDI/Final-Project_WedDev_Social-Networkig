@extends('layouts.admin')
@section('title', 'Content Moderation')

@section('content')
<div class="w-full max-w-5xl">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-app leading-tight">🚨 Content Moderation</h1>
        <p class="text-sm text-app-muted mt-1">Review and act on reported posts.</p>
    </div>

    {{-- Tabs --}}
    <div class="inline-flex items-center gap-1 rounded-2xl bg-app-input border border-app p-1 mb-5">
        @foreach($tabs as $t)
        <a href="{{ route('admin.reports.moderation', ['tab'=>$t['key']]) }}"
           class="px-4 py-2 rounded-2xl text-sm font-semibold transition whitespace-nowrap
           {{ $tab===$t['key']
                ? 'bg-app-card border border-app shadow-app text-app'
                : 'text-app-muted hover:text-app hover-app' }}">
            {{ $t['label'] }} ({{ $t['count'] }})
        </a>
        @endforeach
    </div>

    {{-- Panel --}}
    <section class="bg-app-card border border-app rounded-2xl shadow-app overflow-hidden">
        <div class="p-6 border-b border-app">
            <div class="text-lg font-extrabold text-app">{{ ucfirst($tab) }} Reports</div>
            <div class="text-sm text-app-muted">Showing {{ $reports->count() }} report(s).</div>
        </div>

        <div class="p-6 space-y-4">
            @forelse($reports as $r)
            <div class="border border-app rounded-2xl p-5 bg-app-card hover-app transition">
                <div class="flex items-start gap-4">

                    <div class="flex-1 min-w-0">
                        {{-- Post + User --}}
                        <div class="font-extrabold text-app truncate">
                            @if($r->post)
                                Post by {{ $r->post->user ? '@'.$r->post->user->username : 'Deleted User' }}
                                @if($r->post->trashed())
                                    <span class="text-red-500">(Post Deleted)</span>
                                @endif
                            @else
                                Post not found
                            @endif
                        </div>

                        {{-- Reason --}}
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full"
                                  style="background: var(--amber-bg); color: var(--amber); border: 1px solid var(--border);">
                                {{ ucfirst($r->reason) }}
                            </span>
                        </div>

                        {{-- Details --}}
                        @if(!empty($r->details))
                        <div class="text-sm text-app-muted mt-2">
                            {{ Str::limit($r->details, 120) }}
                        </div>
                        @endif

                        {{-- Post content --}}
                        @if($r->post && $r->post->post_content)
                        <div class="mt-3 rounded-2xl bg-app-input border border-app p-4 text-sm text-app">
                            <div class="text-xs text-app-muted mb-1">Post content</div>
                            <div class="italic">“{{ Str::limit($r->post->post_content, 260) }}”</div>
                        </div>
                        @endif

                        {{-- Reporter --}}
                        <div class="text-xs text-app-muted mt-3">
                            Reported by {{ optional($r->reporter)->username ? '@'.$r->reporter->username : 'Unknown' }}
                        </div>
                        <div class="text-xs text-app-muted-light">
                            Reported {{ $r->created_at->diffForHumans() }}
                        </div>
                    </div>

                    {{-- Actions (only for pending) --}}
                    @if($r->status === 'pending')
                    <div class="ml-2 flex flex-col gap-2 w-36">
                        <form method="POST" action="{{ route('admin.reports.updateStatus', $r) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="resolved">
                            <button type="submit"
                                    class="w-full h-10 rounded-xl text-sm font-semibold btn-brand hover:opacity-95">
                                ✅ Resolve
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.reports.updateStatus', $r) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="dismissed">
                            <button type="submit"
                                    class="w-full h-10 rounded-xl text-sm font-semibold btn-ghost hover:bg-app-input">
                                ❌ Dismiss
                            </button>
                        </form>
                    </div>
                    @endif

                </div>
            </div>
            @empty
            <div class="text-sm text-app-muted">No {{ $tab }} reports available.</div>
            @endforelse
        </div>
    </section>

</div>
@endsection