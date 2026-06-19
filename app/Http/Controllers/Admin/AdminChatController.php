<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    /**
     * Display the chat moderation dashboard.
     */
    public function dashboard()
    {
        // Statistics
        $totalConversations = Conversation::count();
        $messagesToday = Message::whereDate('created_at', now()->toDateString())->count();
        $pendingReports = Report::where('status', 'pending')->count();
        $suspendedUsersCount = User::whereIn('status', ['suspended', 'banned'])->count();

        // Top Reported Users
        $topReportedUsers = User::withCount('reportsAgainst')
            ->orderBy('reports_against_count', 'desc')
            ->take(10)
            ->get()
            ->filter(fn ($user) => $user->reports_against_count > 0);

        // All Reports
        $reports = Report::with(['reporter', 'reportedUser', 'conversation.product'])
            ->latest()
            ->get();

        return view('admin.chat.dashboard', compact(
            'totalConversations',
            'messagesToday',
            'pendingReports',
            'suspendedUsersCount',
            'topReportedUsers',
            'reports'
        ));
    }

    /**
     * Display details of a specific report (including conversation messages).
     */
    public function showReport(Report $report)
    {
        $report->load(['reporter', 'reportedUser', 'conversation.product']);

        $messages = collect();
        if ($report->conversation) {
            $messages = $report->conversation->messages()->with('sender')->oldest()->get();
        }

        return view('admin.chat.report', compact('report', 'messages'));
    }

    /**
     * Resolve or dismiss a report.
     */
    public function resolveReport(Request $request, Report $report)
    {
        if ($request->has('action')) {
            $request->validate([
                'action' => 'required|string|in:resolve,dismiss',
            ]);
            $status = $request->action === 'resolve' ? 'resolved' : 'dismissed';
        } else {
            $request->validate([
                'status' => 'required|in:resolved,dismissed',
            ]);
            $status = $request->status;
        }

        $report->update([
            'status' => $status,
        ]);

        $msg = $status === 'resolved' 
            ? 'Laporan berhasil diselesaikan dengan tindakan.' 
            : 'Laporan berhasil ditolak (dismissed).';

        return redirect()->route('admin.chat.dashboard')->with('success', $msg);
    }

    /**
     * Update user status (active, suspended, banned).
     */
    public function toggleUserStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,suspended,banned',
        ]);

        $user->update([
            'status' => $request->status,
        ]);

        // If suspending/banning an exporter, optionally log them out or just rely on EnsureNotSuspended middleware.
        $statusLabels = [
            'active' => 'diaktifkan kembali',
            'suspended' => 'ditangguhkan (suspended)',
            'banned' => 'diblokir permanen (banned)',
        ];

        return redirect()->back()->with('success', "Status user {$user->name} berhasil diubah menjadi {$statusLabels[$request->status]}.");
    }
}
