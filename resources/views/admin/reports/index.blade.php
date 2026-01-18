@extends('layouts.app')
@section('title', 'Admin - Reports')

@section('main_class', 'bg-app-page')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Reports Management</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left">Post</th>
                    <th class="px-6 py-3 text-left">Reported By</th>
                    <th class="px-6 py-3 text-left">Reason</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $report)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('posts.show', $report->post) }}" class="text-blue-500 hover:text-blue-700 truncate block">
                                {{ substr($report->post->post_content, 0, 50) }}...
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            {{ $report->reportedBy->first_name }} {{ $report->reportedBy->last_name }}
                        </td>
                        <td class="px-6 py-4 capitalize">
                            {{ str_replace('_', ' ', $report->reason) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                @if ($report->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif ($report->status === 'resolved') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $report->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.reports.show', $report) }}" class="text-blue-500 hover:text-blue-700">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No reports found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($reports->hasPages())
        <div class="mt-6">
            {{ $reports->links() }}
        </div>
    @endif
</div>
@endsection
