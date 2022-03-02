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
use App\HavePageService;

class HavePageServiceController extends Controller
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

        return view('admin.have-page-services.create',$data);
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

          $already_exist = HavePageService::where('page_id',$page->id)
                          ->where('service_id',$service->id)
                          ->first();

          if(!$already_exist){
              $new_hps = new HavePageService();
              $new_hps->page_id = $page->id;
              $new_hps->service_id = $service->id;
              $new_hps->save();
          }

          return redirect()->route('admin.pages.show',$page->id);

        }abort(404);


    }

    public function edit($hps_id)
    {


        $hps = HavePageService::find($hps_id);
        $data = [
            'hps' => $hps,
            'service' => Service::find($hps->service_id),
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.have-page-services.edit', $data);
    }

    public function update(Request $request, $hps_id)
    {

        $request->validate([
            'name'=> 'required|string',
        ]);

        $hps = HavePageService::find($hps_id);
        $user = Auth::user();
        $page = Page::find($hps->page_id);

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

            $exist_new_hps = HavePageService::where('page_id',$page->id)
                            ->where('service_id',$service->id)
                            ->first();

            //dd($hps);

            if(!$exist_new_hps){
                $hps->service_id = $service->id;
                $hps->update();
            }else{
                $hps->delete();
            }

            return redirect()->route('admin.pages.show',$page->id);
        }
    }

    public function destroy($hps_id)
    {
        $user = Auth::user();

        $hps = HavePageService::find($hps_id);
        $user = Auth::user();
        $page = Page::find($hps->page_id);

        if($user->pages->contains($page)){
            $hps->delete();
        }

        return redirect()->route('admin.pages.show', ['page' => $page->id]);

    }

}
