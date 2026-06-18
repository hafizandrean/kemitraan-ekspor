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
        $request->validate([
<<<<<<< Updated upstream
            'action' => 'required|string|in:dismiss,resolve',
        ]);

        $status = $request->action === 'resolve' ? 'resolved' : 'dismissed';
        
        $report->update([
            'status' => $status,
        ]);

        $message = $status === 'resolved' 
            ? 'Laporan ditandai sebagai diselesaikan dengan tindakan.' 
            : 'Laporan ditolak/diabaikan.';

        return redirect()->route('admin.chat.dashboard')->with('success', $message);
    }

    /**
     * Toggle the status of a user (active, suspended, banned).
=======
            'status' => 'required|in:resolved,dismissed',
            'action_taken' => 'nullable|string|max:500',
        ]);

        $report->update([
            'status' => $request->status,
        ]);

        $msg = $request->status === 'resolved' 
            ? 'Laporan berhasil diselesaikan dengan tindakan.' 
            : 'Laporan berhasil ditolak (dismissed).';

        return redirect()->route('admin.chat.dashboard')->with('success', $msg);
    }

    /**
     * Update user status (active, suspended, banned).
>>>>>>> Stashed changes
     */
    public function toggleUserStatus(Request $request, User $user)
    {
        $request->validate([
<<<<<<< Updated upstream
            'status' => 'required|string|in:active,suspended,banned',
=======
            'status' => 'required|in:active,suspended,banned',
>>>>>>> Stashed changes
        ]);

        $user->update([
            'status' => $request->status,
        ]);

<<<<<<< Updated upstream
        return redirect()->back()->with('success', "Status pengguna {$user->name} berhasil diubah menjadi: " . strtoupper($request->status));
    }
}
=======
        // If suspending/banning an exporter, optionally log them out or just rely on EnsureNotSuspended middleware.
        $statusLabels = [
            'active' => 'diaktifkan kembali',
            'suspended' => 'ditangguhkan (suspended)',
            'banned' => 'diblokir permanen (banned)',
        ];

        return redirect()->back()->with('success', "Status user {$user->name} berhasil diubah menjadi {$statusLabels[$request->status]}.");
    }
}
>>>>>>> Stashed changes
