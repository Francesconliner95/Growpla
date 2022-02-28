<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Service;
use App\User;
use App\Page;
use App\Language;
use App\GivePageService;

class GivePageServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function create_service($page_id)
    {
        $data = [
            'page_id' => $page_id,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.give-page-services.create',$data);
    }

    public function store_service(Request $request)
    {

        $request->validate([
            'page_id' => 'required|integer',
            'name'=> 'required|string',
        ]);

        $user = Auth::user();
        $page = Page::find($request->page_id);

        if($user->pages->contains($page)){
          $data = $request->all();

          $name = Str::lower($request->name);

          $exist = Service::where('name',$name)->first();

          if(!$exist){
              $new_service = new Service();
              $new_service->name = $name;
              $new_service->save();
              $service = $new_service;
          }else{
              $service = $exist;
          }

          $user = Auth::user();

          $already_exist = GivePageService::where('page_id',$page->id)
                          ->where('service_id',$service->id)
                          ->first();

          if(!$already_exist){
              $new_gps = new GivePageService();
              $new_gps->page_id = $page->id;
              $new_gps->service_id = $service->id;
              $new_gps->save();
          }

          return redirect()->route('admin.pages.show',$page->id);

        }abort(404);


    }

    public function edit($gps_id)
    {
        $gps = GivePageService::find($gps_id);

        $data = [
            'gps' => $gps,
            'service' => Service::find($gps->service_id),
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.give-page-services.edit', $data);
    }

    public function update(Request $request, $gps_id)
    {

        $request->validate([
            'name'=> 'required|string',
        ]);

        $gps = GivePageService::find($gps_id);
        $user = Auth::user();
        $page = Page::find($gps->page_id);

        if($user->pages->contains($page)){

            $data = $request->all();

            $name = Str::lower($request->name);

            $exist = Service::where('name',$name)->first();

            if(!$exist){
                $new_service = new Service();
                $new_service->name = $name;
                $new_service->save();
                $service = $new_service;
            }else{
                $service = $exist;
            }

            $user = Auth::user();

            $exist_new_gus = GivePageService::where('page_id',$page->id)
                            ->where('service_id',$service->id)
                            ->first();

            //dd($gps);

            if(!$exist_new_gus){
                $gps->service_id = $service->id;
                $gps->update();
            }else{
                $gps->delete();
            }

            return redirect()->route('admin.pages.show',$page->id);
        }
    }

    public function destroy($gps_id)
    {
        $user = Auth::user();

        $gps = GivePageService::find($gps_id);
        $user = Auth::user();
        $page = Page::find($gps->page_id);

        if($user->pages->contains($page)){
            $gps->delete();
        }

        return redirect()->route('admin.pages.show', ['page' => $page->id]);

    }

}
