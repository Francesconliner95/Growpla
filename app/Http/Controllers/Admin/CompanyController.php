<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use App\Page;
use App\Company;
use App\User;
use App\Language;
use Image;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function create()
    {

        $data = [
            'user_id' => Auth::user()->id,
        ];

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        return view('admin.companies.create', $data);
    }

    public function store(Request $request)
    {

        $data = $request->all();

        $user_id = Auth::user()->id;

        $can_create = false;

        if($request->registered_company==0){
            //pagina non iscritta
            if($request->page_id){

                $already_exist = Company::where('user_id',$user_id)
                                ->where('page_id',$request->page_id)
                                ->first();

                if(!$already_exist){
                    $can_create = true;
                }

            }

        }else{
            //pagina iscritta
            if($request->name){
                $can_create = true;
            }

        }

        if($can_create){
            $new_company = new Company();
            $new_company->fill($data);
            $new_company->user_id = Auth::user()->id;

            if(array_key_exists('image', $data)){
                //recupero la path e salvo la nuova l'immagine
                $image_path = Storage::put('companies_images', $data['image']);
                //resize
                $img = Image::make($data['image'])
                            ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                            ->resize(300,300)/*risoluzione*/
                            ->save('./storage/'.$image_path, 100 /*Qualita*/);
                $new_company->image = $image_path;
            }

            $new_company->save();
        }

        return redirect()->route('admin.users.show', ['user' => $user_id]);

    }

    public function edit($id)
    {
        $company = Company::find($id);

        $page = '';
        if($company->page_id){
          $page = Page::find($company->page_id);
        }

        $data = [
            'company' => $company,
            'page' => $page,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.companies.edit', $data);
    }

    public function update(Request $request, Company $company)
    {

        $data = $request->all();
        $user_id = Auth::user()->id;

        $can_update = false;

        if($request->registered_company==0){
            //pagina non iscritta
            if($request->page_id){

                $already_exist = Company::where('user_id',$user_id)
                                ->where('page_id',$request->page_id)
                                ->first();

                if(!$already_exist){
                    $can_update = true;
                }

            }

        }else{
            //pagina iscritta
            if($request->name){
                $can_update = true;
            }

        }

        if($can_update){
            $width = $request->width;
            $height = $request->height;

            if(array_key_exists('image', $data)){
                //SE CARICO UNA NUOVA IMMAGINE
                $old_image_name = $company->image;
                //se la vecchia immagine è diversa da quella di default
                if ($old_image_name) {
                    //elimino la vecchia immagine
                    Storage::delete($old_image_name);
                }
                //recupero la path e salvo la nuova l'immagine
                $image_path = Storage::put('companies_images', $data['image']);
                //resize
                //dd($image_path);
                $img = Image::make($data['image'])
                            ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                            ->resize(300,300)/*risoluzione*/
                            ->save('./storage/'.$image_path, 100 /*Qualita*/);

                $company->image = $image_path;
            }elseif($width && $height){
                //SE HO MODIFICATO L'IMMAGINE ESISTENTE
                $image_path = $company->image;

                if ($image_path) {

                    $filename = rand().time();
                    $ext = pathinfo($image_path, PATHINFO_EXTENSION);
                    $new_path = 'companies_images/'.$filename.'.'.$ext;
                    Storage::move($image_path, $new_path);

                    $img = Image::make('storage/'.$new_path)
                                ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                                ->resize(300,300)/*risoluzione*/
                                ->save('./storage/'.$new_path, 100 /*Qualita*/);
                    $company->image = $new_path;
                }
            }

            $data['image'] = $company->image;
            $company->update($data);
        }

        return redirect()->route('admin.users.show', ['user' => $user_id]);
    }

    public function destroy(Company $company)
    {
        $user = Auth::user();
        if($company->user_id == $user->id){

            if ($company->image){
                Storage::delete($company->image);
            }

            $company->delete();

            return redirect()->route('admin.users.show', ['user' => $user->id]);
        }

    }
}
