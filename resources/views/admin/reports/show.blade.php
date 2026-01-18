@extends('layouts.app')
@section('title', 'Report Details')

@section('main_class', 'bg-app-page')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.reports.index') }}" class="text-blue-500 hover:text-blue-700">&larr; Back to Reports</a>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <!-- Report Details -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Report Details</h2>

            <div class="space-y-4">
                <div>
                    <p class="text-gray-600 font-semibold">Reason</p>
                    <p class="capitalize">{{ str_replace('_', ' ', $report->reason) }}</p>
                </div>

                <div>
                    <p class="text-gray-600 font-semibold">Reported By</p>
                    <p>{{ $report->reportedBy->first_name }} {{ $report->reportedBy->last_name }}</p>
                </div>

                <div>
                    <p class="text-gray-600 font-semibold">Status</p>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        @if ($report->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif ($report->status === 'resolved') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($report->status) }}
                    </span>
                </div>

                <div>
                    <p class="text-gray-600 font-semibold">Date Reported</p>
                    <p>{{ $report->created_at->format('F d, Y H:i') }}</p>
                </div>

                @if ($report->details)
                    <div>
                        <p class="text-gray-600 font-semibold">Additional Details</p>
                        <p>{{ $report->details }}</p>
                    </div>
                @endif

                <!-- Update Status Form -->
                <form action="{{ route('admin.reports.update', $report) }}" method="POST" class="mt-4 pt-4 border-t">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 font-semibold mb-2">Update Status</label>
                        <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="dismissed" {{ $report->status === 'dismissed' ? 'selected' : '' }}>Dismissed</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">Update Status</button>
                </form>
            </div>
        </div>

        <!-- Reported Post -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Reported Post</h2>

            <div class="border rounded-lg p-4 mb-4">
                <!-- Post Header -->
                <div class="flex items-center mb-4">
                    <img src="{{ $report->post->user->profile_pic ?? 'https://i.pravatar.cc/120?img=' . $report->post->user->user_id }}" alt="{{ $report->post->user->first_name }}" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-bold">{{ $report->post->user->first_name }} {{ $report->post->user->last_name }}</p>
                        <p class="text-gray-500 text-sm">{{ $report->post->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Post Content -->
                <p class="text-gray-800 mb-4">{{ $report->post->post_content }}</p>

                <!-- Category Badge -->
                <div class="mb-2">
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full capitalize">
                        {{ str_replace('_', ' ', $report->post->category) }}
                    </span>
                </div>

                <!-- Image -->
                @if ($report->post->image)
                    <img src="{{ Storage::url($report->post->image) }}" alt="Post image" class="w-full h-auto rounded-lg max-h-48 object-cover">
                @endif
            </div>

            <a href="{{ route('posts.show', $report->post) }}" class="text-blue-500 hover:text-blue-700 font-semibold">View Full Post</a>
        </div>
    </div>
</div>
@endsection
