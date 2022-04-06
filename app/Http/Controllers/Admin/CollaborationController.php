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
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
        $collaborations = Collaboration::where('confirmed',1)
                            ->latest()
                            ->get();

        $data = [
            'collaborations' => $collaborations,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.collaborations.index', $data);
    }

    public function loadCollaborationsInfo(Request $request){

        $request->validate([
            'collaborations' => 'required',
        ]);

        $_collaborations = $request->collaborations;
        $collaborations_info = [];
        foreach ($_collaborations as $_collaboration) {
            $collaboration = json_decode($_collaboration,true);
            $collaboration_info['id'] = $collaboration['id'];
            if($collaboration['sender_user_id']){
                $collaboration_info['account_1'] = User::where('id',$collaboration['sender_user_id'])
                ->select('id','name','surname','image','summary')
                ->first();
                $collaboration_info['account_1']['user_or_page'] = true;
            }
            if($collaboration['sender_page_id']){
                $collaboration_info['account_1'] = Page::where('id',$collaboration['sender_page_id'])
                ->select('id','name','image','summary')
                ->first();
                $collaboration_info['account_1']['user_or_page'] = false;
            }
            if($collaboration['recipient_user_id']){
                $collaboration_info['account_2'] =
                User::where('id',$collaboration['recipient_user_id'])
                ->select('id','name','surname','image','summary')
                ->first();
                $collaboration_info['account_2']['user_or_page'] = true;
            }
            if($collaboration['recipient_page_id']){
                $collaboration_info['account_2'] =
                Page::where('id',$collaboration['recipient_page_id'])
                ->select('id','name','image','summary')
                ->first();
                $collaboration_info['account_2']['user_or_page'] = false;
            }
            array_push($collaborations_info,$collaboration_info);
        }

        return response()->json([
            'success' => true,
            'results' => [
                'collaborations' => $collaborations_info,
            ]
        ]);
    }

    public function my($id,$user_or_page)
    {

        $data = [
            'my_id' => $id,
            'user_or_page' => $user_or_page,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.collaborations.my', $data);
    }

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

    public function getProposalCollaborations(Request $request) {

        $request->validate([
            'account_id' => 'required|integer',
            'user_or_page' => 'required|string',
        ]);

        $account_id = $request->account_id;
        $user_or_page = $request->user_or_page;

        if($user_or_page=='user'){
            $collaborations =
            Collaboration::where('recipient_user_id',$account_id)
            ->where('confirmed',null)
            ->get();
        }elseif($user_or_page=='page'){
            $collaborations =
            Collaboration::where('recipient_page_id',$account_id)
            ->where('confirmed',null)
            ->get();
        }

        foreach ($collaborations as $collaboration) {
            if($collaboration->sender_user_id){
                $collaboration['account'] = User::where('id',$collaboration->sender_user_id)
                ->select('users.id','users.image','users.name', 'users.surname')
                ->first();
            }if($collaboration->sender_page_id){
                $collaboration['account'] = Page::where('id',$collaboration->sender_page_id)
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
            'old_collaboration_id' => 'nullable|integer',//PER CONFERMARE AUTOMATICAMENTE UNA COLLABORAZZIONE GIA INVIATA
        ]);

        $sender_id = $request->sender_id;
        $sender_user_or_page = $request->sender_user_or_page;
        $recipient_id = $request->recipient_id;
        $recipient_user_or_page = $request->recipient_user_or_page;
        $old_collaboration_id = $request->old_collaboration_id;
        $user = Auth::user();
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
                    $ref_to_user_id = $recipient_id;
                    $ref_to_page_id = null;
                    //NOTIFICA al utente ricevente
                    $new_notf = new Notification();
                    $new_notf->user_id = $recipient_id;
                    $new_notf->notification_type_id = 10;
                    $new_notf->ref_user_id = $sender_id;
                    $new_notf->ref_page_id = null;
                    $new_notf->parameter = $recipient_id.'/user';
                    $new_notf->save();
                }else{
                    $new_coll->recipient_page_id = $recipient_id;
                    $ref_to_user_id = null;
                    $ref_to_page_id = $recipient_id;
                    //NOTIFICA agli utenti che gestiscono la pagina ricevente
                    $page_recipent = Page::find($recipient_id);
                    foreach ($page_recipent->users as $user) {
                        $new_notf = new Notification();
                        $new_notf->user_id = $user->id;
                        $new_notf->notification_type_id = 11;
                        $new_notf->ref_user_id = $sender_id;
                        $new_notf->ref_page_id = null;
                        $new_notf->ref_to_page_id = $recipient_id;
                        $new_notf->parameter = $recipient_id.'/page';
                        $new_notf->save();
                    }
                }
                //Auto conferma collaborazione nel caso la sto accettando una collaborazione proposta
                if($old_collaboration_id){
                    $auto_confirm = false;
                    $old_collaboration = Collaboration::find($old_collaboration_id);
                    if($old_collaboration->recipient_user_id){
                        if($old_collaboration->recipient_user_id==$user->id){
                            $auto_confirm = true;
                        }
                    }
                    if($old_collaboration->recipient_page_id){
                        $old_coll_page = Page::find($old_collaboration->recipient_page_id);
                        if($user->pages->contains($old_coll_page)){
                            $auto_confirm = true;
                        }
                    }
                    if($auto_confirm){
                        $new_coll->confirmed = 1;
                    }
                }

                $new_coll->save();

                //NOTIFICA ai miei followers
                $followers = $user->user_follower;
                foreach ($followers as $follower) {
                    $new_notf = new Notification();
                    $new_notf->user_id = $follower->id;
                    $new_notf->notification_type_id = 8;
                    $new_notf->ref_user_id = $user->id;
                    $new_notf->ref_page_id = null;
                    $new_notf->ref_to_user_id = $ref_to_user_id;
                    $new_notf->ref_to_page_id = $ref_to_page_id;
                    $new_notf->parameter = $user->id.'/#collaborations';
                    $new_notf->save();
                }

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
                        $ref_to_user_id = $recipient_id;
                        $ref_to_page_id = null;
                        //NOTIFICA al utente ricevente
                        $new_notf = new Notification();
                        $new_notf->user_id = $recipient_id;
                        $new_notf->notification_type_id = 10;
                        $new_notf->ref_user_id = null;
                        $new_notf->ref_page_id = $sender_id;
                        $new_notf->parameter = $recipient_id.'/user';
                        $new_notf->save();
                    }else{
                        $new_coll->recipient_page_id = $recipient_id;
                        $ref_to_user_id = null;
                        $ref_to_page_id = $recipient_id;
                        //NOTIFICA agli utenti che gestiscono la pagina ricevente
                        $page_recipent = Page::find($recipient_id);
                        foreach ($page_recipent->users as $user) {
                            $new_notf = new Notification();
                            $new_notf->user_id = $user->id;
                            $new_notf->notification_type_id = 11;
                            $new_notf->ref_user_id = null;
                            $new_notf->ref_page_id = $sender_id;
                            $new_notf->ref_to_user_id = null;
                            $new_notf->ref_to_page_id = $recipient_id;
                            $new_notf->parameter = $recipient_id.'/page';
                            $new_notf->save();
                        }
                    }
                    $new_coll->save();
                    //NOTIFICA ai miei followers
                    $followers = $page->page_follower;
                    foreach ($followers as $follower) {
                        $new_notf = new Notification();
                        $new_notf->user_id = $follower->id;
                        $new_notf->notification_type_id = 9;
                        $new_notf->ref_user_id = null;
                        $new_notf->ref_page_id = $page->id;
                        $new_notf->ref_to_user_id = $ref_to_user_id;
                        $new_notf->ref_to_page_id = $ref_to_page_id;
                        $new_notf->parameter = $page->id.'/#collaborations';
                        $new_notf->save();
                    }
                }
            }
            return redirect()->route('admin.pages.show', ['page' => $page->id]);
        }
    }

    public function deleteCollaboration(Request $request)
    {
        $request->validate([
            'collaboration_id' => 'required|integer',
        ]);
        $collaboration_id = $request->collaboration_id;
        $collaboration = Collaboration::find($collaboration_id);
        $can_delete = false;
        $user = Auth::user();
        //puo eliminare la collaborazione chi la invia
        if($collaboration->sender_user_id){
            if($user->id==$collaboration->sender_user_id){
                $can_delete = true;
            }
        }
        if($collaboration->sender_page_id){
            $page = Page::find($collaboration->sender_page_id);
            if($user->pages->contains($page)){
                $can_delete = true;
            }
        }
        //e chi la riceve
        if($collaboration->recipient_user_id){
            if($user->id==$collaboration->recipient_user_id){
                $can_delete = true;
            }
        }
        if($collaboration->recipient_page_id){
            $page = Page::find($collaboration->recipient_page_id);
            if($user->pages->contains($page)){
                $can_delete = true;
            }
        }
        if($can_delete){
            $collaboration->delete();
        }
    }

    public function confirmCollaboration(Request $request)
    {
        $request->validate([
            'collaboration_id' => 'required|integer',
        ]);
        $collaboration_id = $request->collaboration_id;
        $collaboration = Collaboration::find($collaboration_id);
        $can_update = false;
        $user = Auth::user();
        if($collaboration->recipient_user_id){
            if($user->id==$collaboration->recipient_user_id){
                $can_update = true;
                $user_or_page = 'user';
            }
        }
        if($collaboration->recipient_page_id){
            $page = Page::find($collaboration->recipient_page_id);
            if($user->pages->contains($page)){
                $can_update = true;
                $user_or_page = 'page';
            }
        }
        if($can_update){
            $collaboration->confirmed = 1;
            $collaboration->update();
            //NOTIFICA
            //se a confermare è un utente
            if($user_or_page=='user'){
                if($collaboration->sender_user_id){
                    $new_notf = new Notification();
                    $new_notf->user_id = $collaboration->sender_user_id;
                    $new_notf->notification_type_id = 12;
                    $new_notf->ref_user_id = $user->id;
                    $new_notf->ref_page_id = null;
                    $new_notf->parameter = $collaboration->sender_user_id.'/#collaborations';
                    $new_notf->save();
                }
                if($collaboration->sender_page_id){
                    $page_sender = Page::find($collaboration->sender_page_id);
                    foreach ($page_sender->users as $user_page) {
                        $new_notf = new Notification();
                        $new_notf->user_id = $user_page->id;
                        $new_notf->notification_type_id = 13;
                        $new_notf->ref_user_id = $user->id;
                        $new_notf->ref_to_page_id = $page_sender->id;
                        $new_notf->parameter = $page_sender->id.'/#collaborations';
                        $new_notf->save();
                    }
                }
            }elseif($user_or_page=='page'){
                if($collaboration->sender_user_id){
                    $new_notf = new Notification();
                    $new_notf->user_id = $collaboration->sender_user_id;
                    $new_notf->notification_type_id = 12;
                    $new_notf->ref_page_id = $collaboration->recipient_page_id;
                    $new_notf->parameter = $collaboration->sender_user_id.'/#collaborations';
                    $new_notf->save();
                }
                if($collaboration->sender_page_id){
                    $page_sender = Page::find($collaboration->sender_page_id);
                    foreach ($page_sender->users as $user_page) {
                        $new_notf = new Notification();
                        $new_notf->user_id = $user_page->id;
                        $new_notf->notification_type_id = 13;
                        $new_notf->ref_page_id = $collaboration->recipient_page_id;
                        $new_notf->ref_to_page_id = $page_sender->id;
                        $new_notf->parameter = $page_sender->id.'/#collaborations';
                        $new_notf->save();
                    }
                }
            }
        }
    }
    public function latestCollaborations(){
        $collaborations = Collaboration::latest()
        ->take(4)
        ->get();
        $collaborations_info = [];
        foreach ($collaborations as $collaboration) {
            $collaboration_info['id'] = $collaboration['id'];
            if($collaboration['sender_user_id']){
                $collaboration_info['account_1'] = User::where('id',$collaboration['sender_user_id'])
                ->select('id','name','surname','image','summary')
                ->first();
                $collaboration_info['account_1']['user_or_page'] = true;
            }
            if($collaboration['sender_page_id']){
                $collaboration_info['account_1'] = Page::where('id',$collaboration['sender_page_id'])
                ->select('id','name','image','summary')
                ->first();
                $collaboration_info['account_1']['user_or_page'] = false;
            }
            if($collaboration['recipient_user_id']){
                $collaboration_info['account_2'] =
                User::where('id',$collaboration['recipient_user_id'])
                ->select('id','name','surname','image','summary')
                ->first();
                $collaboration_info['account_2']['user_or_page'] = true;
            }
            if($collaboration['recipient_page_id']){
                $collaboration_info['account_2'] =
                Page::where('id',$collaboration['recipient_page_id'])
                ->select('id','name','image','summary')
                ->first();
                $collaboration_info['account_2']['user_or_page'] = false;
            }
            array_push($collaborations_info,$collaboration_info);
        }
        return response()->json([
            'success' => true,
            'results' => [
                'collaborations' => $collaborations_info,
            ]
        ]);
    }
}
