<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->systemNotifications()
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markRead(Request $request, int $id)
    {
        $notification = $request->user()->systemNotifications()->findOrFail($id);
        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllRead(Request $request)
    {
        $request->user()
            ->systemNotifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}

