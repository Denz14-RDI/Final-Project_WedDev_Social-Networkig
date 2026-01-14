@extends('layouts.app')
@section('title','Profile')

@section('main_class', 'bg-[#F7F4EF]')

@section('content')
<div class="h-screen overflow-hidden bg-[#F7F4EF]">
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER (scroll) --}}
    <main class="h-full overflow-y-auto">
      <div class="px-6 py-10">
        <div class="max-w-[980px] mx-auto">

          {{-- profile header card --}}
          <div class="bg-white rounded-2xl shadow-[0_18px_40px_rgba(0,0,0,.12)] border border-black/10 overflow-hidden">

            {{-- COVER --}}
            <div class="h-44 sm:h-52 bg-gradient-to-r from-[#6C1517] via-[#7B2A2D] to-[#9B5658]"></div>

            {{-- CONTENT --}}
            <div class="px-8 pb-8">
              <div class="relative pt-8 sm:pt-10">

                {{-- avatar --}}
                <div class="absolute -top-10 sm:-top-12 left-0">
                  <div class="h-24 w-24 sm:h-28 sm:w-28 rounded-full bg-gray-200 ring-4 ring-white"></div>
                </div>

                {{-- edit button --}}
                <div class="absolute top-3 right-0">
                  <a href="#"
                    class="inline-flex items-center justify-center rounded-xl bg-[#6C1517] px-5 py-2.5 text-sm font-semibold text-white hover:opacity-95">
                    Edit Profile
                  </a>
                </div>

                {{-- text --}}
                <div class="mt-10 sm:mt-12">
                  <div class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">
                    Juan Dela Cruz
                  </div>
                  <div class="mt-1 text-sm text-gray-500">@juan_delacruz</div>

                  <div class="mt-3 text-sm text-gray-700">
                    Hello! I’m part of the PUP community.
                  </div>

                  <div class="mt-3 flex items-center gap-2 text-sm text-gray-600">
                    <span>📅</span>
                    <span>Joined January 2024</span>
                  </div>

                  <div class="mt-4 text-sm text-gray-800">
                    <span class="font-extrabold">2</span>
                    <span class="ml-1">Iskoolmates</span>
                  </div>
                </div>
              </div>

              <div class="mt-8 border-t border-black/10"></div>

              {{-- posts list (sample) --}}
              <div class="mt-6 space-y-6">

                {{-- post 1 --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_10px_18px_rgba(0,0,0,.08)] p-6">
                  <div class="flex items-start gap-4">
                    <div class="h-12 w-12 rounded-full bg-gray-200"></div>

                    <div class="flex-1">
                      <div class="flex items-start justify-between gap-4">
                        <div class="leading-tight">
                          <div class="font-extrabold text-gray-900">Juan Dela Cruz</div>
                          <div class="text-sm text-gray-500">@juan_delacruz · 1d ago</div>
                        </div>
                        <button class="text-gray-400 hover:text-gray-600">⋯</button>
                      </div>

                      <div class="mt-3 text-sm text-gray-900">
                        🔴 <span class="font-extrabold">LOST ITEM ALERT</span> 🔴<br><br>
                        I lost my black JBL earphones somewhere in the CCIS building (3rd floor) yesterday around 4PM.
                        If you found it, please message me. Thank you!
                      </div>

                      <div class="mt-4 h-48 rounded-2xl bg-gray-200"></div>
                    </div>
                  </div>
                </div>

                {{-- post 2 --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_10px_18px_rgba(0,0,0,.08)] p-6">
                  <div class="flex items-start gap-4">
                    <div class="h-12 w-12 rounded-full bg-gray-200"></div>

                    <div class="flex-1">
                      <div class="flex items-start justify-between gap-4">
                        <div class="leading-tight">
                          <div class="font-extrabold text-gray-900">Juan Dela Cruz</div>
                          <div class="text-sm text-gray-500">@juan_delacruz · 3d ago</div>
                        </div>
                        <button class="text-gray-400 hover:text-gray-600">⋯</button>
                      </div>

                      <div class="mt-3 text-sm text-gray-900">
                        Quick reminder: CCIS Week booth signups are open! 🎉
                        See you all at the campus grounds.
                      </div>

                      <div class="mt-4 h-40 rounded-2xl bg-gray-200"></div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- back link --}}
          <div class="mt-6">
            <a href="{{ route('feed') }}" class="text-[#6C1517] font-semibold hover:underline">
              ← Back to Feed
            </a>
          </div>

        </div>
      </div>
    </main>

    {{-- RIGHT SIDEBAR (UNIFIED PARTIAL) --}}
    @include('partials.right-sidebar')

  </div>
</div>
@endsection