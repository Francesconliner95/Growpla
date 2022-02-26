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
        if(!$user->services->contains($service)){
            $user->services()->attach($service);
        }

        return redirect()->route('admin.users.show',$user->id);
    }

    public function edit(Service $service)
    {

        $data = [
            'service' => $service,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.services.edit', $data);
    }

    public function update(Request $request, Service $service)
    {

        $request->validate([
            'name'=> 'required|string',
        ]);

        $data = $request->all();

        $name = Str::lower($request->name);

        $exist = Service::where('name',$name)->first();

        $old_service = $service;

        if(!$exist){
            $new_service = new Service();
            $new_service->name = $name;
            $new_service->save();
        }else{
            $new_service = $exist;
        }

        $user = Auth::user();
        $user->services()->detach($old_service);

        if(!$user->services->contains($new_service)){
            $user->services()->attach($new_service);
        }

        return redirect()->route('admin.users.show',$user->id);
    }

    public function destroy(Service $service)
    {
        $user = Auth::user();
        $user->services()->detach($service);

        return redirect()->route('admin.users.show', ['user' => $user->id]);

    }

}
