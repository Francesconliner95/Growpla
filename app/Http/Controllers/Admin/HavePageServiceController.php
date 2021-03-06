<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\MainService;
use App\Service;
use App\User;
use App\Page;
use App\Language;
use App\HavePageService;
use App\HavePageUsertype;
use App\HavePagePagetype;
use App\Lifecycle;
use App\Pagetype;
use App\Usertype;
use App\Notification;

use App\Skill;

class HavePageServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function edit($page_id)
    {
        $page = Page::find($page_id);
        $user = Auth::user();
        $recommended_services = [];
        if($page->pagetype_id==1){
            switch ($page->lifecycle_id) {
                case 1:
                    $serviceRecommended = [39,40,41,42,43,44];
                break;
                case 2:
                    $serviceRecommended = [39,40,43,44];
                break;
                case 3:
                    $serviceRecommended = [40,43,44];
                break;
                case 4:
                    $serviceRecommended = [40,44];
                break;
                case 5:
                    $serviceRecommended = [40,44];
                break;
                case 6:
                    $serviceRecommended = [40,44];
                break;
                case 7:
                    $serviceRecommended = [38];
                break;
                default:
                $serviceRecommended = [];
            }
            $recommended_services = Service::find($serviceRecommended);
        }else{
            $recommended_services = $page->pagetype->have_services;
        }
        if ($user->pages->contains($page)
        && in_array ($page->pagetype_id, array(1,2))) {
            $data = [
                'page' => $page,
                'services' => $page->have_page_services,
                'recommended_services' => $recommended_services,
                'lifecycles' => Lifecycle::all(),
                'pagetypes' => Pagetype::where('hidden',null)->get(),
                'usertypes' => Usertype::where('hidden',null)->get(),
                'cofounder_services' => $page->have_page_cofounders,
            ];
            //dd($page->pagetype->have_services->where('hidden',null));

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            return view('admin.have-page-services.edit', $data);
        }abort(404);
    }

    public function update(Request $request, $page_id)
    {
        //dd($request);
        $request->validate([
            // 'services'=> 'exists:services,id',
            'usertypes'=> 'exists:usertypes,id',
            'pagetypes'=> 'exists:pagetypes,id',
        ]);

        $data = $request->all();

        $user = Auth::user();
        $page = Page::find($page_id);

        if($user->pages->contains($page)
        && in_array ($page->pagetype_id, array(1,2))){
            $services = $request->services;
            $services_id = [];
            if($services){
                foreach ($services as $service_name) {
                    $exist = Service::where('name',$service_name)->first();
                    if($exist){
                        array_push($services_id, $exist->id);
                    }
                }
            }

            if(array_key_exists('services', $data)){
                $syncResult = $page->have_page_services()->sync($services_id);
            }else{
                $syncResult = $page->have_page_services()->sync([]);
            }

            if(collect($syncResult)->flatten()->isNotEmpty()  && count($services_id)>0){
                $followers = $page->page_follower;
                foreach ($followers as $follower) {
                    $new_notf = new Notification();
                    $new_notf->user_id = $follower->id;
                    $new_notf->notification_type_id = 6;
                    $new_notf->ref_user_id = null;
                    $new_notf->ref_page_id = $page->id;
                    $new_notf->parameter = $page->id.'/#services';
                    $new_notf->save();
                }
            }

            if($page->pagetype_id==1){
                $data = $request->all();
                $user = Auth::user();

                //se non ho selezionato il ruolo dell'aspirante cofounder rimuovo la spunta che cerco aspirante cofounder
                if(array_key_exists('usertypes', $data)){
                    if(in_array(1, $data['usertypes'])){
                        if(!$request->cofounder_services_id){
                            foreach ($data['usertypes'] as $key => $usertype) {
                                if($usertype==1){
                                    unset($data['usertypes'][$key]);
                                }
                            }
                            $data['usertypes'] = array_values($data['usertypes']);
                        }
                    }
                }

                //Necessit?? tipo di utente
                if(array_key_exists('usertypes', $data)){
                    $page->have_page_usertypes()->sync($data['usertypes']);
                }else{
                    $page->have_page_usertypes()->sync([]);
                }

                $cofounder_services_id = $request->cofounder_services_id;
                //se ?? stata slezionata la voce aspirante-cofounder
                if($page->have_page_usertypes->contains(1) && $cofounder_services_id){

                    if(array_key_exists('cofounder_services_id', $data)){
                        $page->have_page_cofounders()->sync($cofounder_services_id);
                    }else{
                        $page->have_page_cofounders()->sync([]);
                    }

                }else{
                    $page->have_page_cofounders()->sync([]);
                }

                if(array_key_exists('pagetypes', $data)){
                    $page->have_page_pagetypes()->sync($data['pagetypes']);
                }else{
                  $page->have_page_pagetypes()->sync([]);
                }

            }

            if($page->tutorial>=1){
                $page->tutorial = null;
                $page->update();
            }

            if(array_key_exists('go_to_collaborations', $data)){
                return redirect()->route('admin.collaborations.my', [$page->id,'page']);
            }else{
                return redirect()->route('admin.pages.show',$page->id);
            }

        }abort(404);
    }

}
