<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\MailNotification;
use Illuminate\Support\Facades\Mail;
use File;
use App\User;
use App\Account;
use App\Other;
use App\MultipleOther;
use App\Follow;
use App\Notification;
use App\FilterNotification;
use App\Language;

class OtherController extends Controller
{
    public function addMultipleSection(Request $request){

        $request->validate([
            'section_name'=> 'required|min:2|max:30',
            'account_id' => 'required|integer',
        ]);

        $section_name = $request->section_name;
        $account_id = $request->account_id;

        $account = Account::find($account_id);
        $count_multiple_other = MultipleOther::where('account_id',$account_id)->count();

        $last_item =
        MultipleOther::where('account_id',$account_id)
        ->orderBy('position', 'DESC')->first();
        if($last_item){
            $last_position = $last_item->position;
            $new_last_position = $last_position + 1;
        }else{
            $new_last_position = 0;
        }

        if($account->user_id==Auth::user()->id
        && $count_multiple_other<10){

            $new_multiple_other = new MultipleOther;
            $new_multiple_other->account_id = $account_id;
            $new_multiple_other->name = $section_name;
            $new_multiple_other->position = $new_last_position;
            $new_multiple_other->save();

        }

    }

    public function updateMultipleOther(Request $request)
    {
        $request->validate([
            'multiple_other_id' => 'required|integer',
            'section_name' => 'required|min:2|max:30',
        ]);

        $multiple_other_id = $request->multiple_other_id;
        $section_name = $request->section_name;

        $multipleOther = MultipleOther::find($multiple_other_id);

        $account = Account::find($multipleOther->account_id);

        if($account->user_id==Auth::user()->id){
            $multipleOther->name = $section_name;
            $multipleOther->update();
        }

    }


    public function deleteMultipleOther(Request $request)
    {
        $request->validate([
            'multiple_other_id' => 'required|integer',
        ]);

        $multiple_other_id = $request->multiple_other_id;

        $multipleOther = MultipleOther::find($multiple_other_id);

        $account = Account::find($multipleOther->account_id);

        if($account->user_id==Auth::user()->id){
            $multipleOther->delete();
            //RIORDINO LE POSIZIONI DOPO L'ELIMINAZIONE
            $multipleOthers = MultipleOther::where('account_id', $account->id)
                                ->orderBy('position', 'ASC')
                                ->get();

            foreach($multipleOthers as $key => $multipleOther) {
                $multipleOther->position = $key;
                $multipleOther->update();
            }
        }

    }


    public function changeMultipleOtherPosition(Request $request)
    {
        $request->validate([
            'section_id' => 'required|integer',
            'up_down' => 'required',
        ]);


        $section = MultipleOther::find($request->section_id);
        $up_down = $request->up_down;
        $section_qty = MultipleOther::where('account_id',$section->account_id)
                    ->count();

        $account = Account::find($section->account_id);

        if($account->user_id==Auth::user()->id){

            if($up_down==-1 && $section->position>=1){

                $current_position = $section->position;
                $desired_position = $current_position - 1;

                $previous_section =
                MultipleOther::where('account_id',$section->account_id)
                ->where('position',$desired_position)
                ->first();

                $previous_section->position = $current_position;
                $previous_section->update();

                $section->position = $desired_position;
                $section->update();

            }elseif($up_down==1 && $section->position<$section_qty-1){

                $current_position = $section->position;
                $desired_position = $current_position + 1;

                $next_section =
                MultipleOther::where('account_id',$section->account_id)
                ->where('position',$desired_position)
                ->first();

                $next_section->position = $current_position;
                $next_section->update();

                $section->position = $desired_position;
                $section->update();
            }

        }

    }

