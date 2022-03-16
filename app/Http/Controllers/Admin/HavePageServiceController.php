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
use App\Notification;

class HavePageServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function edit($page_id)
    {
        $page = Page::find($page_id);
        $data = [
            'page' => $page,
            'services' => $page->have_page_services,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.have-page-services.edit', $data);
    }

    public function update(Request $request, $page_id)
    {

      $request->validate([
        //'services'=> 'exists:usertypes,id',
      ]);

      $data = $request->all();

      $user = Auth::user();
      $page = Page::find($page_id);

      if($user->pages->contains($page)){


          $services = $request->services;
          $services_id = [];
          foreach ($services as $service_name) {
              $exist = Service::where('name',$service_name)->first();
              if($exist){
                  array_push($services_id, $exist->id);
              }else{
                  if($service_name){
                    $new_service = new Service();
                    $new_service->name = Str::lower($service_name);
                    $new_service->save();
                    array_push($services_id, $new_service->id);
                  }
              }
          }

          if(array_key_exists('services', $data)){
              $syncResult = $page->have_page_services()->sync($services_id);
          }else{
              $syncResult = $page->have_page_services()->sync([]);
          }

          if(collect($syncResult)->flatten()->isNotEmpty()){
              $followers = $page->page_follower;
              foreach ($followers as $follower) {
                  $new_notf = new Notification();
                  $new_notf->user_id = $follower->id;
                  $new_notf->notification_type_id = 4;
                  $new_notf->ref_user_id = null;
                  $new_notf->ref_page_id = $page->id;
                  $new_notf->save();
              }
          }

          return redirect()->route('admin.pages.show',$page->id);

      }abort(404);
  }


}
