<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use App\Language;
use App\User;
use App\Page;
use App\Usertype;
use App\Pagetype;
use App\Moneyrange;
use App\Sector;
use App\GiveUserService;

class UserController extends Controller
{
    public function __construct()
    {
      $this->middleware(['auth','verified']);
    }

    public function create(){

      $user = Auth::user();
      $userTypes = Usertype::where('hidden',null)->get();
      $pageTypes = Pagetype::where('hidden',null)->get();

      $data = [
        'user' => $user,
        'userTypes' => $userTypes,
        'pageTypes' => $pageTypes,
      ];
      return view('admin.users.create', $data);
      //return redirect()->route('admin.users.create');

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

      return redirect()->route('admin.users.show',$user->id);

    }

    public function edit($id){

      $user = Auth::user();

      if($user->id==$id){
        $data = [
          'user' => $user,
          'userTypes' => $user->userTypes,
          'moneyranges' => Moneyrange::all(),
          'sectors' => Sector::all(),
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
          'moneyrange_id' => 'nullable|integer|min:1|max:5',
          'startup_n' => 'nullable|integer',
          'municipality' => 'nullable',
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

      //dd($user->currency);
      $give_services = GiveUserService::where('user_id',$user->id)
      ->join('services','services.id','service_id')
      ->select('give_user_services.id','services.name')
      ->get();

      $data = [
        'user' => $user,
        'userTypes' => $userTypes,
        'is_my_user' => Auth::user()->id==$user->id?true:false,
        'pageTypes' => $user->pagetypes,
        'currencies' => $user->currencies,
        'give_services' => $give_services,
      ];

      return view('admin.users.show', $data);

    }

    public function sectors($id){

      $user = Auth::user();

      if($user->id==$id){
        $data = [
          'user' => $user,
          'sectors' => Sector::all(),
        ];

        return view('admin.users.sectors', $data);

      }abort(404);

    }

    public function storesectors(Request $request, $id){

        $request->validate([
            'sectors'=> 'exists:sectors,id',
        ]);

        $data = $request->all();

        $user = Auth::user();

        if(array_key_exists('sectors', $data)){
            $user->sectors()->sync($data['sectors']);
        }else{
            $user->sectors()->sync([]);
        }

        return redirect()->route('admin.users.show',$user->id);

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

    public function settings($id){

      $user = User::find($id);
      $languages = Language::all();

      $data = [
        'user' => $user,
        'languages' => $languages,
      ];

      return view('admin.users.settings', $data);

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

      }

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

      }

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

        $message = '';

        //controllo se esiste almeno un'altro admin
        if(count($page->users) > 1){
          //se sto elimnando me stesso
          if(Auth::user()->id == $user_id){
            $message = 'auto-delete';
          }
          //rimuovo l' amministratore
          $user = User::find($user_id);
          $page->users()->detach($user);
        }else{
          $message = 'Sei l\'unico admin';
        }

      }

      return response()->json([
          'success' => true,
          'results' => [
              'message' => $message,
          ]
      ]);

    }

}
