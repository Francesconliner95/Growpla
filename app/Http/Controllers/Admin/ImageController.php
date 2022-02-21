<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use Image;
use App\Language;

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

        if(array_key_exists('image', $data)){

            //SE CARICO UNA NUOVA IMMAGINE
            $old_image_name = $user->image;

            //se la vecchia immagine è diversa da quella di default
            if ($old_image_name) {
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

        $user->update();

        return redirect()->route('admin.users.show', ['user' => $user->id]);

    }

    public function removeUserImage()
    {
            $user = Auth::user();

            Storage::delete($user->image);
            $user->image = null;

            $user->update();

    }

}
