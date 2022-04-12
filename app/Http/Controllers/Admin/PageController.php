<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Language;
use File;
use App\View;
use App\User;
use App\Page;
use App\Usertype;
use App\Pagetype;
use App\Team;
use App\Sector;
use App\Moneyrange;
use App\Lifecycle;
use App\Region;
use App\Country;

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
        'pagetype' => Pagetype::find($pagetype_id),
      ];
      app()->setLocale(Language::find(Auth::user()->language_id)->lang);
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
        $new_page->image = Pagetype::find($request->pagetype_id)->image;
        $new_page->save();

        $user = Auth::user();
        $new_page->users()->attach($user);

        return redirect()->route('admin.pages.edit', ['page'=> $new_page->id]);

    }

    public function edit(Page $page){

        //verifico se l'utente ha abilitato il tipo di pagina selezionata
        if(Auth::user()->pagetypes->contains($page->pagetype_id)){

            $data = [
              'page' => $page,
              'moneyranges' => Moneyrange::all(),
              'countries'=> Country::all(),
            ];
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return view('admin.pages.edit', $data);

        }abort(404);

    }

    public function update(Request $request, Page $page){

        $request->validate([
          'name' => 'required|string|min:3|max:70',
          'summary' => 'required|min:50|max:250',
          'description' => 'nullable|min:50|max:1000',
          'website' => 'nullable|max:255',
          'linkedin'=> 'nullable|max:255',
          'pitch' => 'nullable|mimes:pdf|max:6144',
          'incorporated' => 'nullable|boolean',
          'moneyrange_id' => 'nullable|integer|min:1|max:5',
          'startup_n' => 'nullable|integer',
          'latitude' => 'nullable',
          'longitude' => 'nullable',
          'street_name' => 'nullable',
          'street_number' => 'nullable',
          'municipality' => 'nullable',
        ]);

        if(Auth::user()->pagetypes->contains($page->pagetype_id)){

            $data = $request->all();
            if(array_key_exists('pitch',$data) && $data['remove_pitch'] && $page->pitch){
                $old_pitch_name = $page->pitch;
                if($old_pitch_name){
                    Storage::delete($old_pitch_name);
                }
                $data['pitch'] = '';
            }

            if(array_key_exists('pitch',$data) && $data['pitch']){
                $old_pitch_name = $page->pitch;
                if($old_pitch_name){
                    Storage::delete($old_pitch_name);
                }
                $pitch_path = Storage::put('pitch', $data['pitch']);
                $data['pitch'] = $pitch_path;
            }

            $page->fill($data);

            if($request->name){
              $page->name = Str::lower($request->name);
            }

            $page->update();

            return redirect()->route('admin.pages.show', ['page' => $page->id]);

        }abort(404);

    }

    public function show(Page $page){
      $user = Auth::user();

      if($page){
        //TEAM
        $team_members = Team::where('page_id', $page->id)
                        ->orderBy('position', 'ASC')
                        ->limit(3)
                        ->get();
        foreach ($team_members as $team_member) {
          if($team_member->user_id){
            $user_team = User::find($team_member->user_id);
            $team_member['name'] = $user_team->name;
            $team_member['surname'] = $user_team->surname;
            $team_member['image'] = $user_team->image;
            $team_member['linkedin'] = $user_team->linkedin;
          }
        }

        $team_num = Team::where('page_id', $page->id)->count();

        $my_user_id = Auth::user()->id;
        $already_viewed = View::where('user_id',$my_user_id)->where('viewed_page_id',$page->id)->first();
        if($already_viewed){
            $already_viewed->touch();
        }else{
            $new_view = new View();
            $new_view->user_id = $my_user_id;
            $new_view->viewed_page_id = $page->id;
            $new_view->save();
        }

        $data = [
          'page' => $page,
          'is_my_page' => $user->pages->contains($page),
          'lifecycles' => Lifecycle::all(),
          'team_members' => $team_members,
          'team_num' => $team_num,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.pages.show', $data);
      }abort(404);

    }

    public function settings($id){

      $page = Page::find($id);

      if($page->users->contains(Auth::user())){

        $data = [
          'page_id' => $page->id,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
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
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
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
        }else{
          $page->sectors()->sync([]);
        }

        return redirect()->route('admin.pages.show',$page->id);

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
