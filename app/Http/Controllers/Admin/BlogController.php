<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use Response;
use App\Language;
use App\Admin;
use App\Blog;
use App\BlogImage;

class BlogController extends Controller
{
    public function index()
    {

        $admins = Admin::pluck('user_id')->toArray();
        if(in_array(Auth::user()->id,$admins)){

            $data = [
                'blogs' => Blog::select('id','title')->latest()->get(),
            ];
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return view('admin.blogs.index',$data);

        }abort(404);
    }

    public function show($id)
    {
        abort(404);
    }

    public function create()
    {
        $admins = Admin::pluck('user_id')->toArray();
        if(in_array(Auth::user()->id,$admins)){

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return view('admin.blogs.create');

        }abort(404);


    }

    public function store(Request $request){

        $request->validate([
            'title' => 'required|string|min:2|max:100',
            'subtitle' => 'nullable|string|max:200',
            'description' => 'required|string|min:20',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:6000'
        ]);

        $admins = Admin::pluck('user_id')->toArray();
        if(in_array(Auth::user()->id,$admins)){

            $data = $request->all();

            $new_blog = new Blog();
            $new_blog->fill($data);
            $new_blog->save();
            $images = $request->images;
            if($images){
                foreach($images as $key => $image) {
                    if($key==0){
                        //la prima immagine
                        $image_path = Storage::put('blog_images', $image);
                        $new_blog->main_image = $image_path;
                    }else{
                        //le altre Immagini
                        //le altre Immagini
                        $image_path = Storage::put('blog_images', $image);
                        $new_blog_image = new BlogImage();
                        $new_blog_image->blog_id = $new_blog->id;
                        $new_blog_image->path = $image_path;
                        $new_blog_image->save();
                    }
                }
            }

            $new_blog->update();

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return redirect()->route('admin.blogs.index');

        }abort(404);

    }


    public function edit(Blog $blog)
    {
        $admins = Admin::pluck('user_id')->toArray();
        if(in_array(Auth::user()->id,$admins)){

            $data = [
                'blog' => $blog,
                'images' => $blog->images,
            ];
            //dd($blog->images);
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return view('admin.blogs.edit',$data);

        }abort(404);
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:100',
            'subtitle' => 'nullable|string|max:200',
            'description' => 'required|string|min:20',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:6000'
        ]);

        //dd($request);

        // dd($request->images);
        $admins = Admin::pluck('user_id')->toArray();
        if(in_array(Auth::user()->id,$admins)){

            $data = $request->all();
            $images = $request->images;

            if($images){
                //aggiungo le nuove immagini
                foreach($images as $key => $image) {
                    if($key==0 && !$blog->main_image){
                        //la prima immagine
                        $image_path = Storage::put('blog_images', $image);
                        $blog->main_image = $image_path;
                    }else{
                        //le altre Immagini
                        $image_path = Storage::put('blog_images', $image);
                        $new_blog_image = new BlogImage();
                        $new_blog_image->blog_id = $blog->id;
                        $new_blog_image->path = $image_path;
                        $new_blog_image->save();
                    }
                }
            }

            $blog->update($data);

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return redirect()->route('admin.blogs.index');

        }abort(404);
    }

    public function deleteBlogImages($id){

        $blog = Blog::find($id);

        $admins = Admin::pluck('user_id')->toArray();
        if(in_array(Auth::user()->id,$admins)){

            $old_main_image = $blog->main_image;
            if ($old_main_image) {
                Storage::delete($old_main_image);
                $blog->main_image = null;
                $blog->update();
            }
            //le altre Immagini
            $old_images = $blog->images;
            foreach ($old_images as $old_image) {
                Storage::delete($old_image->path);
                $old_image->delete();
            }

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return redirect()->route('admin.blogs.edit',$blog->id);

        }abort(404);
    }

    public function destroy(Blog $blog)
    {
        $admins = Admin::pluck('user_id')->toArray();
        if(in_array(Auth::user()->id,$admins)){

            if ($blog->main_image) {
                Storage::delete($blog->main_image);
            }

            $blog->delete();
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return redirect()->route('admin.blogs.index');

        }abort(404);
    }
}
