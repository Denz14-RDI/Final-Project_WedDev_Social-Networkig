<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Store a new report
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'reason'  => 'required|in:spam,harassment,misinformation,inappropriate,other',
            'details' => 'nullable|string|max:1000',
        ]);

        // 🔎 Check if this user already reported this post
        $existingReport = Report::where('post_id', $post->post_id)
            ->where('reported_by', Auth::user()->user_id)
            ->first();

        if ($existingReport) {
            return back()->with('error', 'You have already reported this post.');
        }

        // ✅ Create new report if none exists
        Report::create([
            'post_id'     => $post->post_id,  
            'reported_by' => Auth::user()->user_id,
            'reason'      => $validated['reason'],
            'details'     => $validated['details'] ?? null,
            'status'      => 'pending',
        ]);

        return back()->with('success', 'Report submitted successfully!');
    }

    // List all reports
    public function index()
    {
        $reports = Report::with(['post.user', 'reporter'])->latest()->get();
        return view('admin.reports.index', compact('reports'));
    }

    // Show a single report (optional, can keep for detail view)
    public function show(Report $report)
    {
        $report->load(['post.user', 'reporter']);
        return view('admin.reports.show', compact('report'));
    }

    // Update report status (resolve/dismiss just changes status, no deletion)
    public function updateStatus(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,resolved,dismissed',
        ]);

        if ($validated['status'] === 'resolved') {
            // ✅ Cascade: mark ALL reports for this post as resolved
            Report::where('post_id', $report->post_id)->update(['status' => 'resolved']);
        } elseif ($validated['status'] === 'dismissed') {
            // ✅ Only dismiss this single report
            $report->status = 'dismissed';
            $report->save();
        }

        return back()->with('success', 'Report status updated!');
    }

    // Moderation dashboard view
    public function moderationView()
    {
        return view('admin.moderation');
    }
}