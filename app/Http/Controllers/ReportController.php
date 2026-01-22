<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Store a new report (user action).
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'reason'  => 'required|in:spam,harassment,misinformation,inappropriate,other',
            'details' => 'nullable|string|max:1000',
        ]);

        Report::create([
            'post_id'     => $post->post_id,
            'reported_by' => Auth::id(),
            'reason'      => $validated['reason'],
            'details'     => $validated['details'] ?? null,
            'status'      => 'pending',
        ]);

        return back()->with('success', 'Report submitted successfully!');
    }

    /**
     * Show all reports (admin view).
     */
    public function index()
    {
        $reports = Report::with(['post', 'reporter'])->latest()->get();
        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Update the status of a report (admin action).
     */
    public function updateStatus(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,resolved,dismissed',
        ]);

        $report->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Report status updated!');
    }
}