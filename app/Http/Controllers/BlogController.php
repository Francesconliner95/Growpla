<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Language;
use App\Blog;

class BlogController extends Controller
{

    public function index(){

        $data = [
            'blogs' => Blog::select('id')->latest()->get(),
        ];
        
        app()->setLocale('it');
        return view('guest.blogs.index',$data);

    }

    public function show(Blog $blog){

        $data = [
            'blog' => $blog,
            'images' => $blog->images,
        ];

        app()->setLocale('it');
        return view('guest.blogs.show',$data);

    }


}
