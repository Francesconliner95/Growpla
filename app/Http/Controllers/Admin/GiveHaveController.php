<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Page;
use App\HavePagePagetype;
use App\HavePageUsertype;
use App\HavePageService;
use App\HavePageCofounder;
use App\HaveUserService;
use App\GiveUserSkill;
use App\GivePageService;
use App\GiveUserService;
use App\Language;
use App\Pagetype;
use App\Usertype;
use App\Service;
use App\Skill;

class GiveHaveController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function getAllHave()
    {
        $needs = [];
        array_push($needs,...HavePagePagetype::select('id','page_id','pagetype_id')->get());
        array_push($needs,...HavePageUsertype::where('usertype_id','!=',1)
        ->select('id','page_id','usertype_id')->get());
        array_push($needs,...HavePageCofounder::select('id','page_id','skill_id')->get());
        array_push($needs,...HavePageService::select('id','page_id','service_id')->get());
        array_push($needs,...HaveUserService::select('id','user_id','service_id')->get());

        $data = [
            'needs'=> $needs,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.needs.index', $data);
    }

    public function getAllGive()
    {
        $offers = [];
        array_push($offers,...GiveUserSkill::select('id','user_id','skill_id')->get());
        array_push($offers,...GivePageService::select('id','page_id','service_id')
        ->get());
        array_push($offers,...GiveUserService::select('id','user_id','service_id')
        ->get());

        $data = [
            'offers'=> $offers,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.offers.index', $data);
    }

    public function loadNeedInfo(Request $request){

        $request->validate([
            'needs' => 'required',
        ]);

        $_needs = $request->needs;
        $needs_info = [];
        foreach ($_needs as $_need) {
            $need = json_decode($_need,true);
            if(array_key_exists('user_id', $need)){
                $need_info = User::where('id',$need['user_id'])
                                  ->select('id','name','surname','image','summary')
                                  ->first();
                $need_info['user_or_page'] = true;
            }
            if(array_key_exists('page_id', $need)){
                $need_info = Page::where('id',$need['page_id'])
                                  ->select('id','name','image','summary')
                                  ->first();
                $need_info['user_or_page'] = false;
            }
            if(array_key_exists('pagetype_id', $need)){
                $need_info['pagetype_id'] = $need['pagetype_id'];
                $need_info['need'] = Pagetype::find($need['pagetype_id'])->name_it;
            }
            if(array_key_exists('usertype_id', $need)){
                $need_info['usertype_id'] = $need['usertype_id'];
                $need_info['need'] = Usertype::find($need['usertype_id'])->name_it;
            }
            if(array_key_exists('service_id', $need)){
                $need_info['service_id'] = $need['service_id'];
                $need_info['need'] = Service::find($need['service_id'])->name;
            }
            if(array_key_exists('skill_id', $need)){
                $need_info['skill_id'] = $need['skill_id'];
                $need_info['need'] = Skill::find($need['skill_id'])->name;
            }
            array_push($needs_info,$need_info);
        }

        return response()->json([
            'success' => true,
            'results' => [
                'needs' => $needs_info,
            ]
        ]);
    }

}
