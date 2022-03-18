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
        // $request->validate([
        //     'account_id' => 'required|integer',
        // ]);
        //
        // $account2_id = $request->account_id;
        //
        // $account1_id = Auth::user()->account_id;
        //
        // $already_exist_1 = Chat::where('account1_id',$account1_id)
        //                         ->Where('account2_id',$account2_id)
        //                         ->first();
        //
        // $already_exist_2 = Chat::where('account1_id',$account2_id)
        //                         ->Where('account2_id',$account1_id)
        //                         ->first();
        //
        // $account1 = Account::find($account1_id);
        // $account2 = Account::find($account2_id);
        //
        // $canSend = true;
        //
        // if($already_exist_1){
        //     $already_exist = $already_exist_1;
        // }elseif($already_exist_2){
        //     $already_exist = $already_exist_2;
        // }else{
        //     $already_exist = false;
        //
        //     //Se la chat non esiste vedo se è possibile crearne una
        //     $filter_messages = FilterMessage::where('account_id',$account2_id)
        //     ->get();
        //
        //     foreach ($filter_messages as $filter_message) {
        //         if($account1->account_type_id==1){
        //             //se sono una startip verifico la fase in cui mi trovo
        //             if($filter_message->startup_state_id==$account1->startup_status_id){
        //                 $canSend = false;
        //             }
        //         }else{
        //             if($filter_message->account_type_id==$account1->account_type_id){
        //                 $canSend = false;
        //             }
        //         }
        //     }
        // }
        //
        //
        //
        // if(Auth::user()->account_id && !$already_exist && $canSend){
        //
        //     $new_chat = new Chat();
        //     $new_chat->account1_id = $account1_id;
        //     $new_chat->account2_id = $account2_id;
        //     $new_chat->save();
        //
        //     $chat_id = $new_chat->id;
        //
        // }elseif(Auth::user()->account_id && $already_exist && $canSend){
        //
        //     $chat_id = $already_exist->id;
        //
        // }else{
        //
        //     $chat_id = 'Non poi avviare una conversazione con questo account';
        //
        // }
        //
        // return response()->json([
        //     'success' => true,
        //     'results' => [
        //         'chat_id' => $chat_id,
        //     ]
        // ]);

    }

    public function getChats(){

        // $account = Account::where('user_id', Auth::user()->id)->first();
        //
        // if($account){
        //     $chats = Chat::where('account1_id', $account->id)
        //                     ->orWhere('account2_id',$account->id)
        //                     ->orderBy('updated_at', 'desc')
        //                     ->get();
        //
        //     $accountTypes =  AccountType::all();
        //
        //     foreach ($chats as $chat) {
        //
        //         if($account->id==$chat->account1_id){
        //
        //             $account_chat = Account::find($chat->account2_id);
        //
        //         }elseif($account->id==$chat->account2_id){
        //
        //             $account_chat = Account::find($chat->account1_id);
        //
        //         }
        //
        //         $message_not_read = Message::where('chat_id',$chat->id)
        //         ->where('recipient_account_id',$account->id)
        //         ->where('readed',null)->count();
        //
        //
        //
        //         $chat['name'] = $account_chat->name;
        //         $chat['account_type'] =
        //         $accountTypes[$account_chat->account_type_id-1]->name;
        //         $chat['message_not_read'] = $message_not_read;
        //
        //     }
        //
        //     return response()->json([
        //         'success' => true,
        //         'results' => [
        //             'chats' => $chats,
        //         ]
        //     ]);
        // }abort(404);
    }

    public function index()
    {

        function message_not_read($chat,$my_id,$user_or_page){

            if($user_or_page=='user'){
              $not_readed1 = Message::where('chat_id',$chat->id)
                                    ->where('readed',null)
                                    ->where('sender_user_id','!=',$my_id)
                                    ->count();
              $not_readed2 = Message::where('chat_id',$chat->id)
                                    ->where('readed',null)
                                    ->where('sender_page_id',$my_id)
                                    ->count();
            }

            if($user_or_page=='page'){
                $not_readed1 = Message::where('chat_id',$chat->id)
                                      ->where('readed',null)
                                      ->where('sender_user_id',$my_id)
                                      ->count();
                $not_readed2 = Message::where('chat_id',$chat->id)
                                      ->where('readed',null)
                                      ->where('sender_page_id','!=',$my_id)
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
        $my_user_chats = Auth::user()->select('users.id','users.name','users.surname')->first();
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

        //dd($data);

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.chats.show', $data);

        //}abort(404);

    }

}
