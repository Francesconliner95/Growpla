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
        $collaborations = Collaboration::query()
                            ->where('col1_confirmed',1)
                            ->where('col2_confirmed',1)
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
            if($collaboration['col1_user_id']){
                $collaboration_info['account_1'] = User::where('id',$collaboration['col1_user_id'])
                ->select('id','name','surname','image','summary')
                ->first();
                $collaboration_info['account_1']['user_or_page'] = true;
            }
            if($collaboration['col1_page_id']){
                $collaboration_info['account_1'] = Page::where('id',$collaboration['col1_page_id'])
                ->select('id','name','image','summary')
                ->first();
                $collaboration_info['account_1']['user_or_page'] = false;
            }
            if($collaboration['col2_user_id']){
                $collaboration_info['account_2'] =
                User::where('id',$collaboration['col2_user_id'])
                ->select('id','name','surname','image','summary')
                ->first();
                $collaboration_info['account_2']['user_or_page'] = true;
            }
            if($collaboration['col2_page_id']){
                $collaboration_info['account_2'] =
                Page::where('id',$collaboration['col2_page_id'])
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

    public function getCollaborations(Request $request) {

        $request->validate([
            'account_id' => 'required|integer',
            'user_or_page' => 'required|string',
        ]);

        $account_id = $request->account_id;
        $user_or_page = $request->user_or_page;

        if($user_or_page=='user'){
            $collaborations =
            Collaboration::where('col1_user_id',$account_id)
                            ->orWhere('col2_user_id',$account_id)
                            ->get();
            foreach ($collaborations as $key => $collaboration) {
                if($collaboration->col1_user_id==$account_id){
                    if($collaboration->col1_show){
                        if($collaboration->col1_confirmed){
                            if($collaboration->col2_user_id){
                                $collaboration['account'] = User::where('id',$collaboration->col2_user_id)
                                ->select('users.id','users.image','users.name', 'users.surname')
                                ->first();
                            }
                            if($collaboration->col2_page_id){
                                $collaboration['account'] = Page::where('id',$collaboration->col2_page_id)
                                ->select('pages.id','pages.image','pages.name')->first();
                            }
                        }else{
                            unset($collaborations[$key]);
                        }
                    }else{
                        unset($collaborations[$key]);
                    }
                }
                if($collaboration->col2_user_id==$account_id){
                    if($collaboration->col2_show){
                        if($collaboration->col2_confirmed){
                            if($collaboration->col1_user_id){
                                $collaboration['account'] =
                                User::where('id',$collaboration->col1_user_id)
                                ->select('users.id','users.image','users.name', 'users.surname')
                                ->first();
                            }
                            if($collaboration->col1_page_id){
                                $collaboration['account'] = Page::where('id',$collaboration->col1_page_id)
                                ->select('pages.id','pages.image','pages.name')->first();
                            }
                        }else{
                            unset($collaborations[$key]);
                        }
                    }else{
                        unset($collaborations[$key]);
                    }
                }
            }
        }elseif($user_or_page=='page'){
            $collaborations =
            Collaboration::where('col1_page_id',$account_id)
                            ->orWhere('col2_page_id',$account_id)
                            ->get();
            foreach ($collaborations as $key => $collaboration) {
                if($collaboration->col1_page_id==$account_id){
                    if($collaboration->col1_show){
                        if($collaboration->col1_confirmed){
                            if($collaboration->col2_user_id){
                                $collaboration['account'] = User::where('id',$collaboration->col2_user_id)
                                ->select('users.id','users.image','users.name', 'users.surname')
                                ->first();
                            }
                            if($collaboration->col2_page_id){
                                $collaboration['account'] = Page::where('id',$collaboration->col2_page_id)
                                ->select('pages.id','pages.image','pages.name')->first();
                            }
                        }else{
                            unset($collaborations[$key]);
                        }
                    }else{
                        unset($collaborations[$key]);
                    }
                }
                if($collaboration->col2_page_id==$account_id){
                    if($collaboration->col2_show){
                        if($collaboration->col2_confirmed){
                            if($collaboration->col1_user_id){
                                $collaboration['account'] =
                                User::where('id',$collaboration->col1_user_id)
                                ->select('users.id','users.image','users.name', 'users.surname')
                                ->first();
                            }
                            if($collaboration->col1_page_id){
                                $collaboration['account'] = Page::where('id',$collaboration->col1_page_id)
                                ->select('pages.id','pages.image','pages.name')->first();
                            }
                        }else{
                            unset($collaborations[$key]);
                        }
                    }else{
                        unset($collaborations[$key]);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'results' => [
                'collaborations' => array(...$collaborations),
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
            Collaboration::where('col1_user_id',$account_id)
                            ->orWhere('col2_user_id',$account_id)
                            ->get();
            foreach ($collaborations as $key => $collaboration) {
                if($collaboration->col1_user_id==$account_id){
                    if($collaboration->col1_show){
                        if(!$collaboration->col1_confirmed){
                            if($collaboration->col2_user_id){
                                $collaboration['account'] = User::where('id',$collaboration->col2_user_id)
                                ->select('users.id','users.image','users.name', 'users.surname')
                                ->first();
                            }
                            if($collaboration->col2_page_id){
                                $collaboration['account'] = Page::where('id',$collaboration->col2_page_id)
                                ->select('pages.id','pages.image','pages.name')->first();
                            }
                        }else{
                            unset($collaborations[$key]);
                        }
                    }else{
                        unset($collaborations[$key]);
                    }
                }
                if($collaboration->col2_user_id==$account_id){
                    if($collaboration->col2_show){
                        if(!$collaboration->col2_confirmed){
                            if($collaboration->col1_user_id){
                                $collaboration['account'] =
                                User::where('id',$collaboration->col1_user_id)
                                ->select('users.id','users.image','users.name', 'users.surname')
                                ->first();
                            }
                            if($collaboration->col1_page_id){
                                $collaboration['account'] = Page::where('id',$collaboration->col1_page_id)
                                ->select('pages.id','pages.image','pages.name')->first();
                            }
                        }else{
                            unset($collaborations[$key]);
                        }
                    }else{
                        unset($collaborations[$key]);
                    }
                }
            }
        }elseif($user_or_page=='page'){
            $collaborations =
            Collaboration::where('col1_page_id',$account_id)
                            ->orWhere('col2_page_id',$account_id)
                            ->get();
            foreach ($collaborations as $key => $collaboration) {
                if($collaboration->col1_page_id==$account_id){
                    if($collaboration->col1_show){
                        if(!$collaboration->col1_confirmed){
                            if($collaboration->col2_user_id){
                                $collaboration['account'] = User::where('id',$collaboration->col2_user_id)
                                ->select('users.id','users.image','users.name', 'users.surname')
                                ->first();
                            }
                            if($collaboration->col2_page_id){
                                $collaboration['account'] = Page::where('id',$collaboration->col2_page_id)
                                ->select('pages.id','pages.image','pages.name')->first();
                            }
                        }else{
                            unset($collaborations[$key]);
                        }
                    }else{
                        unset($collaborations[$key]);
                    }
                }
                if($collaboration->col2_page_id==$account_id){
                    if($collaboration->col2_show){
                        if(!$collaboration->col2_confirmed){
                            if($collaboration->col1_user_id){
                                $collaboration['account'] =
                                User::where('id',$collaboration->col1_user_id)
                                ->select('users.id','users.image','users.name', 'users.surname')
                                ->first();
                            }
                            if($collaboration->col1_page_id){
                                $collaboration['account'] = Page::where('id',$collaboration->col1_page_id)
                                ->select('pages.id','pages.image','pages.name')->first();
                            }
                        }else{
                            unset($collaborations[$key]);
                        }
                    }else{
                        unset($collaborations[$key]);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'results' => [
                'collaborations' => array(...$collaborations),
            ]
        ]);
    }

    public function getRecommendedCollaborations(Request $request) {

        $request->validate([
            'account_id' => 'required|integer',
            'user_or_page' => 'required|string',
        ]);

        $account_id = $request->account_id;
        $user_or_page = $request->user_or_page;

        if($user_or_page=='user'){
            $collaborations =
            Collaboration::where([
                                ['col1_user_id', '=', $account_id],
                                ['col1_show', '=', null],
                                ['col2_show', '=', null],
                            ])
                            ->orWhere([
                                ['col2_user_id', '=', $account_id],
                                ['col1_show', '=', null],
                                ['col2_show', '=', null],
                            ])
                            ->get();
            foreach ($collaborations as $key => $collaboration) {
                if($collaboration->col1_user_id==$account_id){
                    if($collaboration->col2_user_id){
                        $collaboration['account'] = User::where('id',$collaboration->col2_user_id)
                        ->select('users.id','users.image','users.name', 'users.surname')
                        ->first();
                    }
                    if($collaboration->col2_page_id){
                        $collaboration['account'] = Page::where('id',$collaboration->col2_page_id)
                        ->select('pages.id','pages.image','pages.name')->first();
                    }
                }
                if($collaboration->col2_user_id==$account_id){
                    if($collaboration->col1_user_id){
                        $collaboration['account'] =
                        User::where('id',$collaboration->col1_user_id)
                        ->select('users.id','users.image','users.name', 'users.surname')
                        ->first();
                    }
                    if($collaboration->col1_page_id){
                        $collaboration['account'] = Page::where('id',$collaboration->col1_page_id)
                        ->select('pages.id','pages.image','pages.name')->first();
                    }
                }
            }
        }elseif($user_or_page=='page'){
            $collaborations =
            Collaboration::where([
                                ['col1_page_id', '=', $account_id],
                                ['col1_show', '=', null],
                                ['col2_show', '=', null],
                            ])
                            ->orWhere([
                                ['col2_page_id', '=', $account_id],
                                ['col1_show', '=', null],
                                ['col2_show', '=', null],
                            ])
                            ->get();
            foreach ($collaborations as $key => $collaboration) {
                if($collaboration->col1_page_id==$account_id){
                    if($collaboration->col2_user_id){
                        $collaboration['account'] = User::where('id',$collaboration->col2_user_id)
                        ->select('users.id','users.image','users.name', 'users.surname')
                        ->first();
                    }
                    if($collaboration->col2_page_id){
                        $collaboration['account'] = Page::where('id',$collaboration->col2_page_id)
                        ->select('pages.id','pages.image','pages.name')->first();
                    }
                }
                if($collaboration->col2_page_id==$account_id){
                    if($collaboration->col1_user_id){
                        $collaboration['account'] =
                        User::where('id',$collaboration->col1_user_id)
                        ->select('users.id','users.image','users.name', 'users.surname')
                        ->first();
                    }
                    if($collaboration->col1_page_id){
                        $collaboration['account'] = Page::where('id',$collaboration->col1_page_id)
                        ->select('pages.id','pages.image','pages.name')->first();
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'results' => [
                'collaborations' => array(...$collaborations),
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
            'hidden'=> 'nullable',
        ]);
        $sender_id = $request->sender_id;
        $sender_user_or_page = $request->sender_user_or_page;
        $recipient_id = $request->recipient_id;
        $recipient_user_or_page = $request->recipient_user_or_page;

        $user = Auth::user();
        $can_create_coll = false;

        $query_1 = Collaboration::query();
        if($sender_user_or_page=='user'){
            $query_1->where('col1_user_id',$sender_id);
            if($user->id==$sender_id){
                $can_create_coll = true;
            }
        }
        if($sender_user_or_page=='page'){
            $query_1->where('col1_page_id',$sender_id);
            if($user->pages->contains(Page::find($sender_id))){
                $can_create_coll = true;
            }
        }
        if($recipient_user_or_page=='user'){
            $query_1->where('col2_user_id',$recipient_id);
        }
        if($recipient_user_or_page=='page'){
            $query_1->where('col2_page_id',$recipient_id);
        }
        $already_exist_1 = $query_1->first();

        $query_2 = Collaboration::query();
        if($recipient_user_or_page=='user'){
            $query_2->where('col1_user_id',$recipient_id);
        }
        if($recipient_user_or_page=='page'){
            $query_2->where('col1_page_id',$recipient_id);
        }
        if($sender_user_or_page=='user'){
            $query_2->where('col2_user_id',$sender_id);
        }
        if($sender_user_or_page=='page'){
            $query_2->where('col2_page_id',$sender_id);
        }
        $already_exist_2 = $query_2->first();

        if($can_create_coll){
            if(!$already_exist_1 && !$already_exist_2){
                $new_coll = new Collaboration();

                if($sender_user_or_page=='user'){
                    $new_coll->col1_user_id = $sender_id;
                }else{
                    $new_coll->col1_page_id = $sender_id;
                }

                if($recipient_user_or_page=='user'){
                    $new_coll->col2_user_id = $recipient_id;
                    //NOTIFICA al utente ricevente
                    if(!$request->hidden){
                        $new_notf = new Notification();
                        $new_notf->user_id = $recipient_id;
                        $new_notf->notification_type_id = 10;
                        $new_notf->ref_user_id = $sender_id;
                        $new_notf->ref_page_id = null;
                        $new_notf->parameter = $recipient_id.'/user';
                        $new_notf->save();
                    }
                }else{
                    $new_coll->col2_page_id = $recipient_id;
                    //NOTIFICA agli utenti che gestiscono la pagina ricevente
                    if(!$request->hidden){
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
                }
                //in caso di collaborazione generata automaticamente da messaggi
                if($request->hidden){
                    $new_coll->col1_show = null;
                    $new_coll->col2_show = null;
                }else{
                    $new_coll->col1_confirmed = 1;
                }
                $new_coll->save();
            }else{
                //se voglio creare una collaborazione gia esiste viene confermata e mostrata in automatico
                if(!$request->hidden){
                    if($already_exist_1){
                        if($sender_user_or_page=='user'){
                            if($already_exist_1->col1_user_id==$sender_id){
                                $already_exist_1->col1_confirmed = 1;
                                $already_exist_1->col1_show = 1;
                            }
                            if($already_exist_1->col2_user_id==$sender_id){
                                $already_exist_1->col2_confirmed = 1;
                                $already_exist_1->col2_show = 1;
                            }
                        }else{
                            if($already_exist_1->col1_page_id==$sender_id){
                                $already_exist_1->col1_confirmed = 1;
                                $already_exist_1->col1_show = 1;
                            }
                            if($already_exist_1->col2_page_id==$sender_id){
                                $already_exist_1->col2_confirmed = 1;
                                $already_exist_1->col2_show = 1;
                            }
                        }
                        $already_exist_1->update();
                    }
                    if($already_exist_2){
                        if($recipient_user_or_page=='user'){
                            if($already_exist_2->col1_user_id==$recipient_id){
                                $already_exist_2->col2_confirmed = 1;
                                $already_exist_2->col2_show = 1;
                            }
                            if($already_exist_2->col2_user_id==$recipient_id){
                                $already_exist_2->col1_confirmed = 1;
                                $already_exist_2->col1_show = 1;
                            }
                        }else{
                            if($already_exist_2->col1_page_id==$recipient_id){
                                $already_exist_2->col2_confirmed = 1;
                                $already_exist_2->col2_show = 1;
                            }
                            if($already_exist_2->col2_page_id==$recipient_id){
                                $already_exist_2->col1_confirmed = 1;
                                $already_exist_2->col1_show = 1;
                            }
                        }
                        $already_exist_2->update();
                    }
                }            
            }
        }
    }

    public function deleteCollaboration(Request $request)
    {
        $request->validate([
            'collaboration_id' => 'required|integer',
            'account_id' => 'required|integer',
            'user_or_page' => 'required|string',
        ]);
        $account_id = $request->account_id;
        $user_or_page = $request->user_or_page;
        $collaboration = Collaboration::find($request->collaboration_id);
        $user = Auth::user();
        $can_update_coll = false;

        if($user_or_page=='user'){
            if($user->id==$account_id){
                $can_update_coll = true;
                if($collaboration->col1_user_id==$account_id){
                    $collaboration->col1_show = null;
                }
                if($collaboration->col2_user_id==$account_id){
                    $collaboration->col2_show = null;
                }
            }
        }elseif($user_or_page=='page'){
            if($user->pages->contains(Page::find($account_id))){
                $can_update_coll = true;
                if($collaboration->col1_page_id==$account_id){
                    $collaboration->col1_show = null;
                }
                if($collaboration->col2_page_id==$account_id){
                    $collaboration->col2_show = null;
                }
            }
        }
        if($can_update_coll){
            if(!$collaboration->col1_show && !$collaboration->col2_show){
                $collaboration->delete();
            }else{
                $collaboration->update();
            }
        }
    }

    public function confirmCollaboration(Request $request)
    {
        $request->validate([
            'collaboration_id' => 'required|integer',
            'account_id' => 'required|integer',
            'user_or_page' => 'required|string',
        ]);

        function id_from_my_to_you($collaboration,$account_id,$user_or_page){

            if($collaboration->col1_user_id &&
                $collaboration->col1_user_id!=$account_id){
                    return  [
                            'user_or_page'=>'user',
                            'account_id'=>$collaboration->col1_user_id,
                        ];
            }
            if($collaboration->col2_user_id &&
                $collaboration->col2_user_id!=$account_id){
                    return  [
                            'user_or_page'=>'user',
                            'account_id'=>$collaboration->col2_user_id,
                        ];
            }
            if($collaboration->col1_page_id &&
                $collaboration->col1_page_id!=$account_id){
                    return  [
                            'user_or_page'=>'page',
                            'account_id'=>$collaboration->col1_page_id,
                        ];
            }
            if($collaboration->col2_page_id &&
                $collaboration->col2_page_id!=$account_id){
                    return  [
                            'user_or_page' => 'page',
                            'account_id'=>$collaboration->col2_page_id,
                        ];
            }
        }

        function send_notification($my_user_or_page,$my_account_id,$your_user_or_page,$your_account_id){
            if($your_user_or_page=='user'){
                //NOTIFICA
                $new_notf = new Notification();
                $new_notf->user_id = $your_account_id;
                $new_notf->notification_type_id = 12;
                if($my_user_or_page=='user'){
                    $new_notf->ref_user_id = $my_account_id;
                }else{
                    $new_notf->ref_page_id = $my_account_id;
                }
                $new_notf->parameter = $my_account_id.'/#collaborations';
                $new_notf->save();
            }else{
                $page_recipent = Page::find($your_account_id);
                foreach ($page_recipent->users as $user) {
                    $new_notf = new Notification();
                    $new_notf->user_id = $user->id;
                    $new_notf->notification_type_id = 13;
                    if($my_user_or_page=='user'){
                        $new_notf->ref_user_id = $my_account_id;
                    }else{
                        $new_notf->ref_page_id = $my_account_id;
                    }
                    $new_notf->ref_to_page_id = $your_account_id;
                    $new_notf->parameter = $my_account_id.'/#collaborations';
                    $new_notf->save();
                }
            }

        }

        $account_id = $request->account_id;
        $user_or_page = $request->user_or_page;
        $collaboration = Collaboration::find($request->collaboration_id);
        $user = Auth::user();
        $can_update_coll = false;

        if($user_or_page=='user'){
            if($user->id==$account_id){
                $can_update_coll = true;
                if($collaboration->col1_user_id==$account_id){
                    $collaboration->col1_confirmed = 1;
                    $collaboration->col1_show = 1;
                }
                if($collaboration->col2_user_id==$account_id){
                    $collaboration->col2_confirmed = 1;
                    $collaboration->col2_show = 1;
                }
            }
        }elseif($user_or_page=='page'){
            if($user->pages->contains(Page::find($account_id))){
                $can_update_coll = true;
                if($collaboration->col1_page_id==$account_id){
                    $collaboration->col1_confirmed = 1;
                    $collaboration->col1_show = 1;
                }
                if($collaboration->col2_page_id==$account_id){
                    $collaboration->col2_confirmed = 1;
                    $collaboration->col2_show = 1;
                }
            }
        }
        if($can_update_coll){
            $collaboration->update();
        }

        $you = id_from_my_to_you($collaboration,$account_id,$user_or_page);
        send_notification($user_or_page,$account_id,$you['user_or_page'],$you['account_id']);
    }

    public function latestCollaborations(){

        $collaborations = Collaboration::query()
                            ->where('col1_confirmed',1)
                            ->where('col2_confirmed',1)
                            ->latest()
                            ->take(8)
                            ->get();

        foreach ($collaborations as $collaboration) {
            if($collaboration->col1_user_id){
                $collaboration['account_1'] =
                User::where('id',$collaboration->col1_user_id)
                ->select('id','name','surname','image','summary')
                ->first();
                $collaboration['account_1']['user_or_page'] = true;
            }
            if($collaboration->col1_page_id){
                $collaboration['account_1'] =
                Page::where('id',$collaboration->col1_page_id)
                ->select('id','name','image','summary')
                ->first();
                $collaboration['account_1']['user_or_page'] = false;
            }
            if($collaboration->col2_user_id){
                $collaboration['account_2'] =
                User::where('id',$collaboration->col2_user_id)
                ->select('id','name','surname','image','summary')
                ->first();
                $collaboration['account_2']['user_or_page'] = true;
            }
            if($collaboration->col2_page_id){
                $collaboration['account_2'] =
                Page::where('id',$collaboration->col2_page_id)
                ->select('id','name','image','summary')
                ->first();
                $collaboration['account_2']['user_or_page'] = false;
            }
        }
        return response()->json([
            'success' => true,
            'results' => [
                'collaborations' => $collaborations,
            ]
        ]);
    }

}
