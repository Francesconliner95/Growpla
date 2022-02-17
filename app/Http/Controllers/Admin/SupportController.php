<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use Response;
use App\Support;
use App\SupportType;
use App\Account;
use App\User;
use App\Language;

class SupportController extends Controller
{

    public function switch()
    {

        if(Auth::user()->id==1){
            return redirect()->route('admin.supports.index');
        }else{
            return redirect()->route('admin.supports.create');
        }

    }

    public function index()
    {
        if(Auth::user()->id==1){

            $data = [
                'supportTypes' => SupportType::all(),
            ];

            return view('admin.supports.index', $data);

        }abort(404);

    }

    public function getAllSupports()
    {
        if(Auth::user()->id==1){

            $supports = Support::query()
                        ->join('users','users.id','=','user_id')
                        ->select('supports.id','supports.support_type_id', 'supports.title','supports.readed', 'users.id as user_id', 'users.email')->get();

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
        ];

        return view('admin.supports.create',$data);
    }

    public function store(Request $request){

        $request->validate([
            'file' => 'nullable|mimes:jpeg,png,jpg,gif,swg,pdf|max:4000',
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


        if(Auth::user()->id==1){

            $support->readed = 1;
            $support->update();

            $support::join('users','users.id','=','user_id');

            $exist_account = Account::where('user_id',$support->user_id)->first();

            $support['user_email'] = User::find($support->user_id)->email;

            if($exist_account){
                $support['account_id'] = $exist_account->id;
                $support['account_name'] = $exist_account->name;
            }else{
                $support['account_id'] = 'nope';
                $support['account_name'] = 'nope';
            }
            // dd($support->file->extension());
            //
            // if($support->file->extension()=='pdf'){
            //     $support['file_type'] = 'pdf';
            // }else{
            //     $support['file_type'] = 'image';
            // }

            $data = [
                'support' => $support,
                'supportTypes' => SupportType::all(),
            ];

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
        if(Auth::user()->id==1){

            if ($support->file) {
                Storage::delete($support->file);
            }

            $support->delete();

            return redirect()->route('admin.supports.index');

        }abort(404);
    }
}
