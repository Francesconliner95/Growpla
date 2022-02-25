<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use App\User;
use App\Page;
use App\Usertype;
use App\Pagetype;
use App\Team;
use App\Sector;

class PageController extends Controller
{
    public function __construct()
    {
      $this->middleware(['auth','verified']);
    }

    public function create(){

    }

    public function newPage($pagetype_id){

      $data = [
        'pagetype_id' => $pagetype_id,
      ];

      return view('admin.pages.create', $data);

    }

    public function store(Request $request){

      $request->validate([
          'name'=> 'required|string|min:3|max:70',
          'pagetype_id'=> 'required|integer',
      ]);

      $data = $request->all();

      //SLUG
      $slug = Str::slug($request->name);

      $slug_base = $slug;

      $slug_exist = Page::where('slug', $slug)->first();

      $counter=1;

      while($slug_exist){
          $slug = $slug_base . '-' . $counter;
          $counter++;
          $slug_exist = Page::where('slug', $slug)->first();
      }
      //END SLUG

      $new_page = new Page();
      $new_page->pagetype_id = $request->pagetype_id;
      $new_page->name = Str::lower($request->name);
      $new_page->slug = $slug;
      $new_page->save();

      $user = Auth::user();
      $new_page->users()->attach($user);

      return redirect()->route('admin.pages.edit', ['page'=> $new_page->id]);

    }

    public function edit($id){

        $page = Page::find($id);
        $data = [
          'page' => $page,
        ];

        return view('admin.pages.edit', $data);

    }

    public function update(Request $request, $id){

      $request->validate([
          'name' => 'required|string|min:3|max:70',
          'description' => 'required|min:50',
          'website' => 'nullable|max:255',
          'linkedin'=> 'nullable|max:255',
          'pitch' => 'nullable|mimes:pdf|max:6144',
      ]);

      $data = $request->all();

      $page = Page::find($id);

      // if($user->id == $id){

          if(array_key_exists('pitch', $data)){
              $old_pitch_name = $page->pitch;
              Storage::delete($old_pitch_name);
              $pitch_path = Storage::put('pitch', $data['pitch']);
              $data['pitch'] = $pitch_path;
          }

          $page->fill($data);

          if($request->name){
            $page->name = Str::lower($request->name);
          }

          $page->update();

          return redirect()->route('admin.pages.show', ['page' => $page->id]);

      // }abort(404);
    }

    public function show($id){

      $page = Page::find($id);
      //TEAM
      $team_members = Team::where('page_id', $id)
                      ->orderBy('position', 'ASC')
                      ->limit(3)
                      ->get();
      foreach ($team_members as $team_member) {
        if($team_member->user_id){
          $user = User::find($team_member->user_id);
          $team_member['name'] = $user->name;
          $team_member['surname'] = $user->surname;
          $team_member['image'] = $user->image;
          $team_member['linkedin'] = $user->linkedin;
        }
      }

      $team_num = Team::where('page_id', $id)->count();

      $data = [
        'page' => $page,
        'is_my_page' => true,
        'team_members' => $team_members,
        'team_num' => $team_num,
      ];

      return view('admin.pages.show', $data);

    }

    public function settings($id){

      $page = Page::find($id);

      if($page->users->contains(Auth::user())){

        $data = [
          'page_id' => $page->id,
        ];

        return view('admin.pages.settings', $data);
      }abort(404);

    }

    public function destroy($id){

      $page = Page::find($id);

      if($page->users->contains(Auth::user())){

        $page->delete();

        return redirect()->route('admin.users.show', ['user' => Auth::user()->id]);

      }abort(404);

    }

    public function sectors($id){

      $user = Auth::user();
      $page = Page::find($id);

      if($page->users->contains($user)){

        $data = [
          'page' => $page,
          'sectors' => Sector::all(),
        ];

        return view('admin.pages.sectors', $data);

      }abort(404);

    }

    public function storesectors(Request $request, $id){

      $request->validate([
          'sectors'=> 'exists:sectors,id',
      ]);

      $data = $request->all();

      $user = Auth::user();
      $page = Page::find($id);

      if($page->users->contains($user)){

        if(array_key_exists('sectors', $data)){
          $page->sectors()->sync($data['sectors']);
        }

        return redirect()->route('admin.pages.show',$user->id);

      }abort(404);

    }

    // public function getUser(Request $request){
    //
    //   if(Auth::check()){
    //       $result = Auth::user()->id;
    //   }else{
    //       $result = false;
    //   }
    //
    //   return response()->json([
    //       'success' => true,
    //
    //       'results' => [
    //           'user_id' => $result,
    //       ]
    //   ]);
    //
    // }
}
