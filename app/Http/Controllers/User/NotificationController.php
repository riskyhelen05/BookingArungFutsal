<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'unread' => $unreadCount,
            'data' => $notifications->map(function ($n) {
                return [
                    'id' => $n->id,
                    'title' => $n->title,
                    'message' => $n->message,
                    'is_read' => $n->is_read,
                    'url' => match ($n->type) {

                    'booking_success'
                        => route('user.booking.show', $n->booking_id),

                    'booking_cancelled'
                        => route('user.booking.show', $n->booking_id),

                    'booking_reminder'
                        => route('user.booking.show', $n->booking_id),

                    'review_request'
                        => route('user.review.create', $n->booking_id),

                    default => '#'
                    }
                ];
            }),
        ]);
    }

    public function read($id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notif->update([
            'is_read' => true
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    // 🔥 TAMBAHKAN INI
    public function show($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->update([
            'is_read' => true
        ]);

        return view(
            'user.notifications.show',
            compact('notification')
        );
    }
}