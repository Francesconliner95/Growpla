<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Service;
use App\User;
use App\Language;
use App\HaveUserService;
use App\Notification;

class HaveUserServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function edit($user_id)
    {
        $user = User::find($user_id);
        if($user->id == Auth::user()->id){

          $data = [
              'user' => $user,
              'services' => $user->have_user_services,
              'recommended_services' => Service::where('hidden',null)->get(),
          ];

          app()->setLocale(Language::find(Auth::user()->language_id)->lang);

          return view('admin.have-user-services.edit', $data);

        }abort(404);

    }

    public function update(Request $request, $user_id)
    {

        $request->validate([
            //'services'=> 'exists:usertypes,id',
        ]);

        $data = $request->all();

        $user = Auth::user();

        $user = User::find($user_id);
        if($user->id == Auth::user()->id){

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
                $syncResult = $user->have_user_services()->sync($services_id);
            }else{
                $syncResult = $user->have_user_services()->sync([]);
            }

            if(collect($syncResult)->flatten()->isNotEmpty()){
                $followers = $user->user_follower;
                foreach ($followers as $follower) {
                    $new_notf = new Notification();
                    $new_notf->user_id = $follower->id;
                    $new_notf->notification_type_id = 4;
                    $new_notf->ref_user_id = $user->id;
                    $new_notf->ref_page_id = null;
                    $new_notf->parameter = $user->id.'/#services';
                    $new_notf->save();
                }
            }

            if(Auth::user()->tutorial){
                return redirect()->route('admin.give_user_skills.edit',$user->id);
            }else{
                return redirect()->route('admin.users.show',$user->id);
            }

      }abort(404);
  }

}
