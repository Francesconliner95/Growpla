<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Service;
use App\User;
use App\Language;
use App\GiveUserService;

class GiveUserServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function create()
    {

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.services.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name'=> 'required|string',
        ]);

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

        $already_exist = GiveUserService::where('user_id',$user->id)
                        ->where('service_id',$service->id)
                        ->first();

        if(!$already_exist){
            $new_gus = new GiveUserService();
            $new_gus->user_id = $user->id;
            $new_gus->service_id = $service->id;
            $new_gus->save();
        }

        return redirect()->route('admin.users.show',$user->id);
    }

    public function edit($id)
    {

        $gus = GiveUserService::find($id);


        $data = [
            'gus' => $gus,
            'service' => Service::find($gus->service_id),
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.services.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name'=> 'required|string',
        ]);

        $gus = GiveUserService::find($id);

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

        $exist_new_gus = GiveUserService::where('user_id',$user->id)
                        ->where('service_id',$service->id)
                        ->first();

        //dd($gus);

        if(!$exist_new_gus){
            $gus->service_id = $service->id;
            $gus->update();
        }else{
            $gus->delete();
        }

        return redirect()->route('admin.users.show',$user->id);
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $gus = GiveUserService::find($id);

        if($gus->user_id==$user->id){
            $gus->delete();
        }

        return redirect()->route('admin.users.show', ['user' => $user->id]);

    }

}
