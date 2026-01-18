<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Post;
use App\Http\Requests\StoreReportRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show the form for creating a new report.
     */
    public function create(Post $post)
    {
        return view('reports.create', compact('post'));
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $validated = $request->validated();
        $validated['reported_by'] = auth()->user()->user_id;

        // Check if user already reported this post
        $existing = Report::where('post_id', $validated['post_id'])
            ->where('reported_by', auth()->user()->user_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already reported this post.');
        }

        Report::create($validated);

        return redirect()->back()->with('success', 'Report submitted successfully. Thank you for helping keep our community safe.');
    }

    /**
     * Get all reports (admin only).
     */
    public function index()
    {
        // This should be protected with admin authorization
        $reports = Report::with(['post.user', 'reportedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('reports.index', compact('reports'));
    }

    /**
     * Show a specific report (admin only).
     */
    public function show(Report $report)
    {
        // This should be protected with admin authorization
        return view('reports.show', compact('report'));
    }

    /**
     * Update report status (admin only).
     */
    public function update(Request $request, Report $report)
    {
        // This should be protected with admin authorization
        $validated = $request->validate([
            'status' => 'required|in:pending,resolved,dismissed',
        ]);

        $report->update($validated);

        return back()->with('success', 'Report updated successfully.');
    }
}
