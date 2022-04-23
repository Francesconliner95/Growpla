<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\Chat;
use App\Message;
use App\User;
use App\Page;
use App\UserMailSetting;
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
            'my_user_id' => 'nullable|integer',
            'my_page_id' => 'nullable|integer',
            'message_text' => 'required|min:1',
        ]);

        $chat_id = $request->chat_id;
        $my_user_id = $request->my_user_id;
        $my_page_id = $request->my_page_id;
        $message_text = $request->message_text;
        $user = Auth::user();
        $chat = Chat::find($chat_id);

        function newMessage($chat,$user_or_page,$my_user_id,$my_page_id,$message_text){

            $new_message = new Message();
            $new_message->chat_id = $chat->id;

            if($user_or_page == 'user'){
                $new_message->sender_user_id = $my_user_id;
                $sender = User::find($my_user_id);
                $sender['page_id'] = 'user';
            }elseif($user_or_page == 'page'){
                $new_message->sender_page_id = $my_page_id;
                $sender = Page::find($my_page_id);
                $sender['page_id'] = $sender->id;
            }

            if($chat->sender_user_id && $chat->sender_user_id!=$my_user_id){
                $new_message->recipient_user_id = $chat->sender_user_id;
                //$recipient_email = User::find($chat->sender_user_id)->email;
                $recipient_users = [User::find($chat->sender_user_id)];
            }
            if($chat->sender_page_id && $chat->sender_page_id!=$my_page_id){
                $new_message->recipient_page_id = $chat->sender_page_id;
                //$recipient_email = Page::find($chat->sender_page_id)->users->pluck('email');
                $recipient_users = Page::find($chat->sender_page_id)->users;
            }
            if($chat->recipient_user_id && $chat->recipient_user_id!=$my_user_id){
                $new_message->recipient_user_id = $chat->recipient_user_id;
                //$recipient_email = User::find($chat->recipient_user_id)->email;
                $recipient_users = [User::find($chat->recipient_user_id)];
            }
            if($chat->recipient_page_id && $chat->recipient_page_id!=$my_page_id){
                $new_message->recipient_page_id = $chat->recipient_page_id;
                //$recipient_email = Page::find($chat->recipient_page_id)->users->pluck('email');
                $recipient_users = Page::find($chat->recipient_page_id)->users;
            }

            $new_message->message = $message_text;
            $new_message->save();

            $chat->touch();//aggiorna solo updated_at

            //MAIL
            $data = [
                'message' => $message_text,
                'sender_name' => $sender->page_id=='user'?
                $sender->name.' '.$sender->surname:$sender->name,
                'chat_id' => $chat->id,
                'page_id' => $sender->page_id,
            ];

            $recipient_emails = [];
            foreach ($recipient_users as $recipient_user) {
                $exist = UserMailSetting::where('user_id',$recipient_user->id)
                                        ->where('mail_setting_id',1)
                                        ->first();
                if(!$exist){
                    array_push($recipient_emails,$recipient_user->email);
                }
            }
            if($recipient_emails){
                Mail::to($recipient_emails)->queue(new MailMessage($data));
            }

            return $new_message;
        }

        if($my_user_id){
            if($chat->sender_user_id==$user->id || $chat->recipient_user_id==$user->id){
                $new_message = newMessage($chat,'user',$my_user_id,$my_page_id,$message_text);
            }
        }elseif($my_page_id){
            $page = Page::find($my_page_id);
            if($user->pages->contains($page)){
                if($chat->sender_page_id==$page->id || $chat->recipient_page_id==$page->id){
                    $new_message = newMessage($chat,'page',$my_user_id,$my_page_id,$message_text);
                }
            }
        }

        return response()->json([
            'success' => true,
            'results' => [
                'message' => /*$new_message*/[],
            ]
        ]);

    }

    public function getMessages(Request $request){

        $request->validate([
            'chat_id' => 'required|integer',
            'my_user_id' => 'nullable|integer',
            'my_page_id' => 'nullable|integer',
            'messages_qty' => 'required|integer',
        ]);

        $chat_id = $request->chat_id;
        $my_user_id = $request->my_user_id;
        $my_page_id = $request->my_page_id;
        $messages_qty = $request->messages_qty;
        $user = Auth::user();
        $chat = Chat::find($chat_id);

        function getMessages($chat_id,$user_or_page,$my_id){

            $messages = Message::where('chat_id',$chat_id)
                        ->latest()
                        //->take(20)
                        ->get();

            //messaggi non letti segna come letti
            if($user_or_page=='user'){
                //tutti i messaggi della chat con utenti diversi sal mio
                $set_readed = Message::where('chat_id',$chat_id)
                                    ->where('readed',null)
                                    ->where('sender_user_id','!=',$my_id)
                                    ->update(['readed'=> 1]);
                //tutti i messaggi della chat senza utenti cosi prendo le pagine
                $set_readed = Message::where('chat_id',$chat_id)
                                    ->where('readed',null)
                                    ->where('sender_user_id',null)
                                    ->update(['readed'=> 1]);
            }
            if($user_or_page=='page'){
                //tutti i messaggi della chat con pagine diverse dalla mia
                $set_readed = Message::where('chat_id',$chat_id)
                                      ->where('readed',null)
                                      ->where('sender_page_id','!=',$my_id)
                                      ->update(['readed'=> 1]);
                //tutti i messaggi della chat senza pagine cosi prendo gli utenti
                $set_readed = Message::where('chat_id',$chat_id)
                                      ->where('readed',null)
                                      ->where('sender_page_id',null)
                                      ->update(['readed'=> 1]);
            }

            return   $messages;
        }

        if($my_user_id){
            if($chat->sender_user_id==$user->id || $chat->recipient_user_id==$user->id){
                $messages = getMessages($chat_id,'user',$my_user_id);
            }
        }elseif($my_page_id){
            $page = Page::find($my_page_id);
            if($user->pages->contains($page)){
                if($chat->sender_page_id==$page->id || $chat->recipient_page_id==$page->id){
                    $messages = getMessages($chat_id,'page',$my_page_id);
                }
            }
        }

        return response()->json([
            'success' => true,
            'results' => [
                'messages' => $messages,
            ]
        ]);

    }

    public function getNotReadMessages(){
        $user = Auth::user();
        $message_not_read_qty = 0;
        //tutti i messaggi della chat con utenti diversi sal mio
        $message_not_read_qty = Message::where('recipient_user_id',$user->id)
                              ->where('readed',null)
                              ->count();

        $my_pages = $user->pages;
        foreach ($my_pages as $my_page) {
            $message_not_read_qty =
            $message_not_read_qty + Message::where('recipient_page_id',$my_page->id)
                                            ->where('readed',null)
                                            ->count();
        }

        return response()->json([
            'success' => true,
            'results' => [
                'message_not_read_qty' => $message_not_read_qty,
            ]
        ]);

    }

}
