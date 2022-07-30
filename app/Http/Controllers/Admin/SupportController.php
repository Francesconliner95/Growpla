<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use Response;
use App\Language;
use App\Support;
use App\SupportType;
use App\User;
use App\Usertype;
use App\Page;
use App\Pagetype;
use App\Collaboration;
use App\Chat;
use App\Message;
use App\Follow;
use App\HavePageService;
use App\HavePageUsertype;
use App\HavePagePagetype;
use App\HaveUserService;
use App\GivePageService;
use App\GiveUserService;
use App\Admin;

class SupportController extends Controller
{

    public function index()
    {
        $admins = Admin::pluck('user_id')->toArray();
        if(in_array(Auth::user()->id,$admins)){

            $usertypes_count = [];
            $usertypes = Usertype::where('hidden',null)->get();
            foreach ($usertypes as $usertype) {
                array_push($usertypes_count,$usertype->users->count());
            }
            $usertypes_obj = [
                'name'=> Usertype::where('hidden',null)->pluck('name_it')->toArray(),
                'count' => $usertypes_count,
            ];

            $users_date = User::all()->pluck('created_at')->toArray();
            $pages_date = Page::all()->pluck('created_at')->toArray();
            $users_complete_date = User::where('tutorial',null)->pluck('created_at')->toArray();
            $users_not_complete_date = User::where('tutorial',1)->pluck('created_at')->toArray();
            //dd($users_date);

            $data = [
                'user' => User::count(),
                'page' => Page::count(),
                'user_complete' => User::where('tutorial',null)->count(),
                'page_complete' => Page::where('tutorial',null)->count(),
                'usertypes' => $usertypes_obj,
                'pagetypes' => Pagetype::where('hidden',null)->get(),
                'users_date' => $users_date,
                'pages_date' => $pages_date,
                'users_complete_date' => $users_complete_date,
                'users_not_complete_date' => $users_not_complete_date,
                'collaborations_ver' => Collaboration::where('col1_confirmed',1)
                                                    ->where('col2_confirmed',1)
                                                    ->count(),
                'collaborations_rec' => Collaboration::where('col1_show',null)
                                                    ->where('col1_show',null)
                                                    ->count(),
                'chats_cont' => Chat::count(),
                'messages_cont' => Message::count(),
                'follows_cont' => Follow::count(),
                'offers_cont' => GivePageService::count() +
                                 GiveUserService::count(),
                'needs_cont' => HavePageService::count() +
                                HavePageUsertype::count() +
                                HavePagePagetype::count() +
                                HaveUserService::count(),
                'supportTypes' => SupportType::all(),
            ];
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return view('admin.supports.index', $data);

        }abort(404);

    }

    public function getAllSupports()
    {
        $admins = Admin::pluck('user_id')->toArray();
        if(in_array(Auth::user()->id,$admins)){

            $supports = Support::query()
                        ->join('users','users.id','=','user_id')
                        ->select('supports.id','supports.support_type_id', 'supports.title','supports.readed', 'users.id as user_id', 'users.email','users.name','users.surname')->get();

            return response()->json([
                'success' => true,
                'results' => [
                    'supports' => $supports,
                    'supportTypes' => SupportType::all(),
                ]
            ]);

        }

    }

    public function create()
    {
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        $data = [
            'supportTypes' => SupportType::all(),
            'lang' => Auth::user()->language_id,
            'admins' => Admin::pluck('user_id')->toArray(),
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.supports.create',$data);
    }

    public function store(Request $request){

        $request->validate([
            'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf|max:4000',
            'support_type_id' => 'required|integer',
            'title' => 'required|string|min:2|max:100',
            'description' => 'required|string|min:20',
        ]);

        $new_support = new Support();
        $new_support->user_id = Auth::user()->id;
        $new_support->support_type_id = $request->support_type_id;
        $new_support->title = $request->title;
        $new_support->description = $request->description;

        if($request->file){
            $file_path = Storage::put('supports_files', $request->file);
            $new_support->file = $file_path;
        }

        $new_support->save();
        return redirect()->route('admin.supports.success');

    }

    public function success()
    {
        return view('admin.supports.success');
    }

    public function show(Support $support)
    {


        $admins = Admin::pluck('user_id')->toArray();
        if(in_array(Auth::user()->id,$admins)){

            $support->readed = 1;
            $support->update();

            $data = [
                'support' => $support,
                'supportTypes' => SupportType::all(),
                'user' => User::find($support->user_id),
            ];
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return view('admin.supports.show', $data);

        }abort(404);
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Support $support)
    {
        $admins = Admin::pluck('user_id')->toArray();
        if(in_array(Auth::user()->id,$admins)){

            if ($support->file) {
                Storage::delete($support->file);
            }

            $support->delete();
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return redirect()->route('admin.supports.index');

        }abort(404);
    }
}
