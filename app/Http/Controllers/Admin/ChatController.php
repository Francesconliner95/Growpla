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

        $user = Auth::user();
        $user_chats_sender = $user->chats_sender()->join('users','users.id','=','chats.recipient_user_id')
        ->select('chats.id','users.id as user_id','users.name','users.surname','chats.updated_at')
        ->get();
        $user_chats_recipient = $user->chats_recipient()->join('users','users.id','=','chats.sender_user_id')
        ->select('chats.id','users.id as user_id','users.name','users.surname','chats.updated_at')
        ->get();
        $user_chats = $user_chats_sender->merge($user_chats_recipient);
        $my_user_chats = Auth::user()->select('users.id','users.name','users.surname')->first();
        $my_user_chats['user_chats'] = $user_chats;


        $my_pages_chats = $user->pages()->select('pages.id','pages.name')->get();
        foreach ($my_pages_chats as $my_page) {
            $page_chats_sender = $my_page->chats_sender()->join('pages','pages.id','=','chats.recipient_page_id')
            ->select('chats.id','pages.id as page_id','pages.name','chats.updated_at')
            ->get();
            $page_chats_recipient = $my_page->chats_recipient()->join('pages','pages.id','=','chats.sender_page_id')
            ->select('chats.id','pages.id as page_id','pages.name','chats.updated_at')
            ->get();
            $page_chats = $page_chats_sender->merge($page_chats_recipient);
            $my_page['page_chats'] = $page_chats;
        }

        $data = [
            'my_user_chats' => $my_user_chats,
            'my_pages_chats' => $my_pages_chats,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.chats.index', $data);
    }

    public function show(Chat $chat)
    {
        $user = Auth::user();
        if($chat->sender_user_id==$user->id || $chat->recipient_user_id==$user->id){

            $messages = $chat->messages;

            if($chat->sender_user_id==$user->id){
                $my_id = $chat->sender_user_id;
                $your_id = $chat->recipient_user_id;
                $user_displayed = User::find($your_id);
            }elseif($chat->recipient_user_id==$user->id){
                $my_id = $chat->recipient_user_id;
                $your_id = $chat->sender_user_id;
                $user_displayed = User::find($your_id);
            }
            $name = $user_displayed->name;
            $surname = $user_displayed->surname;
            $displayed_name = $name.' '.$surname;

            $data = [
                'messages' => $messages,
                'chat' => $chat,
                'my_id' => $my_id,
                'your_id' => $your_id,
                'displayed_name' => $displayed_name,
            ];

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            return view('admin.chats.show', $data);

        }abort(404);

    }

}
