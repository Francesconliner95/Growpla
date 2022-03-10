<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Account;
use App\Cooperation;
use App\Chat;
use App\Language;

class HomeController extends Controller
{

    public function index(){

        // $consentScreen = Cookie::has('consentScreen') ?
        // Cookie::get("consentScreen") : Cookie::queue("consentScreen", 'accettato', 4555);

        //LINGUA
        // dd(preg_split('/,|;/',request()->server('HTTP_ACCEPT_LANGUAGE'))[1]);
        // $lang =
        // preg_split('/,|;/',request()->server('HTTP_ACCEPT_LANGUAGE'))[1];
        //
        // $languages = Language::all();
        //
        // $set_lang = false;
        //
        // foreach ($languages as $language) {
        //     if($language->lang == $lang){
        //         app()->setLocale($lang);
        //         $set_lang = true;
        //         $language_id = $language->id;
        //     }
        // }

        // if(!$set_lang){
        //     app()->setLocale('en');
        //     $language_id = 1;
        // }

        // $accounts = Account::all()->count();
        // $cooperations = Cooperation::all()->count();
        // $chats = Chat::all()->count();

        $data = [
            'accounts' => /*$accounts*/1,
            'cooperations' => /*$cooperations*/1,
            'chats' => /*$chats*/1,
            'language_id' => /*$language_id*/1,
        ];

        //se gia loggato mi resta nell pagina admin finche non faccio logout
        if(Auth::check()){
            return redirect()->route('admin.search');
        }else{
            return view('guest.pre-home');
            //return view('guest.home',$data);
        }
    }

    public function privacyPolicy(){

        if(Auth::check()){
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        }else{
            $lang =
            preg_split('/,|;/',request()->server('HTTP_ACCEPT_LANGUAGE'))[1];

            $languages = Language::all();

            $set_lang = false;

            foreach ($languages as $language) {
                if($language->lang == $lang){
                    app()->setLocale($lang);
                    $set_lang = true;
                    $language_id = $language->id;
                }
            }

            if(!$set_lang){
                app()->setLocale('en');
                $language_id = 1;
            }
        }

        return view('guest.privacy-policy');

    }

    public function termsAndConditions(){

        if(Auth::check()){
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        }else{
            $lang =
            preg_split('/,|;/',request()->server('HTTP_ACCEPT_LANGUAGE'))[1];

            $languages = Language::all();

            $set_lang = false;

            foreach ($languages as $language) {
                if($language->lang == $lang){
                    app()->setLocale($lang);
                    $set_lang = true;
                    $language_id = $language->id;
                }
            }

            if(!$set_lang){
                app()->setLocale('en');
                $language_id = 1;
            }
        }

        return view('guest.terms-and-conditions');

    }

    public function cookiePolicy(){

        if(Auth::check()){
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        }else{
            $lang =
            preg_split('/,|;/',request()->server('HTTP_ACCEPT_LANGUAGE'))[1];

            $languages = Language::all();

            $set_lang = false;

            foreach ($languages as $language) {
                if($language->lang == $lang){
                    app()->setLocale($lang);
                    $set_lang = true;
                    $language_id = $language->id;
                }
            }

            if(!$set_lang){
                app()->setLocale('en');
                $language_id = 1;
            }
        }

        return view('guest.cookie-policy');

    }

}
