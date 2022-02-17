<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Tag;
use App\AccountTag;

class TagController extends Controller
{
    public function getTag(Request $request) {

        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;

        $tags = AccountTag::where('account_id',$account_id)
                ->join('tags','tags.id','=','tag_id')
                ->select('tags.id','tags.name')
                ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'tags' => $tags,
            ]
        ]);
    }

    public function searchTag(Request $request) {

        $request->validate([
            'tag_name' => 'required',
        ]);

        $tag_name = $request->tag_name;

        $tags = Tag::where('name','LIKE', '%'.$tag_name.'%')->get();

        return response()->json([
            'success' => true,
            'results' => [
                'tags' => $tags,
            ]
        ]);
    }

}
