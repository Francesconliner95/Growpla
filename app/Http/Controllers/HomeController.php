<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Language;
use App\Incubator;
use App\Region;

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
        app()->setLocale('it');
        $language_id = 2;

        //se gia loggato mi resta nell pagina admin finche non faccio logout
        if(Auth::check()){
            return redirect()->route('admin.search');
        }else{
            return view('guest.home');
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
                app()->setLocale('it');
                $language_id = 2;
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
                app()->setLocale('it');
                $language_id = 2;
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
                app()->setLocale('it');
                $language_id = 2;
            }
        }

        return view('guest.cookie-policy');

    }

    public function incubators()
    {

        $data = [
            // 'incubators' => Incubator::where('hidden',null)
            // ->join('regions','regions.id','=','incubators.region_id')
            // ->select('incubators.*','regions.name as region_name')
            // ->orderBy('name')->get(),
            'regions' => Region::all(),
        ];

        app()->setLocale('it');
        return view('guest.incubators', $data);
    }

}
