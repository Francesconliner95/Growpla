<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\Chat;
use App\Message;
use App\User;
use App\FilterMail;
use App\Mail\MailMessage;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function newMessage(Request $request){

        $request->validate([
            'chat_id' => 'required|integer',
            'message_text' => 'required|min:1',
        ]);

        $chat_id = $request->chat_id;
        $message_text = $request->message_text;

        $chat = Chat::find($chat_id);

        if($chat->account1_id==Auth::user()->account_id
        || $chat->account2_id==Auth::user()->account_id){

            $new_message = new Message();
            $new_message->chat_id = $chat_id;
            $new_message->sender_account_id = Auth::user()->account_id;

            if($chat->account1_id==Auth::user()->account_id){
                $recipient_account_id = $chat->account2_id;
            }else{
                $recipient_account_id = $chat->account1_id;
            }

            $new_message->recipient_account_id = $recipient_account_id;
            $new_message->message = $message_text;
            $new_message->save();

            $chat->touch();//aggiorna solo updated_at

            //MAIL
            $not_send =
            FilterMail::where('account_id',$recipient_account_id)
            ->where('filter_type_id',1)->first();
            // 1 per i 'messaggi'

            if(!$not_send){
                $recipient_account = Account::find($recipient_account_id);
                $reacipient_mail = User::find($recipient_account->user_id)->email;
                $sender_name = Account::find(Auth::user()->account_id)->name;

                $data = [
                    'message' => $message_text,
                    'sender_name' => $sender_name,
                    'chat_id' => $chat->id,
                ];

                Mail::to($reacipient_mail)->queue(new MailMessage($data));
            }

            return response()->json([
                'success' => true,
                'results' => [
                    'message' => $new_message,
                ]
            ]);

        }
    }

    public function getMessages(Request $request){

        $request->validate([
            'chat_id' => 'required|integer',
            'messages_qty' => 'required|integer',
        ]);

        $chat_id = $request->chat_id;
        $messages_qty = $request->messages_qty;

        $chat = Chat::find($chat_id);

        if($chat->account1_id==Auth::user()->account_id
        || $chat->account2_id==Auth::user()->account_id){

            $messages = Message::where('chat_id',$chat_id)
                                ->latest()
                                // ->take(20)
                                ->get();    

            return response()->json([
                'success' => true,
                'results' => [
                    'messages' => $messages,
                ]
            ]);

        }
    }

    public function updateMessages(Request $request){

        $request->validate([
            'notReadedMessagesId' => 'required',
        ]);

        $notReadedMessagesId = $request->notReadedMessagesId;

        $messages = Message::find($notReadedMessagesId);

        foreach ($messages as $message) {
            if($message->recipient_account_id==Auth::user()->account_id){

                    $message->readed = 1;
                    $message->update();

            }
        }
    }

    public function getMessagesCount(){

        $account_id = Auth::user()->account_id;
        $message_not_read = Message::where('recipient_account_id',$account_id)
        ->where('readed',null)->count();

        return response()->json([
            'success' => true,
            'results' => [
                'message_not_read' => $message_not_read,
            ]
        ]);

    }


}
