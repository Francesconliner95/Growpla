<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notification;
use App\Language;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $user_id = Auth::user()->id;

        $notifications = Notification::where('user_id',$user_id)
                        ->latest()
                        ->get();

        $data = [
            'notifications' => $notifications,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.notifications.index', $data);

    }

    public function getNotReadNotifications(){

        $user_id = Auth::user()->id;

        $notifications = Notification::where('user_id',$user_id)
                        ->where('read', null)
                        ->latest()
                        ->take(4)
                        ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'notifications' => $notifications,
            ]
        ]);
    }

    public function getNotifications(){

        $user_id = Auth::user()->id;

        $notifications = Notification::where('user_id',$user_id)
                        ->latest()
                        ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'notifications' => $notifications,
            ]
        ]);
    }

    public function readNotifications(Request $request){

        $request->validate([
            'notification_id' => 'required|integer',
        ]);

        $notification_id = $request->notification_id;

        $user_id = Auth::user()->id;

        $notification = Notification::find($notification_id);

        if($notification && $notification->user_id==$user_id){
            $notification->read = 1;
            $notification->update();
        }
    }

}
