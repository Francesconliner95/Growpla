<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use Image;
use App\Language;
use App\User;
use App\Page;
use App\Usertype;
use App\Pagetype;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function editUserImage(){

        $user = Auth::user();

        $data = [
            'user_id' => $user->id,
            'image' => $user->image,
            'default_images' => Usertype::pluck('image')->toArray(),
        ];

        //dd($user->image);

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.users.editimage', $data);

    }

    public function updateUserImage(Request $request){

        $request->validate([
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
        ]);

        $data = $request->all();

        $user = Auth::user();
        $width = $request->width;
        $height = $request->height;

        $default_images = Usertype::pluck('image')->toArray();

        if(array_key_exists('image', $data)){

            //SE CARICO UNA NUOVA IMMAGINE
            $old_image_name = $user->image;

            //se la vecchia immagine è diversa da quella di default
            if ($old_image_name && !in_array($old_image_name,$default_images)) {
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
            if(!in_array($user->image,$default_images)){
                $image_path = $user->image;

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

        if(!$user->image){
            // dd($user->image);
            if(in_array($user->image,$default_images)){
                $user_usertypes = $user->usertypes->pluck('id')->toArray();
                if(in_array(1,$user_usertypes)){
                    $user->image = $default_images[0];
                }
                //UTENTE
                if(in_array(7,$user_usertypes)){
                    $user->image = $default_images[6];
                }
                //STUDENTE
                if(in_array(5,$user_usertypes)){
                    $user->image = $default_images[4];
                }
                //ASPIRANTE COFOUNDER
                if(in_array(1,$user_usertypes)){
                    $user->image = $default_images[0];
                }
                //DIPENDENTI
                // if(in_array(4,$user_usertypes)){
                //     $user->image = $default_images[6];
                // }
                // //FREELANCER
                // if(in_array(3,$user_usertypes)){
                //     $user->image = $default_images[6];
                // }
                // //STARTUPPER
                // if(in_array(6,$user_usertypes)){
                //     $user->image = $default_images[6];
                // }
                //BUSINESS ANGEL
                if(in_array(2,$user_usertypes)){
                    $user->image = $default_images[1];
                }
            }
        }

        $user->update();

        return redirect()->route('admin.users.show', ['user' => $user->id]);

    }

    public function removeUserImage()
    {
        $user = Auth::user();

        $default_images = Usertype::pluck('image')->toArray();

        if(!in_array($user->image,$default_images)){

            Storage::delete($user->image);
            
            $user_usertypes = $user->usertypes->pluck('id')->toArray();
            if(in_array(1,$user_usertypes)){
                $user->image = $default_images[0];
            }
            //UTENTE
            if(in_array(7,$user_usertypes)){
                $user->image = $default_images[6];
            }
            //STUDENTE
            if(in_array(5,$user_usertypes)){
                $user->image = $default_images[4];
            }
            //ASPIRANTE COFOUNDER
            if(in_array(1,$user_usertypes)){
                $user->image = $default_images[0];
            }
            //DIPENDENTI
            // if(in_array(4,$user_usertypes)){
            //     $user->image = $default_images[6];
            // }
            // //FREELANCER
            // if(in_array(3,$user_usertypes)){
            //     $user->image = $default_images[6];
            // }
            // //STARTUPPER
            // if(in_array(6,$user_usertypes)){
            //     $user->image = $default_images[6];
            // }
            //BUSINESS ANGEL
            if(in_array(2,$user_usertypes)){
                $user->image = $default_images[1];
            }

            $user->update();
        }

    }

    public function editPageImage($id){

        $page = Page::find($id);
        $user = Auth::user();

        if($page->users->contains($user)){
          //dd($user->page);

          $data = [
              'page_id' => $page->id,
              'image' => $page->image,
              'default_images' => Pagetype::pluck('image')->toArray(),
          ];

          //dd($user->image);

          app()->setLocale(Language::find(Auth::user()->language_id)->lang);

          return view('admin.pages.editimage', $data);
        }abort(404);

    }

    public function updatePageImage(Request $request){

        $request->validate([
            'page_id' => 'required|integer',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
        ]);

        $data = $request->all();

        $user = Auth::user();
        $width = $request->width;
        $height = $request->height;
        $page =  Page::find($request->page_id);

        $default_images = Pagetype::pluck('image')->toArray();

        if($page->users->contains(Auth::user())){

          if(array_key_exists('image', $data)){

              //SE CARICO UNA NUOVA IMMAGINE
              $old_image_name = $page->image;

              //se la vecchia immagine è diversa da quella di default
              if ($old_image_name && !in_array($old_image_name,$default_images)) {
                  //elimino la vecchia immagine
                  Storage::delete($old_image_name);
              }
              //recupero la path e salvo la nuova l'immagine
              $image_path = Storage::put('pages_images', $data['image']);
              //resize
              $img = Image::make($data['image'])
                          ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                          ->resize(300,300)/*risoluzione*/
                          ->save('./storage/'.$image_path, 100 /*Qualita*/);

              $page->image = $image_path;
          }elseif($width && $height){
              //SE HO MODIFICATO L'IMMAGINE ESISTENTE
              if(!in_array($old_image_name,$default_images)){

                $image_path = $page->image;

                $filename = rand().time();
                $ext = pathinfo($image_path, PATHINFO_EXTENSION);
                $new_path = 'pages_images/'.$filename.'.'.$ext;
                Storage::move($image_path, $new_path);

                $img = Image::make('storage/'.$new_path)
                            ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                            ->resize(300,300)/*risoluzione*/
                            ->save('./storage/'.$new_path, 100 /*Qualita*/);
                $page->image = $new_path;
              }
          }

          $page->update();

          return redirect()->route('admin.pages.show', ['page' => $page->id]);

        }abort(404);

    }

    public function removePageImage($page_id)
    {
            // $request->validate([
            //     'page_id' => 'required|integer',
            // ]);
            $page = Page::find($page_id);
            $user = Auth::user();

            $default_images = Pagetype::pluck('image')->toArray();

            if($page->users->contains($user)){

                if(!in_array($page->image,$default_images)){
                    Storage::delete($page->image);
                    $page->image = Pagetype::find($page->pagetype_id)->image;
                    $page->update();
                }

                return redirect()->route('admin.pages.show', ['page'=> $page->id]);

            }abort(404);

    }
}
