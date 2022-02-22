<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use App\User;
use App\Page;
use App\Usertype;
use App\Pagetype;

class UserController extends Controller
{
    public function __construct()
    {
      $this->middleware(['auth','verified']);
    }

    public function create(){

      $user = Auth::user();
      $userTypes = Usertype::all();
      $pageTypes = Pagetype::all();

      $data = [
        'user' => $user,
        'userTypes' => $userTypes,
        'pageTypes' => $pageTypes,
      ];

      return redirect()->route('admin.users.show', ['user' => $user->id]);

    }

    public function store(Request $request){
      // dd('qui');
      $request->validate([
          'usertypes'=> 'exists:usertypes,id',
          'pagetypes'=> 'exists:pagetypes,id',
      ]);

      $data = $request->all();

      $user = Auth::user();

      if(array_key_exists('usertypes', $data)){
        $user->usertypes()->sync($data['usertypes']);
      }

      if(array_key_exists('pagetypes', $data)){
        $user->pagetypes()->sync($data['pagetypes']);
      }

      return redirect()->route('admin.users.create');

    }

    public function edit($id){

      $user = Auth::user();

      if($user->id==$id){
        $userTypes = Usertype::all();

        // dd($user->userTypes);
        $data = [
          'user' => $user,
          'userTypes' => $user->userTypes,
        ];

        return view('admin.users.edit', $data);
      }abort(404);

    }

    public function update(Request $request, $id){

      $request->validate([
          'name' => 'required|string|min:3|max:70',
          'surname' => 'required|string|min:3|max:70',
          'description' => 'required|min:50',
          'website' => 'nullable|max:255',
          'linkedin'=> 'nullable|max:255',
          'cv' => 'nullable|mimes:pdf|max:6144',
      ]);

      $data = $request->all();

      $user = Auth::user();

      if($user->id == $id){

          if(array_key_exists('cv', $data)){
              $old_cv_name = $user->cv;
              Storage::delete($old_cv_name);
              $cv_path = Storage::put('cv', $data['cv']);
              $data['cv'] = $cv_path;
          }

          $user->fill($data);

          if($request->name){
            $user->name = Str::lower($request->name);
          }

          $user->update();

          return redirect()->route('admin.users.show', ['user' => $user->id]);

      }abort(404);
    }

    public function show($id){

      $user = User::find($id);
      $userTypes = Usertype::all();
      // $is_my_user = ;

      $data = [
        'user' => $user,
        'userTypes' => $userTypes,
        'is_my_user' => Auth::user()->id==$user->id?true:false,
        'startups' => $user->pageTypes->where('pagetype_id',1),
        'companies' => $user->pageTypes->where('pagetype_id',2),
      ];

      return view('admin.users.show', $data);

    }

    public function getUser(Request $request){

      if(Auth::check()){
          $result = Auth::user()->id;
      }else{
          $result = false;
      }

      return response()->json([
          'success' => true,

          'results' => [
              'user_id' => $result,
          ]
      ]);

    }

    public function addAdmin(Request $request){

      $request->validate([
          'user_id' => 'required|integer',
          'page_id' => 'required|integer',
      ]);

      $user_id = $request->user_id;
      $page_id = $request->page_id;

      $page = Page::find($page_id);

      //controllo se sono il propietario della pagina
      if($page->users->contains(Auth::user())){

        //aggiungo un nuovo amministratore
        $user = User::find($user_id);
        $page->users()->attach($user);

      }abort(404);

    }

    public function getAdmin(Request $request){

      $request->validate([
          'page_id' => 'required|integer',
      ]);

      $page_id = $request->page_id;

      $page = Page::find($page_id);

      //controllo se sono il propietario della pagina
      if($page->users->contains(Auth::user())){

        return response()->json([
            'success' => true,
            'results' => [
                'admins' => $page->users,
            ]
        ]);

      }abort(404);

    }

    public function removeAdmin(Request $request){

      $request->validate([
          'user_id' => 'required|integer',
          'page_id' => 'required|integer',
      ]);

      $user_id = $request->user_id;
      $page_id = $request->page_id;

      $page = Page::find($page_id);

      //controllo se sono il propietario della pagina
      if($page->users->contains(Auth::user())){

        //controllo se esiste almeno un'altro admin
        if(count($page->users) > 1){
          //rimuovo l' amministratore
          $user = User::find($user_id);
          $page->users()->detach($user);
        }

      }abort(404);

    }

}
