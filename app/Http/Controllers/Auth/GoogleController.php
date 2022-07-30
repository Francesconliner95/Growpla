<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\User;
use Illuminate\Support\Facades\Storage;
use File;
use Image;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
                            ->stateless()
                            ->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect('/home');

            }else{
                //dd($user->user);
                $user_already_exist = User::where('email',$user->email)->first();

                if(!$user_already_exist){

                    $fullname_words = explode(' ', $user->name);

                    //save image
                    $data = file_get_contents($user->avatar);
                    $filename = uniqid().uniqid(). '.' .'png';
                    Storage::put('users_images/' . $filename, $data);
                    $image_path = 'users_images/' . $filename;

                    $newUser = User::create([
                        // 'name' => $user->user['given_name'],
                        // 'surname' => $user->user['family_name']?$user->user['family_name']:$user->name,
                        'name' => $fullname_words[0],
                        'surname' => $fullname_words[count($fullname_words)-1],
                        'date_of_birth'=> date('Y-m-d',strtotime('01-01-2000')),
                        'email_verified_at' => now()->timestamp,
                        'email' => $user->email,
                        'google_id'=> $user->id,
                        'password' => encrypt('123456dummy'),
                        'image' => $image_path,
                    ]);

                    Auth::login($newUser);

                    return redirect('/home');

                }else{
                    Auth::login($user_already_exist);

                    return redirect('/home');
                }

            }


        } catch (Exception $e) {
            //dd('errore');
            dd($e->getMessage());
        }
    }
}
