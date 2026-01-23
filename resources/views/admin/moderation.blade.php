@extends('layouts.admin')
@section('title', 'Content Moderation')

@section('content')
@php
use App\Models\Report;
use Illuminate\Support\Str;

$tab = request('tab', 'pending');
$reports = Report::where('status', $tab)->latest()->get();

$tabs = [
    ['key'=>'pending','label'=>'Pending','count'=>Report::where('status','pending')->count()],
    ['key'=>'resolved','label'=>'Resolved','count'=>Report::where('status','resolved')->count()],
    ['key'=>'dismissed','label'=>'Dismissed','count'=>Report::where('status','dismissed')->count()],
];
@endphp

<div class="max-w-5xl">
    <h1 class="text-3xl font-extrabold mb-6">🚨 Content Moderation</h1>

    {{-- Tabs --}}
    <div class="inline-flex items-center gap-2 rounded-full bg-black/5 p-1 mb-5">
        @foreach($tabs as $t)
        <a href="{{ route('admin.reports.moderation', ['tab'=>$t['key']]) }}"
           class="px-4 py-2 rounded-full text-sm font-semibold transition
           {{ $tab===$t['key'] ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600 hover:text-gray-900' }}">
           {{ $t['label'] }} ({{ $t['count'] }})
        </a>
        @endforeach
    </div>

    <div class="bg-white border rounded-2xl shadow-sm p-6">
        <div class="mb-4">
            <div class="text-lg font-extrabold">{{ ucfirst($tab) }} Reports</div>
        </div>

        <div class="space-y-4">
            @forelse($reports as $r)
            <div class="border rounded-2xl p-5 hover:bg-gray-50 transition">
                <div class="flex items-start gap-4">
                    <div class="flex-1">
                        <div class="font-extrabold">
                            Post by 
                            {{ $r->post && $r->post->user ? '@' . $r->post->user->username : 'Deleted User' }}
                        </div>
                        <span class="inline-block px-2 py-1 text-xs font-semibold bg-amber-100 text-amber-700 rounded-full">
                            {{ ucfirst($r->reason) }}
                        </span>
                        <div class="text-sm text-gray-600 mt-1">
                            {{ Str::limit($r->details, 100) }}
                        </div>

                        {{-- ✅ Show post content if available --}}
                        @if($r->post && $r->post->post_content)
                        <div class="text-sm text-gray-800 mt-2 italic">
                            "{{ $r->post->post_content }}"
                        </div>
                        @endif

                        <div class="text-xs text-gray-500 mt-2">
                            Reported by {{ optional($r->reporter)->username ? '@' . $r->reporter->username : 'Unknown' }}
                        </div>
                        <div class="text-xs text-gray-400">
                            Reported {{ $r->created_at->diffForHumans() }}
                        </div>
                    </div>

                    {{-- ✅ Moderation Actions (only for pending) --}}
                    @if($r->status === 'pending')
                    <div class="ml-4 flex flex-col gap-2">
                        <form method="POST" action="{{ route('admin.reports.updateStatus', $r) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="resolved">
                            <button type="submit"
                                    class="px-4 py-2 rounded-xl bg-green-600 text-white text-sm font-semibold hover:bg-green-700">
                                ✅ Resolve
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.reports.updateStatus', $r) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="dismissed">
                            <button type="submit"
                                    class="px-4 py-2 rounded-xl bg-gray-300 text-gray-800 text-sm font-semibold hover:bg-gray-400">
                                ❌ Dismiss
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-sm text-gray-500">No {{ $tab }} reports available.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection