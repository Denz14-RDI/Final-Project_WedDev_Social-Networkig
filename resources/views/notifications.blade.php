@extends('layouts.app')
@section('title','Notifications')

{{-- match feed background --}}
@section('main_class', 'bg-[#F3F3F3]')

@section('content')
<div class="h-screen overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER (scroll) --}}
    <main class="h-full overflow-y-auto bg-[#F6F0EE]">

      {{-- top header bar --}}
      <div class="h-16 border-b border-gray-200 bg-[#F6F0EE] flex items-center px-6 lg:px-8">
        <div class="flex items-center gap-3">
          <span class="text-lg">▮▮</span>
          <h1 class="text-xl font-extrabold text-[#6C1517]">Notifications</h1>
        </div>
      </div>

      <div class="px-6 lg:px-14 py-10">
        <div class="max-w-5xl mx-auto">

          <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-extrabold text-gray-900">Recent Activity</h2>
            <button class="text-sm font-semibold text-[#6C1517] hover:underline">
              Mark all as read
            </button>
          </div>

          <div class="space-y-6">

            {{-- unread (pink) --}}
            <div class="bg-[#F3E6E7] border border-[#E7CACC] rounded-2xl shadow-[0_12px_26px_rgba(0,0,0,.12)] p-6">
              <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-700">
                  M
                </div>
                <div class="flex-1">
                  <div class="text-sm text-gray-900">
                    <span class="font-semibold">Maria Clara</span> liked your post about the campus library.
                  </div>
                  <div class="text-xs text-gray-500 mt-1">5m ago</div>
                </div>
                <div class="h-2.5 w-2.5 rounded-full bg-[#6C1517]"></div>
              </div>
            </div>

            {{-- unread (pink) --}}
            <div class="bg-[#F3E6E7] border border-[#E7CACC] rounded-2xl shadow-[0_12px_26px_rgba(0,0,0,.12)] p-6">
              <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-700">
                  C
                </div>
                <div class="flex-1">
                  <div class="text-sm text-gray-900">
                    <span class="font-semibold">Crisostomo Ibarra</span> commented: “Great points about the new curriculum!”
                  </div>
                  <div class="text-xs text-gray-500 mt-1">2h ago</div>
                </div>
                <div class="h-2.5 w-2.5 rounded-full bg-[#6C1517]"></div>
              </div>
            </div>

            {{-- read (white) --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-[0_12px_26px_rgba(0,0,0,.10)] p-6">
              <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-700">
                  E
                </div>
                <div class="flex-1">
                  <div class="text-sm text-gray-900">
                    <span class="font-semibold">Elias</span> sent you a friend request.
                  </div>
                  <div class="text-xs text-gray-500 mt-1">5h ago</div>
                </div>
              </div>
            </div>

            {{-- read (white) --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-[0_12px_26px_rgba(0,0,0,.10)] p-6">
              <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                  🔔
                </div>
                <div class="flex-1">
                  <div class="text-sm text-gray-900">
                    Your post <span class="font-semibold">“Study Group Tomorrow”</span> is trending in Academic!
                  </div>
                  <div class="text-xs text-gray-500 mt-1">1d ago</div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </main>

    {{-- RIGHT SIDEBAR (UNIFIED PARTIAL) --}}
    @include('partials.right-sidebar')

  </div>
</div>
@endsection