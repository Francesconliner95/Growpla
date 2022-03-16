<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notification;
use App\Language;
use App\User;
use App\Page;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index(){

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.notifications.index');

    }

    public function getNotReadNotifications(){

        $user = Auth::user();

        $notifications = $user->notifications()
                        ->where('read', null)
                        ->take(5)
                        ->latest()
                        ->get()
                        ;

        foreach ($notifications as $notification) {
            if ($notification->ref_user_id) {
                $user = User::find($notification->ref_user_id);
                $notification['name'] = $user->name. ' ' . $user->surname;
            }else {
                $notification['name'] = Page::find($notification->ref_page_id)->name;
            }
            $notification = $notification->notification_type;
        }

        return response()->json([
            'success' => true,
            'results' => [
                'notifications' => $notifications,
            ]
        ]);
    }

    public function getNotifications(){

      $user = Auth::user();

      $notifications = $user->notifications()
                      ->latest()
                      ->get();

      foreach ($notifications as $notification) {
          if ($notification->ref_user_id) {
              $user = User::find($notification->ref_user_id);
              $notification['name'] = $user->name. ' ' . $user->surname;
          }else {
              $notification['name'] = Page::find($notification->ref_page_id)->name;
          }
          $notification = $notification->notification_type;
      }

        return response()->json([
            'success' => true,
            'results' => [
                'notifications' => $notifications,
            ]
        ]);
    }

    public function readNotifications(Request $request){

        $user = Auth::user();

        $notifications = $user->notifications->where('read', null);

        foreach ($notifications as $notification) {
            $notification->read = 1;
            $notification->update();
        }

    }

}
