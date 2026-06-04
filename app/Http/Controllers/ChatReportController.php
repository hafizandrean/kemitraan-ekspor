<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatReportController extends Controller
{
    /**
     * Store a new report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reported_user_id' => 'required|exists:users,id',
            'conversation_id' => 'nullable|exists:conversations,id',
            'reason' => 'required|string|in:spam,fraud,harassment,inappropriate,other',
            'description' => 'required|string|min:10|max:1000',
        ]);

        $reporterId = Auth::id();
        $reportedUserId = (int) $request->reported_user_id;
        $conversationId = $request->conversation_id ? (int) $request->conversation_id : null;

        if ($reporterId === $reportedUserId) {
            return redirect()->back()->with('error', 'Anda tidak dapat melaporkan diri sendiri.');
        }

        // Create report
        Report::create([
            'reporter_id' => $reporterId,
            'reported_user_id' => $reportedUserId,
            'conversation_id' => $conversationId,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Laporan Anda telah dikirim ke admin untuk ditinjau. Terima kasih.');
    }
}
