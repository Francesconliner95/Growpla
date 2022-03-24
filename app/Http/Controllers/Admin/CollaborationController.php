<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Language;
use App\Collaboration;
use App\User;
use App\Page;
use App\Notification;

class CollaborationController extends Controller
{

    public function create($id,$user_or_page)
    {

        $data = [
            'my_id' => $id,
            'user_or_page' => $user_or_page,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.collaborations.create', $data);

    }

    public function getCollaborations(Request $request) {

        $request->validate([
            'account_id' => 'required|integer',
            'user_or_page' => 'required|string',
        ]);

        $account_id = $request->account_id;
        $user_or_page = $request->user_or_page;

        if($user_or_page=='user'){
            $collaborations =
            Collaboration::where('sender_user_id',$account_id)
            ->get();
        }elseif($user_or_page=='page'){
            $collaborations =
            Collaboration::where('sender_page_id',$account_id)
            ->get();
        }

        foreach ($collaborations as $collaboration) {
            if($collaboration->recipient_user_id){
                $collaboration['account'] = User::where('id',$collaboration->recipient_user_id)
                ->select('users.id','users.image','users.name', 'users.surname')
                ->first();
            }if($collaboration->recipient_page_id){
                $collaboration['account'] = Page::where('id',$collaboration->recipient_page_id)
                ->select('pages.id','pages.image','pages.name')->first();
            }
        }

        return response()->json([
            'success' => true,
            'results' => [
                'collaborations' => $collaborations,
            ]
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|integer',
            'sender_user_or_page' => 'required|string',
            'recipient_id' => 'required|integer',
            'recipient_user_or_page' => 'required|string',
        ]);

        $sender_id = $request->sender_id;
        $sender_user_or_page = $request->sender_user_or_page;
        $recipient_id = $request->recipient_id;
        $recipient_user_or_page = $request->recipient_user_or_page;

        $user = Auth::user();
        // dd($sender_id,
        // $sender_user_or_page,
        // $recipient_id,
        // $recipient_user_or_page,);
        //dd($sender_user_or_page=='page');
        $query = Collaboration::query();
        if($sender_user_or_page=='user'){
            $query->where('sender_user_id',$sender_id);
        }
        if($sender_user_or_page=='page'){
            $query->where('sender_page_id',$sender_id);
        }
        if($recipient_user_or_page=='user'){
            $query->where('recipient_user_id',$recipient_id);
        }
        if($recipient_user_or_page=='page'){
            $query->where('recipient_page_id',$recipient_id);
        }
        $already_exist = $query->first();

        if($sender_user_or_page=='user' && $user->id==$sender_id){
            if($recipient_user_or_page=='user'
            && $user->id==$recipient_id){
                $already_exist = true;
            }
            if(!$already_exist){
                $new_coll = new Collaboration();
                $new_coll->sender_user_id = $sender_id;

                if($recipient_user_or_page=='user'){
                    $new_coll->recipient_user_id = $recipient_id;
                }else{
                    $new_coll->recipient_page_id = $recipient_id;
                }
                $new_coll->save();
            }

            return redirect()->route('admin.users.show', ['user' => $user->id]);

        }elseif($sender_user_or_page=='page') {
            $page = Page::find($sender_id);
            if($sender_user_or_page=='page'
            && $recipient_user_or_page=='page'
            && $sender_id==$recipient_id){
                $already_exist = true;
            }
            if(!$already_exist){
                if($user->pages->contains($page)){

                    $new_coll = new Collaboration();
                    $new_coll->sender_page_id = $sender_id;

                    if($recipient_user_or_page=='user'){
                        $new_coll->recipient_user_id = $recipient_id;
                    }else{
                        $new_coll->recipient_page_id = $recipient_id;
                    }
                    $new_coll->save();
                }
            }
            return redirect()->route('admin.pages.show', ['page' => $page->id]);
        }
    }

}
