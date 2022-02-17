<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use App\Account;
use App\Team;
use App\Language;
use Image;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function addMember($account_id)
    {

        $data = [
            'account_id' => $account_id,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.teams.create', $data);
    }

    public function storeMember(Request $request, $account_id)
    {
        $request->validate([
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            'name'=> 'required|max:70',
            'role'=> 'nullable|max:50',
            'description' => 'nullable|max:255',
            'linkedin' => 'nullable|max:255',
        ]);

        $data = $request->all();

        $account = Account::find($account_id);

        $team_number = Team::where('account_id',$account_id)->count();
        $last_item = Team::where('account_id',$account_id)
                    ->orderBy('position', 'DESC')->first();
        if($last_item){
            $last_position = $last_item->position;
            $new_last_position = $last_position + 1;
        }else{
            $new_last_position = 0;
        }

        if($account->user_id==Auth::user()->id && $team_number<50){

            $new_team_member = new Team();
            $new_team_member->fill($data);
            $new_team_member->account_id = $account_id;
            $new_team_member->position = $new_last_position;

            if(array_key_exists('image', $data)){
                //recupero la path e salvo la nuova l'immagine
                $image_path = Storage::put('teams_images', $data['image']);
                //resize
                $img = Image::make($data['image'])
                            ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                            ->resize(300,300)/*risoluzione*/
                            ->save('./storage/'.$image_path, 100 /*Qualita*/);
                $new_team_member->image = $image_path;
            }

            $new_team_member->save();
        }

        return redirect()->route('admin.accounts.show', ['account' => $account_id]);

    }

    public function store(Request $request, Account $account)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Team::find($id);
        $data = [
            'member' => $member,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.teams.edit', $data);
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            'name'=> 'required|max:70',
            'role'=> 'nullable|max:50',
            'description' => 'nullable|max:255',
            'linkedin' => 'nullable|max:255',
        ]);

        $data = $request->all();

        $account = Account::find($team->account_id);

        if($account->user_id==Auth::user()->id){

            $width = $request->width;
            $height = $request->height;
            //dd($width, $height);

            //dd($data['image']);
            if(array_key_exists('image', $data)){
                //SE CARICO UNA NUOVA IMMAGINE
                $old_image_name = $team->image;

                //se la vecchia immagine è diversa da quella di default
                if ($old_image_name!='accounts_images/default_account_image.png') {
                    //elimino la vecchia immagine
                    Storage::delete($old_image_name);
                }
                //recupero la path e salvo la nuova l'immagine
                $image_path = Storage::put('teams_images', $data['image']);
                //resize
                //dd($image_path);
                $img = Image::make($data['image'])
                            ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                            ->resize(300,300)/*risoluzione*/
                            ->save('./storage/'.$image_path, 100 /*Qualita*/);

                $team->image = $image_path;
            }elseif($width && $height){
                //SE HO MODIFICATO L'IMMAGINE ESISTENTE
                $image_path = $team->image;

                if ($image_path!='accounts_images/default_account_image.png') {

                    $filename = rand().time();
                    $ext = pathinfo($image_path, PATHINFO_EXTENSION);
                    $new_path = 'teams_images/'.$filename.'.'.$ext;
                    Storage::move($image_path, $new_path);

                    $img = Image::make('storage/'.$new_path)
                                ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                                ->resize(300,300)/*risoluzione*/
                                ->save('./storage/'.$new_path, 100 /*Qualita*/);
                    $team->image = $new_path;
                }

            }
            $data['image'] = $team->image;
            $team->update($data);
        }

        return redirect()->route('admin.accounts.show', ['account' => $account->id]);
    }

    public function changeTeamPosition(Request $request)
    {
        $request->validate([
            'member_id' => 'required|integer',
            'up_down' => 'required',
        ]);

        $member = Team::find($request->member_id);
        $up_down = $request->up_down;
        $member_qty = Team::where('account_id',$member->account_id)
                        ->count();

        $account = Account::find($member->account_id);

        if($account->user_id==Auth::user()->id){

            if($up_down==-1 && $member->position>=1){

                $current_position = $member->position;
                $desired_position = $current_position - 1;

                $previous_member = Team::where('account_id',$member->account_id)
                                    ->where('position',$desired_position)
                                    ->first();

                $previous_member->position = $current_position;
                $previous_member->update();

                $member->position = $desired_position;
                $member->update();

            }elseif($up_down==1 && $member->position<$member_qty-1){

                $current_position = $member->position;
                $desired_position = $current_position + 1;

                $next_member = Team::where('account_id',$member->account_id)
                                    ->where('position',$desired_position)
                                    ->first();

                $next_member->position = $current_position;
                $next_member->update();

                $member->position = $desired_position;
                $member->update();
            }

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {

    }

    public function deleteMember(Request $request)
    {
        $request->validate([
            'member_id' => 'required|integer',
        ]);

        $member = Team::find($request->member_id);

        $account = Account::find($member->account_id);

        if($account->user_id==Auth::user()->id){

            $old_image_name = $member->image;

            if ($old_image_name!='accounts_images/default_account_image.png'){
                Storage::delete($old_image_name);
            }

            $member->delete();

            //RIORDINO LE POSIZIONI DOPO L'ELIMINAZIONE
            $members = Team::where('account_id', $account->id)
                        ->orderBy('position', 'ASC')
                        ->get();

            foreach($members as $key => $member) {
                $member->position = $key;
                $member->update();
            }
        }

        $team_num = Team::where('account_id', $account->id)
        ->count();

        return response()->json([
            'success' => true,
            'results' => [
                'team_num' => $team_num,
            ]
        ]);
    }
}