    public function addOther($section_id)
    {
        $data = [
            'section_id' => $section_id,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.others.create', $data);
    }

    public function storeOther(Request $request, $section_id)
    {
        $request->validate([
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            'title'=> 'required|max:255',
            'sub_title'=> 'nullable|max:255',
            'description' => 'nullable|max:65535',
            'linkedin' => 'nullable|max:255',
        ]);

        $data = $request->all();

        $multipleOther = MultipleOther::find($section_id);

        $account = Account::find($multipleOther->account_id);

        if($account->user_id==Auth::user()->id){

            // dd($request->image);

            if(array_key_exists('image', $data)){
                $image_path = Storage::put('others_images', $data['image']);
                $data['image'] = $image_path;
            }
            $last_item =
            Other::where('multiple_other_id',$multipleOther->id)
            ->orderBy('position', 'DESC')->first();
            if($last_item){
                $last_position = $last_item->position;
                $new_last_position = $last_position + 1;
            }else{
                $new_last_position = 0;
            }
            $new_other = new Other();
            $new_other->multiple_other_id = $section_id;
            $new_other->position = $new_last_position;
            $new_other->fill($data);
            $new_other->save();

            //NOTIFICA

            $my_followers = Follow::where('follow_account_id',$account->id)->get();

            $users_mail=[];

            foreach ($my_followers as $my_follower) {

                $not_send = FilterNotification::where('account_id',$my_follower->id)->where('filter_not_type_id',4)->first();

                if(!$not_send){
                    $new_notification = new Notification;
                    $new_notification->user_id = $my_follower->user_id;
                    $new_notification->ref_account_id = $account->id;
                    $new_notification->type = 4;
                    $new_notification->message = $account->name.' ha aggiunto qualcosa nella sezione '.$multipleOther->name.': '.$new_other->title;
                    $new_notification->save();
                    //stato 0
                    //candidatura 1
                    //bisogno account 2
                    //bisogno account servizio 3
                    //sezione 4
                    //collaborazione 5
                    //conferma collaborazione 6
                    //rifiuta candidatura 7
                }
                //MAIL
                // $user_mail = User::find($my_follower->user_id)->email;
                //
                // array_push($users_mail,$user_mail);
            }

            // $data = [
            //     'name' => $account->name,
            //     'message' => $new_notification->message,
            // ];
            //
            // foreach ($users_mail as $user_mail) {
            //     Mail::to($user_mail)
            //         ->queue(new MailNotification($data));
            // }

        }

        return redirect()->route('admin.accounts.show', ['account' => $account->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function changeOtherPosition(Request $request)
    {
        $request->validate([
            'other_id' => 'required|integer',
            'up_down' => 'required',
        ]);


        $other = Other::find($request->other_id);
        $multipleOther = MultipleOther::find($other->multiple_other_id);
        $up_down = $request->up_down;
        $other_qty = Other::where('multiple_other_id',$other->multiple_other_id)
                    ->count();

        $account = Account::find($multipleOther->account_id);

        if($account->user_id==Auth::user()->id){

            if($up_down==-1 && $other->position>=1){

                $current_position = $other->position;
                $desired_position = $current_position - 1;

                $previous_other =
                Other::where('multiple_other_id',$other->multiple_other_id)
                ->where('position',$desired_position)
                ->first();

                $previous_other->position = $current_position;
                $previous_other->update();

                $other->position = $desired_position;
                $other->update();

            }elseif($up_down==1 && $other->position<$other_qty-1){

                $current_position = $other->position;
                $desired_position = $current_position + 1;

                $next_other =
                Other::where('multiple_other_id',$other->multiple_other_id)
                ->where('position',$desired_position)
                ->first();

                $next_other->position = $current_position;
                $next_other->update();

                $other->position = $desired_position;
                $other->update();
            }

        }

    }


    public function edit($id)
    {
        $other = Other::where('id',$id)
        // ->join('multiple_others','multiple_others.id','=','multiple_other_id')
        ->first();

        $data = [
            'other' => $other,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.others.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Other $other)
    {
        $request->validate([
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            'title'=> 'required|max:255',
            'sub_title'=> 'nullable|max:255',
            'description' => 'nullable|max:65535',
            'linkedin' => 'nullable|max:255',
        ]);

        $data = $request->all();

        $multipleOther = MultipleOther::find($other->multiple_other_id);

        $account = Account::find($multipleOther->account_id);

        if($account->user_id==Auth::user()->id){

            if(array_key_exists('image', $data)){

                $old_image_name = $other->image;
                if ($old_image_name) {
                    Storage::delete($old_image_name);
                }
                $image_path = Storage::put('others_images', $data['image']);
                $data['image'] = $image_path;
            }

            $other->update($data);
        }

        return redirect()->route('admin.accounts.show', ['account' => $account->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteOther(Request $request)
    {
        $request->validate([
            'other_id' => 'required|integer',
        ]);

        $other = Other::find($request->other_id);

        $multipleOther = MultipleOther::find($other->multiple_other_id);

        $account = Account::find($multipleOther->account_id);

        if($account->user_id==Auth::user()->id){

            Storage::delete($other->image);

            $other->delete();

            //RIORDINO LE POSIZIONI DOPO L'ELIMINAZIONE
            $others = Other::where('multiple_other_id', $multipleOther->id)
                        ->orderBy('position', 'ASC')
                        ->get();

            foreach($others as $key => $other) {
                $other->position = $key;
                $other->update();
            }
        }

    }
}
