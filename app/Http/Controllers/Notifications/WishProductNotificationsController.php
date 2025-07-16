<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishProductNotificationsController extends Controller
{
    public function index() {
        $user = Auth::user();
        $notifications = $user->unreadNotifications;

        return response()->json([
            'notifications' => $notifications,
            'count' => $notifications->count()
        ]);
    }

    public function markAsRead(Request $request) {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }

    public function markOneReaded(Request $request, $notify_id){
        $notification = Auth::user()->notifications->where('id', $notify_id)->first();
        if($notification){
            $notification->markAsRead();
        }
        return response()->json(['success' => true]);
    }
}
