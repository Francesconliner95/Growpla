<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notification;
use App\Language;
use App\User;
use App\Page;
use App\Usertype;
use App\Pagetype;

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
                $notification['image'] = $user->image;
            }
            if($notification->ref_page_id){
                $page = Page::find($notification->ref_page_id);
                $notification['name'] = $page->name;
                $notification['image'] = $page->image;
            }
            if($notification->ref_to_user_id){
                $user = User::find($notification->ref_to_user_id);
                $notification['end_name'] = $user->name. ' ' . $user->surname;
            }
            if($notification->ref_to_page_id){
                $notification['end_name'] = Page::find($notification->ref_to_page_id)->name;
            }
            if($notification->pagetype_id){
                $notification['name_type'] = Pagetype::find($notification->pagetype_id)->name_it;
            }
            if($notification->usertype_id){
                $notification['name_type'] = Usertype::find($notification->usertype_id)->name_it;
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
              $notification['image'] = $user->image;
          }
          if($notification->ref_page_id){
              $page = Page::find($notification->ref_page_id);
              $notification['name'] = $page->name;
              $notification['image'] = $page->image;
          }
          if($notification->ref_to_user_id){
              $user = User::find($notification->ref_to_user_id);
              $notification['end_name'] = $user->name. ' ' . $user->surname;
          }
          if($notification->ref_to_page_id){
              $notification['end_name'] = Page::find($notification->ref_to_page_id)->name;
          }
          if($notification->pagetype_id){
              $notification['name_type'] = Pagetype::find($notification->pagetype_id)->name_it;
          }
          if($notification->usertype_id){
              $notification['name_type'] = Usertype::find($notification->usertype_id)->name_it;
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
