<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\MultipleOther;
use App\Other;

class OtherController extends Controller
{
    public function getMultipleSections(Request $request){

        $request->validate([
            'account_id' => 'required|integer',
        ]);

        $account_id = $request->account_id;

        $multipleSections = MultipleOther::where('account_id',$account_id)
                            ->orderBy('position', 'ASC')
                            ->get();

        foreach ($multipleSections as $section) {
            $others = Other::where('multiple_other_id',$section->id)
                    ->orderBy('position', 'ASC')
                    ->limit(1)
                    ->get();
            $other_num = Other::where('multiple_other_id',$section->id)
                        ->count();
            $section['others'] = $others;
            $section['other_num'] = $other_num;
        }

        return response()->json([
            'success' => true,
            'results' => [
                'multipleSections' => $multipleSections,
            ]
        ]);
    }

    public function getSectionOthers(Request $request){

        $request->validate([
            'section_id' => 'required|integer',
        ]);

        $section_id = $request->section_id;

        $multipleSection = MultipleOther::find($section_id);

        $others = Other::where('multiple_other_id',$multipleSection->id)
                    ->orderBy('position', 'ASC')
                    ->get();

        return response()->json([
            'success' => true,
            'results' => [
                'others' => $others,
            ]
        ]);
    }


}
