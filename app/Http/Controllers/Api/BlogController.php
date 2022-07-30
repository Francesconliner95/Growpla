<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Blog;

class BlogController extends Controller
{
    public function getLatestBlogs(){

        $blogs = Blog::select('id','main_image','title','subtitle','created_at')->latest()->take(8)->get();

        return response()->json([
            'success' => true,
            'results' => [
                'blogs' => $blogs,
            ]
        ]);
    }

    public function loadBlogInfo(Request $request){

        $request->validate([
            'blogs' => 'required',
        ]);

        $_blogs = $request->blogs;

        $blogs_info = [];

        foreach ($_blogs as $_blog) {
            $blog = json_decode($_blog,true);
            $blog_info = Blog::where('id',$blog['id'])->select('id','main_image','title','subtitle','created_at')->first();
            array_push($blogs_info,$blog_info);
        }

        return response()->json([
            'success' => true,
            'results' => [
                'blogs' => $blogs_info,
            ]
        ]);
    }

}
