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
use App\Notification;

class GivePageServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function edit($page_id)
    {
        $page = Page::find($page_id);
        $user = Auth::user();
        if ($user->pages->contains($page)
        && in_array($page->pagetype_id, array(2))) {
            $data = [
                'page' => $page,
                'services' => $page->give_page_services,
                'recommended_services' => $page->pagetype->give_services,
            ];
            //dd($page->pagetype->give_services);

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            return view('admin.give-page-services.edit', $data);
        }abort(404);
    }

    public function update(Request $request, $page_id)
    {

      $request->validate([
        //'services'=> 'exists:usertypes,id',
      ]);

      $data = $request->all();

      $user = Auth::user();
      $page = Page::find($page_id);

      if($user->pages->contains($page)
      && in_array($page->pagetype_id, array(2))){


        $services = $request->services;
        $services_id = [];
        if($services){
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
        }


          //dd($page->give_page_services->contains($services_id)->detached);

          if(array_key_exists('services', $data)){
            $syncResult = $page->give_page_services()->sync($services_id);
          }else{
            $syncResult = $page->give_page_services()->sync([]);
          }

          //verifico se sono state apportate modifiche invio la notifica
          if(collect($syncResult)->flatten()->isNotEmpty()){
              $followers = $page->page_follower;
              foreach ($followers as $follower) {
                  $new_notf = new Notification();
                  $new_notf->user_id = $follower->id;
                  $new_notf->notification_type_id = 5;
                  $new_notf->ref_user_id = null;
                  $new_notf->ref_page_id = $page->id;
                  $new_notf->parameter = $page->id.'/#services';
                  $new_notf->save();
              }
          }
            if($page->tutorial>=1){
                if(in_array($page->pagetype_id, array(2))){
                    return redirect()->route('admin.have-page-services.edit',$page->id);
                }else{
                    $page->tutorial=null;
                    $page->update();
                    return redirect()->route('admin.pages.show',$page->id);
                }
            }else{
                return redirect()->route('admin.pages.show',$page->id);
            }

      }abort(404);
  }

}
