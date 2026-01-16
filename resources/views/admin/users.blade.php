@extends('layouts.admin')
@section('title', 'User Management')

@section('content')
@php
$users = [
['name'=>'Juan Dela Cruz','handle'=>'@juandc','email'=>'juan.delacruz@pup.edu.ph','role'=>'Student','roleClass'=>'bg-amber-100 text-amber-700 border-amber-200','posts'=>24,'joined'=>'1/15/2024','initial'=>'J'],
['name'=>'PUP Central Student Organization','handle'=>'@pupcso','email'=>'cso@pup.edu.ph','role'=>'Organization','roleClass'=>'bg-blue-100 text-blue-700 border-blue-200','posts'=>156,'joined'=>'8/1/2023','initial'=>'P'],
['name'=>'Prof. Maria Santos','handle'=>'@mariasantos','email'=>'maria.santos@pup.edu.ph','role'=>'Faculty','roleClass'=>'bg-purple-100 text-purple-700 border-purple-200','posts'=>45,'joined'=>'6/10/2023','initial'=>'P'],
['name'=>'PUP Tech Club','handle'=>'@techclub','email'=>'techclub@pup.edu.ph','role'=>'Organization','roleClass'=>'bg-blue-100 text-blue-700 border-blue-200','posts'=>78,'joined'=>'2/20/2024','initial'=>'P'],
['name'=>'Mark Reyes','handle'=>'@alumnus2020','email'=>'mark.reyes@gmail.com','role'=>'Alumni','roleClass'=>'bg-orange-100 text-orange-700 border-orange-200','posts'=>12,'joined'=>'3/5/2024','initial'=>'M'],
];
@endphp

<div class="max-w-5xl">
    <div class="flex items-start gap-4 mb-6">
        <div class="h-12 w-12 rounded-2xl bg-blue-50 flex items-center justify-center">
            <svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">User Management</h1>
            <p class="text-sm text-gray-500 mt-1">View and manage platform users</p>
        </div>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-5 mb-5">
        <div class="flex items-center gap-3 rounded-xl border border-black/10 px-4 py-3">
            <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="7" />
                <path d="M21 21l-4.3-4.3" />
            </svg>
            <input class="w-full outline-none text-sm" placeholder="Search users by name, username, or email..." />
        </div>
    </div>

    <div class="bg-white border border-black/10 rounded-2xl shadow-sm p-6">
        <div class="mb-4">
            <div class="text-lg font-extrabold text-gray-900">All Users</div>
            <div class="text-sm text-gray-500">{{ count($users) }} users found</div>
        </div>

        <div class="space-y-4">
            @foreach($users as $u)
            <div class="border border-black/10 rounded-2xl p-5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-black/5 border border-black/10 flex items-center justify-center font-extrabold text-gray-700">
                            {{ $u['initial'] }}
                        </div>

                        <div class="leading-tight">
                            <div class="flex items-center gap-3">
                                <div class="font-extrabold text-gray-900">{{ $u['name'] }}</div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $u['roleClass'] }}">
                                    {{ $u['role'] }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 mt-1">{{ $u['handle'] }}</div>
                            <div class="text-xs text-gray-400">{{ $u['email'] }}</div>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="text-sm font-extrabold text-gray-900">{{ $u['posts'] }} posts</div>
                        <div class="text-xs text-gray-500">Joined {{ $u['joined'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection