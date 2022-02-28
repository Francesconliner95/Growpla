<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use App\Page;
use App\Team;
use App\User;
use App\Language;
use Image;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function addTeam($page_id)
    {

        $data = [
            'page_id' => $page_id,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.teams.create', $data);
    }

    public function storeTeam(Request $request, $page_id)
    {
        $request->validate([
            'role'=> 'required|max:255',
        ]);

        $data = $request->all();

        $page = Page::find($page_id);

        $can_create = false;

        if($request->registered_team==0){
            //pagina non iscritta
            if($request->user_id){
                $already_exist = Team::where('page_id',$page_id)
                                ->where('user_id',$request->user_id)
                                ->first();
                if(!$already_exist){
                    $can_create = true;
                }
            }
        }else{
            //pagina iscritta
            if($request->name && $request->surname){
                $can_create = true;
            }
        }

        if($can_create){

          $team_number = Team::where('page_id',$page_id)->count();
          $last_item = Team::where('page_id',$page_id)
                      ->orderBy('position', 'DESC')->first();
          if($last_item){
              $last_position = $last_item->position;
              $new_last_position = $last_position + 1;
          }else{
              $new_last_position = 0;
          }

          if($page->users->contains(Auth::user()) && $team_number<50){

              $new_team_team = new Team();
              $new_team_team->fill($data);
              $new_team_team->page_id = $page_id;
              $new_team_team->position = $new_last_position;

              if(array_key_exists('image', $data)){
                  //recupero la path e salvo la nuova l'immagine
                  $image_path = Storage::put('teams_images', $data['image']);
                  //resize
                  $img = Image::make($data['image'])
                              ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                              ->resize(300,300)/*risoluzione*/
                              ->save('./storage/'.$image_path, 100 /*Qualita*/);
                  $new_team_team->image = $image_path;
              }

              $new_team_team->save();
          }

        }

        return redirect()->route('admin.pages.show', ['page' => $page_id]);

    }

    public function edit($id)
    {
        $team = Team::find($id);

        $user = '';
        if($team->user_id){
          $user = User::find($team->user_id);
        }

        $data = [
            'team' => $team,
            'user' => $user,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.teams.edit', $data);
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
          'role'=> 'required|max:255',
        ]);

        $data = $request->all();

        $page = Page::find($team->page_id);

        $can_update = false;

        if($request->registered_team==0){
            //pagina non iscritta
            if($request->user_id){
                $already_exist = Team::where('page_id',$page->id)
                                ->where('user_id',$request->user_id)
                                ->first();
                if(!$already_exist){
                    $can_update = true;
                }
            }
        }else{
            //pagina iscritta
            if($request->name && $request->surname){
                $can_update = true;
            }
        }

        if($can_update && $page->users->contains(Auth::user())){

            $width = $request->width;
            $height = $request->height;

            if(array_key_exists('image', $data)){
                //SE CARICO UNA NUOVA IMMAGINE
                $old_image_name = $team->image;
                //se la vecchia immagine è diversa da quella di default
                if ($old_image_name) {
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

                if ($image_path) {

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

        return redirect()->route('admin.pages.show', ['page' => $page->id]);
    }

    public function changeTeamPosition(Request $request)
    {
        $request->validate([
            'team_id' => 'required|integer',
            'up_down' => 'required',
        ]);

        $team = Team::find($request->team_id);
        $up_down = $request->up_down;
        $team_qty = Team::where('page_id',$team->page_id)
                        ->count();

        $page = Page::find($team->page_id);

        if($page->users->contains(Auth::user())){

            if($up_down==-1 && $team->position>=1){

                $current_position = $team->position;
                $desired_position = $current_position - 1;

                $previous_team = Team::where('page_id',$team->page_id)
                                    ->where('position',$desired_position)
                                    ->first();

                $previous_team->position = $current_position;
                $previous_team->update();

                $team->position = $desired_position;
                $team->update();

            }elseif($up_down==1 && $team->position<$team_qty-1){

                $current_position = $team->position;
                $desired_position = $current_position + 1;

                $next_team = Team::where('page_id',$team->page_id)
                                    ->where('position',$desired_position)
                                    ->first();

                $next_team->position = $current_position;
                $next_team->update();

                $team->position = $desired_position;
                $team->update();
            }

        }

    }

    public function destroy(Team $team)
    {
        $user = Auth::user();
        //verifico se è una mia pagina
        if($team->page->users->contains($user)){

            if ($team->image){
                Storage::delete($team->image);
            }

            $team->delete();

            return redirect()->route('admin.pages.show', ['page' => $team->page->id]);
        }

    }

}
