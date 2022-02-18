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

      return view('admin.users.create', $data);

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
      }

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

      $data = [
        'user' => $user,
        'userTypes' => $user->userTypes,
      ];

      return view('admin.users.show', $data);

    }

    public function editImage($user_id){

        $user = User::find($user_id);

        if(Auth::user()->id==$user->user_id){

            $data = [
                'user_id' => $user_id,
                'image' => $user->image,
            ];

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            return view('admin.users.editimage', $data);

        }abort(404);

    }

    public function updateImage(Request $request,$user_id){

        $request->validate([
            //'user_id' => 'require|integer',
            //'cover_image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            // 'width'=> 'require',
            // 'height'=> 'require',
            // 'x' => 'require',
            // 'y'=> 'require',
        ]);

        $data = $request->all();

        $user = Account::find($user_id);
        //dd(Auth::user()->id);
        //dd($data['width'],$data['height'], $data['x'],$data['y']);

        if(Auth::user()->id==$user->user_id){
            //dd($data['y']);
            $width = $request->width;
            $height = $request->height;

            if(array_key_exists('image', $data)){
                //SE CARICO UNA NUOVA IMMAGINE
                $old_image_name = $user->image;

                //se la vecchia immagine è diversa da quella di default
                if ($old_image_name!='users_images/default_user_image.png') {
                    //elimino la vecchia immagine
                    Storage::delete($old_image_name);
                }
                //recupero la path e salvo la nuova l'immagine
                $image_path = Storage::put('users_images', $data['image']);
                //resize
                $img = Image::make($data['image'])
                            ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                            ->resize(300,300)/*risoluzione*/
                            ->save('./storage/'.$image_path, 100 /*Qualita*/);

                $user->image = $image_path;
            }elseif($width && $height){
                //SE HO MODIFICATO L'IMMAGINE ESISTENTE
                $image_path = $user->image;

                if ($image_path!='users_images/default_user_image.png') {

                    $filename = rand().time();
                    $ext = pathinfo($image_path, PATHINFO_EXTENSION);
                    $new_path = 'users_images/'.$filename.'.'.$ext;
                    Storage::move($image_path, $new_path);

                    $img = Image::make('storage/'.$new_path)
                                ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                                ->resize(300,300)/*risoluzione*/
                                ->save('./storage/'.$new_path, 100 /*Qualita*/);
                    $user->image = $new_path;
                }

            }

            $user->update();

            return redirect()->route('admin.users.show', ['user' => $user->id]);

        }abort(404);

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
}
