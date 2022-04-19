<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use DB;
use App\Language;
use App\Usertype;
use App\Pagetype;
use App\Lifecycle;
use App\Sector;
use App\Country;
use App\Page;
use App\User;
use App\GivePageService;
use App\GiveUserService;
use App\HavePageService;
use App\HaveUserService;
use App\HavePagePagetype;
use App\HavePageUsertype;
use App\Service;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function search()
    {
      // if(Auth::user()->tutorial){
      //     return redirect()->route('admin.users.tutorial');
      // }

      $data = [
          'usertypes' => Usertype::where('hidden',null)->get(),
          'pagetypes' => Pagetype::where('hidden',null)->get(),
          'sectors' => Sector::all(),
          'lifecycles' => Lifecycle::all(),
          'countries' => Country::all(),
      ];

      app()->setLocale(Language::find(Auth::user()->language_id)->lang);

      return view('admin.search', $data);

    }

    public function found(Request $request)
    {

        $request->validate([
            'usertypes_id' => 'nullable|array',
            'pagetypes_id' => 'nullable|array',
            'country_id' => 'nullable|integer',
            'region_id' => 'nullable|integer',
            'sector_id' => 'nullable|integer',
            'name' => 'nullable|string',
            //startup
            'lifecycle_id' => 'nullable|integer',
            'need_pagetype_id' => 'nullable|integer',
            'need_usertype_id' => 'nullable|integer',
            //startup e aspirante-cofounder
            'skills_toggle' => 'nullable',
            //servizi
            'services' => 'nullable|array',
            'service_toggle' => 'nullable',
            'service_or_and_toggle' => 'nullable',
            //Settore
            'sectors' => 'nullable',
            'sector_toggle' => 'nullable',
        ]);

        $usertypes_id = $request->usertypes_id;
        $pagetypes_id = $request->pagetypes_id;
        $country_id = $request->country_id;
        $region_id = $request->region_id;
        $sector_id = $request->sector_id;
        $name = $request->name;
        //startup
        $lifecycle_id = $request->lifecycle_id;
        $need_pagetype_id = $request->need_pagetype_id;
        $need_usertype_id = $request->need_usertype_id;
        //startup e aspirante-cofounder
        $skills_toggle = $request->skills_toggle;
        $skills = $request->skills;
        //servizi
        $services_id = $request->services;
        $service_toggle = $request->service_toggle;
        $service_or_and_toggle = $request->service_or_and_toggle;
        //Settore
        $sectors = $request->sectors;
        $sector_toggle = $request->sector_toggle;
        //dd($usertypes_id,$pagetypes_id);
        //TIPO di ricerca
        $search_type = '';
        if($pagetypes_id && $pagetypes_id[0]==1){
            $search_type = 'Startup';
        }
        if($usertypes_id && $usertypes_id[0]==1){
            $search_type = 'Aspiranti Co-founder';
        }
        if($pagetypes_id && $pagetypes_id[0]==3){
            $search_type = 'Incubatori-Acceleratori';
        }
        if($usertypes_id && $usertypes_id[0]==2
        && $pagetypes_id && $pagetypes_id[0]==5
        && !$name){
            $search_type = 'Investitori';
        }
        if(!$pagetypes_id && $usertypes_id && $usertypes_id[0]==2){
            $search_type = 'Business-Angel';
        }
        if(!$usertypes_id && $pagetypes_id && $pagetypes_id[0]==5){
            $search_type = 'Venture-Capital';
        }
        if(!$usertypes_id && $pagetypes_id && $pagetypes_id[0]==7){
            $search_type = 'Organizzazioni ed Associazioni';
        }
        if(!$usertypes_id && $pagetypes_id && $pagetypes_id[0]==8){
            $search_type = 'Private-Equity';
        }
        if(!$usertypes_id && !$pagetypes_id && !$name){
            $search_type = 'Servizi';
        }
        if(!$usertypes_id && !$pagetypes_id  && $name){
            $search_type = $name;
        }
        //dd($usertypes_id,$pagetypes_id,$name,$search_type);

        function needPagetype($pages_input,$need_pagetype_id){

            $pages_output = [];
            foreach ($pages_input as $page) {
                $page_needs = $page->have_page_pagetypes;
                foreach ($page_needs as $page_need) {
                    if($page_need->id==$need_pagetype_id){
                        array_push($pages_output,$page);
                    }
                }
            }
            return $pages_output;

        }

        function needUsertype($pages_input,$need_usertype_id){

            $pages_output = [];
            foreach ($pages_input as $page) {
                $page_needs = $page->have_page_usertypes;
                foreach ($page_needs as $page_need) {
                    if($page_need->id==$need_usertype_id){
                        array_push($pages_output,$page);
                    }
                }
            }
            return $pages_output;

        }

        function filterPageBySkills($pages_input,$skills,$skills_toggle){
            $pages_output = [];

            if (!$skills_toggle) {
                //ricerca pagine che hanno bisogno di cofounders con una di quelle skill
                foreach ($pages_input as $page) {
                    $page_need_skills = $page->have_page_cofounders;
                    foreach ($page_need_skills as $page_need_skill) {
                        foreach ($skills as $skill_id) {
                            if($page_need_skill->id==$skill_id){
                                array_push($pages_output,$page);
                            }
                        }
                    }
                }
            }else{
              //ricerca pagine che hanno bisogno di cofounders con tutte quelle skill
                foreach ($pages_input as $page) {
                    $page_need_skills = $page->have_page_cofounders;
                    $always_exist = true;
                    foreach ($page_need_skills as $page_need_skill) {
                        $skill_exist = false;
                        foreach ($skills as $skill_id) {
                            if($page_need_skill->id==$skill_id){
                                $skill_exist = true;
                            }
                        }
                        if(!$skill_exist){
                            $always_exist = false;
                        }
                    }
                    if($always_exist){
                        array_push($pages_output,$page);
                    }
                }
            }
            return $pages_output;
        }

        function filterUserBySkills($users_input,$skills,$skills_toggle){
            $users_output = [];

            if ($skills_toggle=='false') {
                //ricerca pagine che hanno bisogno di cofounders con una di quelle skill
                foreach ($users_input as $user){
                    $user_skills = $user->give_user_skills;
                    foreach ($user_skills as $user_skill) {
                        foreach ($skills as $skill_id) {
                            if($user_skill->id==$skill_id){
                                array_push($users_output,$user);
                            }
                        }
                    }
                }
            }else{
                //ricerca pagine che hanno bisogno di cofounders con tutte quelle skill
                foreach ($users_input as $user) {
                    $user_skills = $user->give_user_skills;
                    $always_exist = true;
                    foreach ($user_skills as $user_skill) {
                        $skill_exist = false;
                        foreach ($skills as $skill_id) {
                            if($user_skill->id==$skill_id){
                                $skill_exist = true;
                            }
                        }
                        if(!$skill_exist){
                            $always_exist = false;
                        }
                    }
                    if($always_exist){
                        array_push($users_output,$user);
                    }
                }
            }
            return $users_output;
        }

        function filterPageBySectors($pages_input,$sectors,$sector_toggle){
            $pages_output = [];

            if (!$sector_toggle) {
                foreach ($pages_input as $page) {
                    $page_sectors = $page->sectors;
                    foreach ($page_sectors as $page_sector) {
                        foreach ($sectors as $sector_id) {
                            if($page_sector->id==$sector_id){
                                array_push($pages_output,$page);
                            }
                        }
                    }
                }
            }else{
                foreach ($pages_input as $page) {
                    $page_sectors = $page->sectors;
                    $always_exist = true;
                    foreach ($sectors as $sector_id) {
                        $sector_exist = false;
                        foreach ($page_sectors as $page_sector) {
                            if($page_sector->id==$sector_id){
                                $sector_exist = true;
                            }
                        }
                        if(!$sector_exist){
                            $always_exist = false;
                        }
                    }
                    if($always_exist){
                        array_push($pages_output,$page);
                    }
                }
            }
            return $pages_output;
        }

        function filterUserBySectors($users_input,$sectors,$sector_toggle){
            $users_output = [];

            if (!$sector_toggle) {
                foreach ($users_input as $user) {
                    $user_sectors = $user->sectors;
                    foreach ($user_sectors as $user_sector) {
                        foreach ($sectors as $sector_id) {
                            if($user_sector->id==$sector_id){
                                array_push($users_output,$user);
                            }
                        }
                    }
                }
            }else{
                foreach ($users_input as $user) {
                    $user_sectors = $user->sectors;
                    $always_exist = true;
                    foreach ($sectors as $sector_id) {
                        $sector_exist = false;
                        foreach ($user_sectors as $user_sector) {
                            if($user_sector->id==$sector_id){
                                $sector_exist = true;
                            }
                        }
                        if(!$sector_exist){
                            $always_exist = false;
                        }
                    }
                    if($always_exist){
                        array_push($users_output,$page);
                    }
                }
            }
            return $users_output;
        }

        function filterUserByServices($users_input,$services,$service_or_and_toggle){

            $users_output = [];
            //dd($service_or_and_toggle);
            if (!$service_or_and_toggle) {
                foreach ($users_input as $user) {
                    $user_services = $user->give_user_services;
                    foreach ($user_services as $user_service) {
                        foreach ($services as $service_id) {
                            if($user_service->id==$service_id){
                                array_push($users_output,$user);
                            }
                        }
                    }
                }
            }else{

                foreach ($users_input as $user) {
                    $user_services = $user->give_user_services;
                    $always_exist = true;
                    foreach ($services as $service_id) {
                        $service_exist = false;
                        foreach ($user_services as $user_service) {
                            if($user_service->id==$service_id){
                                $service_exist = true;
                            }
                        }
                        if(!$service_exist){
                            $always_exist = false;
                        }
                    }
                    if($always_exist){
                        array_push($users_output,$user);
                    }
                }
            }
            return $users_output;
        }

        $users = [];
        $pages = [];

        //PAGINE
        if($pagetypes_id){

            $pages_query = Page::query();

            foreach ($pagetypes_id as $pagetype_id) {
                $pages_query->orWhere('pagetype_id',$pagetype_id);
            }

            //all
            if($country_id){
                $pages_query->where('country_id',$country_id);
            }

            if($region_id){
                $pages_query->where('region_id',$region_id);
            }

            //startup
            if($lifecycle_id){
                $pages_query->where('lifecycle_id',$lifecycle_id);
            }

            $pages = $pages_query/*->select('id')*/->get();

            if($need_pagetype_id){
                $pages_input = $pages;
                $pages = needPagetype($pages_input,$need_pagetype_id);
            }

            if($need_usertype_id){
                $pages_input = $pages;
                $pages = needUsertype($pages_input,$need_usertype_id);
                //se la startup cerca un aspirante cofounder e ha specificato le skills controllo anche le skills
                if($need_usertype_id==1 && $skills){
                    $pages_input = $pages;
                    $pages = filterPageBySkills($pages_input,$skills,$skills_toggle);
                }
            }

            if($sectors){
                $pages_input = $pages;
                $pages = filterPageBySectors($pages_input,$sectors,$sector_toggle);
            }
            //dd($pages);

        }
        //UTENTI

        if($usertypes_id){

          $users = [];

          if($usertypes_id){
              $usertypes = Usertype::find($usertypes_id);
              foreach ($usertypes as $usertype) {
                  $users_found = $usertype->users;
                  if($users_found){
                      array_push($users,...$users_found);
                  }
              }
          }

          //all
          if($country_id){
              $users_temp = $users;
              $users = [];
              foreach ($users_temp as $user) {
                  if($user->country_id==$country_id){
                      array_push($users,$user);
                  }
              }
          }

          if($region_id){
              $users_temp = $users;
              $users = [];
              foreach ($users_temp as $user) {
                  if($user->region_id==$region_id){
                      array_push($users,$user);
                  }
              }
          }

          //aspirante cofounder
          if(in_array(1, $usertypes_id) && $skills){
              $users_input = $users;
              $users = filterUserBySkills($users_input,$skills,$skills_toggle);
          }

          if($sectors){
              $users_input = $users;
              $users = filterUserBySectors($users_input,$sectors,$sectors_toggle);
          }

          if($services_id){
              $users_input = $users;
              $users = filterUserByServices($users_input,$services_id,$service_or_and_toggle);
          }

          //dd($users);

        }

        //SERVIZI
        if(!$usertypes_id && !$pagetypes_id && !$name){
            if($service_toggle=="false"){
                //profili che offrono il servizio
                if($services_id){
                    //se i servizi sono stati specificati
                    if($service_or_and_toggle=='false'){
                        //OR
                        //pagine
                        $pages = GivePageService::query();
                        foreach($services_id as $service_id){
                            $pages = $pages->orWhere('service_id',$service_id);
                        }
                        $pages =
                        $pages->join('pages','pages.id','=','give_page_services.page_id')->get();
                        //utenti
                        $users = GiveUserService::query();
                        foreach($services_id as $service_id){
                            $users = $users->orWhere('service_id',$service_id);
                        }
                        $users =
                        $users->join('users','users.id','=','give_user_services.user_id')->get();
                    }else{
                        //AND
                        $services = Service::find($services_id);
                        //pagine
                        $pages = [];
                        foreach($services as $service){
                            $service_pages = $service->give_page_services;
                            foreach ($service_pages as $service_page) {
                                array_push($pages,$service_page);
                            }
                        }
                        $pages_output = [];
                        foreach ($pages as $page) {
                            $page_count = 0;
                            foreach ($pages as $page_for) {
                                if($page->id==$page_for->id){
                                    $page_count++;
                                }
                            }
                            if($page_count==count($services) && !in_array($page->id,$pages_output)){
                                array_push($pages_output,$page->id);
                            }
                        }
                        $pages = Page::find($pages_output);
                        //utenti
                        $users = [];
                        foreach($services as $service){
                            $service_users = $service->give_user_services;
                            foreach ($service_users as $service_user) {
                                array_push($users,$service_user);
                            }
                        }
                        $users_output = [];
                        foreach ($users as $user) {
                            $user_count = 0;
                            foreach ($users as $user_for) {
                                if($user->id==$user_for->id){
                                    $user_count++;
                                }
                            }
                            if($user_count==count($services) && !in_array($user->id,$users_output)){
                                array_push($users_output,$user->id);
                            }
                        }
                        $users = User::find($users_output);
                    }

                }else{
                    $pages = GivePageService::join('pages','pages.id','=','give_page_services.page_id')
                    ->get();
                    //se i servizi non sono stati specificati
                    $users = GiveUserService::join('users','users.id','=','give_user_services.user_id')
                    ->get();

                }
                $pages = $pages->unique('id');
                $users = $users->unique('id');
                //controllo se ci sono pagine doppie
            }else{
                //profili che CERCANO il servizio
                if($services_id){
                    //se i servizi sono stati specificati
                    if($service_or_and_toggle=='false'){
                        //OR
                        //pagine
                        $pages = HavePageService::query();
                        foreach($services_id as $service_id){
                            $pages = $pages->orWhere('service_id',$service_id);
                        }
                        $pages =
                        $pages->join('pages','pages.id','=','have_page_services.page_id')->get();
                        //utenti
                        $users = HaveUserService::query();
                        foreach($services_id as $service_id){
                            $users = $users->orWhere('service_id',$service_id);
                        }
                        $users =
                        $users->join('users','users.id','=','have_user_services.user_id')->get();
                    }else{
                        //AND
                        $services = Service::find($services_id);
                        //pagine
                        $pages = [];
                        foreach($services as $service){
                            $service_pages = $service->have_page_services;
                            foreach ($service_pages as $service_page) {
                                array_push($pages,$service_page);
                            }
                        }
                        $pages_output = [];
                        foreach ($pages as $page) {
                            $page_count = 0;
                            foreach ($pages as $page_for) {
                                if($page->id==$page_for->id){
                                    $page_count++;
                                }
                            }
                            if($page_count==count($services) && !in_array($page->id,$pages_output)){
                                array_push($pages_output,$page->id);
                            }
                        }
                        $pages = Page::find($pages_output);
                        //utenti
                        $users = [];
                        foreach($services as $service){
                            $service_users = $service->have_user_services;
                            foreach ($service_users as $service_user) {
                                array_push($users,$service_user);
                            }
                        }
                        $users_output = [];
                        foreach ($users as $user) {
                            $user_count = 0;
                            foreach ($users as $user_for) {
                                if($user->id==$user_for->id){
                                    $user_count++;
                                }
                            }
                            if($user_count==count($services) && !in_array($user->id,$users_output)){
                                array_push($users_output,$user->id);
                            }
                        }
                        $users = User::find($users_output);
                    }

                }else{
                    $pages = HavePageService::join('pages','pages.id','=','have_page_services.page_id')
                    ->get();
                    //se i servizi non sono stati specificati
                    $users = HaveUserService::join('users','users.id','=','have_user_services.user_id')
                    ->get();

                }
                $pages = $pages->unique('id');
                $users = $users->unique('id');
                //controllo se ci sono pagine doppie

            }
        }

        //RICERCA PER NOME
        if(!$usertypes_id && !$pagetypes_id && $name){
            //dd($name);
            $users = User::where(DB::raw("concat(name, ' ', surname)"), 'LIKE', "%".$name."%")
            ->get();

            $pages = Page::where('name','LIKE', "%".$name."%")
            ->get();
        }

        $pages_id = [];
        if($pages){
            foreach ($pages as $page) {
                $page_id = [
                  "id" => $page->id,
                  // "name" => $page->name,
                  // "image" => $page->image,
                  "user_or_page" => false,
                ];
                array_push($pages_id,$page_id);
            }
        }
        $users_id = [];
        if($users){
            foreach ($users as $user) {
                $user_id = [
                  "id" => $user->id,
                  // "name" => $user->name,
                  // "surname" => $user->surname,
                  // "image" => $user->image,
                  "user_or_page" => true,
                ];
                array_push($users_id,$user_id);
            }
        }

        $data = [
            'search_type' => $search_type,
            'pages_id' => $pages_id,
            'users_id' => $users_id,
        ];

        //dd($data);

        // $account_info = Page::where('id',5)
        //                     ->select('id','name','image','summary','pagetype_id')
        //                     ->first();
        // $account_info['user_or_page'] = false;
        // $account_info['sectors'] = $account_info->sectors;
        // $account_info['give'] = $account_info->give_page_services;
        // $have_services = $account_info->have_page_services;
        // if($account_info->pagetype_id==1){
        //     $have_pagetypes = $account_info->have_page_pagetypes;
        //     $have_usertypes = $account_info->have_page_usertypes;
        // }
        // $have = array(...$have_services,...$have_pagetypes,...$have_usertypes);
        // dd($have);

        return view('admin.found', $data);

  }

    public function loadInfo(Request $request){

        $request->validate([
            'accounts' => 'required',
        ]);

        $_accounts = $request->accounts;
        $accounts_info = [];
        foreach ($_accounts as $_account) {
            $account = json_decode($_account);
            if($account->user_or_page){
                $account_info = User::where('id',$account->id)
                ->select('id','name','surname','image','summary')
                ->first();
                $account_info['user_or_page'] = true;
                $account_info['sectors'] = $account_info->sectors;
                $account_info['give'] = $account_info->give_user_services;
                $account_info['have'] = $account_info->have_user_services;
            }else{
                $account_info = Page::where('id',$account->id)
                ->select('id','name','image','summary',/*'pagetype_id'*/)
                ->first();
                $account_info['user_or_page'] = false;
                $account_info['sectors'] = $account_info->sectors;
                $account_info['give'] = $account_info->give_page_services;
                $have_services = $account_info->have_page_services;
                // if(array_key_exists($account_info['pagetype_id']) && $account_info->pagetype_id==1){
                    $have_pagetypes = $account_info->have_page_pagetypes;
                    $have_usertypes = $account_info->have_page_usertypes;
                // }
                $account_info['have'] = array(...$have_pagetypes,...$have_usertypes,...$have_services);
            }
            array_push($accounts_info,$account_info);
        }

        return response()->json([
            'success' => true,
            'results' => [
                'accounts' => $accounts_info,
            ]
        ]);

    }

}
