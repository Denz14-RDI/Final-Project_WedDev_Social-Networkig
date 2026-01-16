@extends('layouts.app')
@section('title','Notifications')

@section('main_class', 'bg-app-page')

@section('content')
@php
$notifications = [
[
'initial' => 'M',
'message' => '<span class="font-semibold">Maria Clara</span> liked your post about the campus library.',
'time' => '5m ago',
'unread' => true,
],
[
'initial' => 'C',
'message' => '<span class="font-semibold">Crisostomo Ibarra</span> commented: “Great points about the new curriculum!”',
'time' => '2h ago',
'unread' => true,
],
[
'initial' => 'E',
'message' => '<span class="font-semibold">Elias</span> sent you a friend request.',
'time' => '5h ago',
'unread' => false,
],
[
'initial' => '🔔',
'message' => 'Your post <span class="font-semibold">“Study Group Tomorrow”</span> is trending in Academic!',
'time' => '1d ago',
'unread' => false,
],
];
@endphp

<div class="h-screen overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER (scroll) --}}
    <section class="px-4 sm:px-6 lg:px-10 py-8 overflow-y-auto">
      <div class="w-full max-w-[840px] mx-auto space-y-5">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4">
          <div>
            <div class="text-3xl font-extrabold text-app leading-tight">Notifications</div>
            <div class="text-sm text-app-muted">Recent activity</div>
          </div>

          <button type="button" class="text-sm font-semibold text-app hover:underline underline-offset-4">
            Mark all as read
          </button>
        </div>

        {{-- List --}}
        <div class="space-y-4">
          @foreach($notifications as $n)
          <div class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">
            <div class="p-5" style="{{ $n['unread'] ? 'background: var(--amber-bg);' : '' }}">
              <div class="flex items-center gap-4">

                <div class="h-12 w-12 rounded-full bg-app-input border border-app flex items-center justify-center font-bold text-app">
                  {!! $n['initial'] !!}
                </div>

                <div class="flex-1 min-w-0">
                  <div class="text-sm text-app">
                    {!! $n['message'] !!}
                  </div>
                  <div class="text-xs text-app-muted mt-1">{{ $n['time'] }}</div>
                </div>

                @if($n['unread'])
                <div class="h-2.5 w-2.5 rounded-full bg-app-brand"></div>
                @endif

              </div>
            </div>
          </div>
          @endforeach
        </div>

      </div>
    </section>

    {{-- RIGHT SIDEBAR --}}
    @include('partials.right-sidebar')

  </div>
</div>
@endsection