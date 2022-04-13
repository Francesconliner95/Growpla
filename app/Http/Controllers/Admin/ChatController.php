<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Chat;
use App\FilterMessage;
use App\Message;
use App\Language;
use App\Page;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function createChat(Request $request)
    {
        $request->validate([
            'recipient_id'=> 'required|integer',
            'recipient_user_or_page' => 'required|string',
            'page_selected_id' => 'nullable|integer',
        ]);

        $recipient_id = $request->recipient_id;
        $recipient_user_or_page = $request->recipient_user_or_page;
        $page_selected_id = $request->page_selected_id;

        //dd($id,$user_or_page);

        $user = Auth::user();
        //ho selezionato il mio utente
        if(!$page_selected_id){
            //voglio inviare un messaggio ad un utente
            if ($recipient_user_or_page=='user') {
                $user_id = $user->id;
                $chat = Chat::where(function ($query) use ($user_id) {
                            $query->where('sender_user_id', '=', $user_id)
                                  ->orWhere('recipient_user_id', '=', $user_id);
                        })->where(function ($query) use ($recipient_id) {
                            $query->where('sender_user_id', '=', $recipient_id)
                                  ->orWhere('recipient_user_id', '=', $recipient_id);
                        })->first();
            //voglio inviare un messaggio ad una pagina
        }elseif($recipient_user_or_page=='page'){
                $user_id = $user->id;
                $chat = Chat::where(function ($query) use ($user_id) {
                            $query->where('sender_user_id', '=', $user_id)
                                  ->orWhere('recipient_user_id', '=', $user_id);
                        })->where(function ($query) use ($recipient_id) {
                            $query->where('sender_page_id', '=', $recipient_id)
                                  ->orWhere('recipient_page_id', '=', $recipient_id);
                        })->first();
                //dd($recipient_id);
                //dd($chat);
            }
            $page_id = 'user';
        }else {//ho selezionato una mia pagina
            //voglio inviare un messaggio ad un utente
            if ($recipient_user_or_page=='user') {
                $page_selected_id = $page_selected_id;
                $chat = Chat::where(function ($query) use ($page_selected_id){
                            $query->where('sender_page_id', '=', $page_selected_id)
                                  ->orWhere('recipient_page_id', '=', $page_selected_id);
                        })->where(function ($query) use ($recipient_id) {
                            $query->where('sender_user_id', '=', $recipient_id)
                                  ->orWhere('recipient_user_id', '=', $recipient_id);
                        })->first();

            //voglio inviare un messaggio ad una pagina
        }elseif($recipient_user_or_page=='page'){
                $page_selected_id = $page_selected_id;
                $chat = Chat::where(function ($query) use ($page_selected_id){
                            $query->where('sender_page_id', '=', $page_selected_id)
                                  ->orWhere('recipient_page_id', '=', $page_selected_id);
                        })->where(function ($query) use ($recipient_id) {
                            $query->where('sender_page_id', '=', $recipient_id)
                                  ->orWhere('recipient_page_id', '=', $recipient_id);
                        })->first();
            }
            $page_id = $page_selected_id;
        }

        if($chat){

            // return redirect()->route('admin.chats.show',[$chat->id,$page_id]);

            return response()->json([
                'success' => true,
                'results' => [
                    'route' => '/admin/chats/show/'.$chat->id.'/'.$page_id,
                ]
            ]);
        }else{

            $new_chat = new Chat();
            if(!$page_selected_id){
                $new_chat->sender_user_id = $user->id;
                $page_id = 'user';
            }else {
                $new_chat->sender_page_id = $page_selected_id;
                $page_id = $page_selected_id;
            }
            if($recipient_user_or_page=='user'){
                $new_chat->recipient_user_id = $recipient_id;

            }elseif($recipient_user_or_page=='page'){
                $new_chat->recipient_page_id = $recipient_id;
            }
            $new_chat->save();

            // return redirect()->route('admin.chats.show',[$new_chat->id,$page_id]);
            return response()->json([
                'success' => true,
                'results' => [
                    'route' => '/admin/chats/show/'.$new_chat->id.'/'.$page_id,
                ]
            ]);
        }

    }

    public function index()
    {

        function message_not_read($chat,$my_id,$user_or_page){
            //se io sono un utente
            if($user_or_page=='user'){
                //tutti i messaggi della chat con utenti diversi sal mio
                $not_readed1 = Message::where('chat_id',$chat->id)
                                    ->where('readed',null)
                                    ->where('sender_user_id','!=',$my_id)
                                    ->count();
                //tutti i messaggi della chat senza utenti cosi prendo le pagine
                $not_readed2 = Message::where('chat_id',$chat->id)
                                    ->where('readed',null)
                                    ->where('sender_user_id',null)
                                    ->count();
            }

            if($user_or_page=='page'){
                //tutti i messaggi della chat con pagine diverse dalla mia
                $not_readed1 = Message::where('chat_id',$chat->id)
                                      ->where('readed',null)
                                      ->where('sender_page_id','!=',$my_id)
                                      ->count();
                //tutti i messaggi della chat senza pagine cosi prendo gli utenti
                $not_readed2 = Message::where('chat_id',$chat->id)
                                      ->where('readed',null)
                                      ->where('sender_page_id',null)
                                      ->count();
            }

            $not_readed = $not_readed1 + $not_readed2;
            return $not_readed;
        }

        $user = Auth::user();
        $from_my_user_to_user = $user->chats_sender()
        ->where('chats.recipient_user_id','!=',null)
        ->join('users','users.id','=','chats.recipient_user_id')
        ->select('chats.id','users.id as user_id','users.name','users.surname','chats.updated_at')
        ->get();
        $from_my_user_to_page = $user->chats_sender()
        ->where('chats.recipient_page_id','!=',null)
        ->join('pages','pages.id','=','chats.recipient_page_id')
        ->select('chats.id','pages.id as page_id','pages.name','chats.updated_at')
        ->get();
        $from_user_to_my_user = $user->chats_recipient()
        ->where('chats.sender_user_id','!=',null)
        ->join('users','users.id','=','chats.sender_user_id')
        ->select('chats.id','users.id as user_id','users.name','users.surname','chats.updated_at')
        ->get();
        $from_page_to_my_user = $user->chats_recipient()
        ->where('chats.sender_page_id','!=',null)
        ->join('pages','pages.id','=','chats.sender_page_id')
        ->select('chats.id','pages.id as page_id','pages.name','chats.updated_at')
        ->get();
        $my_user_chats = User::where('id',Auth::user()->id)
                        ->select('id','name','surname')->first();
        $user_chats = $from_my_user_to_user
                      ->merge($from_my_user_to_page)
                      ->merge($from_user_to_my_user)
                      ->merge($from_page_to_my_user);
        foreach ($user_chats as $user_chat) {
            $user_chat['message_not_read'] = message_not_read($user_chat,$user->id,'user');
        }

        $my_user_chats['user_chats'] = $user_chats;

        $my_pages_chats = $user->pages()->select('pages.id','pages.name')->get();
        foreach ($my_pages_chats as $my_page) {
            $from_my_page_to_user = $my_page->chats_sender()
            ->where('chats.recipient_user_id','!=',null)
            ->join('users','users.id','=','chats.recipient_user_id')
            ->select('chats.id','users.id as user_id', 'users.name','users.surname','chats.updated_at')
            ->get();
            $from_my_page_to_page = $my_page->chats_sender()
            ->where('chats.recipient_page_id','!=',null)
            ->join('pages','pages.id','=','chats.recipient_page_id')
            ->select('chats.id','pages.id as page_id','pages.name','chats.updated_at')
            ->get();
            $from_user_to_my_page = $my_page->chats_recipient()
            ->where('chats.sender_user_id','!=',null)
            ->join('users','users.id','=','chats.sender_user_id')
            ->select('chats.id','users.id as user_id', 'users.name','users.surname','chats.updated_at')
            ->get();
            $from_page_to_my_page = $my_page->chats_recipient()
            ->where('chats.sender_page_id','!=',null)
            ->join('pages','pages.id','=','chats.sender_page_id')
            ->select('chats.id','pages.id as page_id','pages.name','chats.updated_at')
            ->get();

            $page_chats = $from_my_page_to_user
                          ->merge($from_my_page_to_page)
                          ->merge($from_user_to_my_page)
                          ->merge($from_page_to_my_page);

            foreach ($page_chats as $page_chat) {
                $page_chat['message_not_read'] = message_not_read($page_chat,$my_page->id,'page');
            }

            $my_page['page_chats'] = $page_chats;
        }

        $data = [
            'my_user_chats' => $my_user_chats,
            'my_pages_chats' => $my_pages_chats,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.chats.index', $data);
    }

    public function show($chat_id,$page_id)
    {

        $user = Auth::user();
        $chat = Chat::find($chat_id);
        $my_user_id = '';
        $my_page_id = '';
        $your_user_id = '';
        $your_page_id = '';

        if($page_id=='user'){
            //CHAT UTENTE
            if($chat->sender_user_id==$user->id || $chat->recipient_user_id==$user->id){

                $my_user_id = $user->id;

                if($chat->sender_user_id && $chat->sender_user_id!=$my_user_id){
                    $your_user_id = $chat->sender_user_id;
                }
                if($chat->recipient_user_id && $chat->recipient_user_id!=$my_user_id){
                    $your_user_id = $chat->recipient_user_id;
                }
                if($chat->sender_page_id){
                    $your_page_id = $chat->sender_page_id;
                }
                if($chat->recipient_page_id){
                    $your_page_id = $chat->recipient_page_id;
                }

            }//abort(404);
        }else{
            //CHAT PAGINA
            $page = Page::find($page_id);
            if($user->pages->contains($page)){
                if($chat->sender_page_id==$page->id || $chat->recipient_page_id==$page->id){

                    $my_page_id = $page_id;

                    if($chat->sender_user_id){
                        $your_user_id = $chat->sender_user_id;
                    }
                    if($chat->recipient_user_id){
                        $your_user_id = $chat->recipient_user_id;
                    }
                    if($chat->sender_page_id && $chat->sender_page_id!=$my_page_id){
                        $your_page_id = $chat->sender_page_id;
                    }
                    if($chat->recipient_page_id && $chat->recipient_page_id!=$my_page_id){
                        $your_page_id = $chat->recipient_page_id;
                    }

                }//abort(404);
            }//abort(404);
        }

        //dd($my_user_id,$your_user_id,$my_page_id,$your_page_id);
        if($your_user_id){
            $you = User::find($your_user_id);
            $name = $you->name;
            $surname = $you->surname;
            $displayed_name = $name.' '.$surname;
        }
        if ($your_page_id) {
            $you = Page::find($your_page_id);
            $displayed_name = $you->name;
        }

        $data = [
            'chat_id' => $chat->id,
            'my_user_id' => $my_user_id,
            'your_user_id' => $your_user_id,
            'my_page_id' => $my_page_id,
            'your_page_id' => $your_page_id,
            'displayed_name' => $displayed_name,
        ];


        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.chats.show', $data);

        //}abort(404);

    }

}
