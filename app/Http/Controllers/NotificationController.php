<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()->update(['read' => true]);

        return response()->json(['success' => true]);
    }

    // View all notifications
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }
}
