<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\Chat;
use App\FilterMessage;
use App\AccountType;
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
        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account2_id = $request->account_id;

        $account1_id = Auth::user()->account_id;

        $already_exist_1 = Chat::where('account1_id',$account1_id)
                                ->Where('account2_id',$account2_id)
                                ->first();

        $already_exist_2 = Chat::where('account1_id',$account2_id)
                                ->Where('account2_id',$account1_id)
                                ->first();

        $account1 = Account::find($account1_id);
        $account2 = Account::find($account2_id);

        $canSend = true;

        if($already_exist_1){
            $already_exist = $already_exist_1;
        }elseif($already_exist_2){
            $already_exist = $already_exist_2;
        }else{
            $already_exist = false;

            //Se la chat non esiste vedo se è possibile crearne una
            $filter_messages = FilterMessage::where('account_id',$account2_id)
            ->get();

            foreach ($filter_messages as $filter_message) {
                if($account1->account_type_id==1){
                    //se sono una startip verifico la fase in cui mi trovo
                    if($filter_message->startup_state_id==$account1->startup_status_id){
                        $canSend = false;
                    }
                }else{
                    if($filter_message->account_type_id==$account1->account_type_id){
                        $canSend = false;
                    }
                }
            }
        }



        if(Auth::user()->account_id && !$already_exist && $canSend){

            $new_chat = new Chat();
            $new_chat->account1_id = $account1_id;
            $new_chat->account2_id = $account2_id;
            $new_chat->save();

            $chat_id = $new_chat->id;

        }elseif(Auth::user()->account_id && $already_exist && $canSend){

            $chat_id = $already_exist->id;

        }else{

            $chat_id = 'Non poi avviare una conversazione con questo account';

        }

        return response()->json([
            'success' => true,
            'results' => [
                'chat_id' => $chat_id,
            ]
        ]);

    }

    public function getChats(){

        $account = Account::where('user_id', Auth::user()->id)->first();

        if($account){
            $chats = Chat::where('account1_id', $account->id)
                            ->orWhere('account2_id',$account->id)
                            ->orderBy('updated_at', 'desc')
                            ->get();

            $accountTypes =  AccountType::all();

            foreach ($chats as $chat) {

                if($account->id==$chat->account1_id){

                    $account_chat = Account::find($chat->account2_id);

                }elseif($account->id==$chat->account2_id){

                    $account_chat = Account::find($chat->account1_id);

                }

                $message_not_read = Message::where('chat_id',$chat->id)
                ->where('recipient_account_id',$account->id)
                ->where('readed',null)->count();



                $chat['name'] = $account_chat->name;
                $chat['account_type'] =
                $accountTypes[$account_chat->account_type_id-1]->name;
                $chat['message_not_read'] = $message_not_read;

            }

            return response()->json([
                'success' => true,
                'results' => [
                    'chats' => $chats,
                ]
            ]);
        }abort(404);
    }

    public function index()
    {
        $account = Account::where('user_id', Auth::user()->id)->first();

        if($account){

            $chats = Chat::where('account1_id', $account->id)
                            ->orWhere('account2_id',$account->id)
                            ->orderBy('updated_at', 'desc')
                            ->get();

            $accountTypes =  AccountType::all();

            foreach ($chats as $chat) {

                if($account->id==$chat->account1_id){

                    $account_chat = Account::find($chat->account2_id);

                }elseif($account->id==$chat->account2_id){

                    $account_chat = Account::find($chat->account1_id);

                }

                $message_not_read = Message::where('chat_id',$chat->id)
                ->where('recipient_account_id',$account->id)
                ->where('readed',null)->count();



                $chat['name'] = $account_chat->name;
                $chat['account_type_name'] =
                $accountTypes[$account_chat->account_type_id-1]->name;
                $chat['account_type_name_en'] =
                $accountTypes[$account_chat->account_type_id-1]->name_en;
                $chat['message_not_read'] = $message_not_read;

            }

            $data = [
                'chats' => $chats,
            ];

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            return view('admin.chats.index', $data);
        }abort(404);
    }

    public function show(Chat $chat)
    {

        if($chat->account1_id==Auth::user()->account_id
        || $chat->account2_id==Auth::user()->account_id){

            if($chat->account1_id==Auth::user()->account_id){
                $your_account = Account::where('id',$chat->account2_id)
                ->select('accounts.id','accounts.name')->first();
            }else{
                $your_account = Account::where('id',$chat->account1_id)
                ->select('accounts.id','accounts.name')->first();
            }

            $messages = Message::where('chat_id',$chat->id)->get();

            foreach ($messages as $message) {
                if($message->recipient_account_id==Auth::user()->account_id){
                        $message->readed = 1;
                        $message->update();
                }
            }

            $data = [
                'my_account_id' => Auth::user()->account_id,
                'your_account' => $your_account,
                'chat_id' => $chat->id,
            ];

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            return view('admin.chats.show', $data);
        }abort(404);

    }

}
