<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\AccountType;
use App\AccountNeed;
use App\Tag;
use App\AccountTag;
use App\Cofounder;
use App\CofounderRole;
use App\AccountStartupservice;

class SearchController extends Controller
{

    public function advancedSearch(Request $request) {

        $request->validate([
            'accountType_id_selected' => 'nullable|integer',
            'startupState_id_selected' => 'nullable|integer',
            'need_id_selected' => 'nullable',
            'region_id_selected' => 'nullable|integer',
            'tags' => 'nullable',
            'account_name' => 'nullable',
            'role' => 'nullable',
            'startupserviceType_selected' => 'nullable|integer',
            'search_page' => 'nullable|integer',
        ]);

        $accountType_id_selected = $request->accountType_id_selected;
        $startupState_id_selected = $request->startupState_id_selected;
        $need_id_selected = $request->need_id_selected;
        $region_id_selected = $request->region_id_selected;
        $tags = $request->tags;
        $account_name = $request->account_name;
        $role = $request->role;
        $startupserviceType_selected = $request->startupserviceType_selected;
        $search_page = $request->search_page;

        function accountNeeds($accounts,$need_id_selected,$role_name){

            $need_id_selected = json_decode($need_id_selected);

            $account_needs = AccountNeed::where('account_type_id',$need_id_selected->accountType)
            ->where('startup_service_id',$need_id_selected->serviceType)
            ->get();

            $accounts_1_filtered = [];

            foreach ($accounts as $account) {
                foreach ($account_needs as $account_need) {
                    if($account->id==$account_need->account_id){
                        array_push($accounts_1_filtered, $account);
                    }
                }
            }

            $accounts_filtered = [];

            if ($need_id_selected->accountType==2 && $role_name) {
                $role = CofounderRole::where('name',$role_name)
                            ->first();
                foreach ($accounts_1_filtered as $account_1_filtered) {
                    $exist_cofounder_need = Cofounder::where('account_id',$account_1_filtered->id)
                            ->where('role_id',$role->id)->first();
                    if($exist_cofounder_need){
                        array_push($accounts_filtered, $account_1_filtered);
                    }
                }
            }

            return $accounts_filtered;

        }

        function accountServiceTypes($accounts,$startupserviceType_selected){

            $account_service_types = AccountStartupservice::where('startup_service_id',$startupserviceType_selected)->get();

            $account_filtered = [];

            foreach ($accounts as $account) {
                foreach ($account_service_types as $account_service_type) {
                    if($account->id==$account_service_type->account_id){
                        array_push($account_filtered, $account);
                    }
                }
            }
            return $account_filtered;

        }

        function accountTags($accounts,$tags){

            $accounts_tags = AccountTag::where('tag_id', $tags)->get();

            $account_filtered = [];

            foreach ($accounts as $account) {
                foreach ($accounts_tags as $accounts_tag) {
                    if($account->id==$accounts_tag->account_id){
                        array_push($account_filtered, $account);
                    }
                }
            }

            return $account_filtered;
        }

        $accounts_query = Account::query();

        if($accountType_id_selected){
            $accounts_query->where('account_type_id',$accountType_id_selected);
        }

        if($accountType_id_selected==1 && $startupState_id_selected){
            $accounts_query
            ->where('startup_status_id',$startupState_id_selected);
        }

        if($region_id_selected){
            $accounts_query->where('region_id',$region_id_selected);
        }

        if($account_name){
            $accounts_query->where('name','LIKE', '%'.$account_name.'%');
        }

        if($accountType_id_selected==2 && $role){
            $accounts_query->where('role','LIKE', '%'.$role.'%');
        }

        $accounts = $accounts_query
        // ->join('account_types','account_types.id','=','accounts.account_type_id')
        ->select('accounts.id','accounts.name','accounts.image','accounts.account_type_id')
        // ->skip($search_page*12)
        // ->take(12)
        ->get();

        //l'oggetto $need_id_selected mi arriva come stringa
        if($accountType_id_selected==1 && $need_id_selected){
            $accounts = accountNeeds($accounts,$need_id_selected,$role);
        }

        if($accountType_id_selected==7 && $startupserviceType_selected){
            $accounts = accountServiceTypes($accounts,$startupserviceType_selected);
        }

        if($tags){
            $accounts = accountTags($accounts,$tags);
        }

        $account_types = AccountType::all();

        foreach ($accounts as $account) {

            $account['account_types_name'] = $account_types[$account->account_type_id-1]->name;

            $account['account_types_name_en'] = $account_types[$account->account_type_id-1]->name_en;

            $account_tags = AccountTag::where('account_id', $account->id)
                            ->get();
            $_tags = [];

            foreach ($account_tags as $account_tag) {
                $tag = Tag::find($account_tag->tag_id);
                array_push($_tags, $tag);
            }

            $account['tags'] = $_tags;

        }

        return response()->json([
            'success' => true,
            'results' => [
                'accounts' => $accounts,
            ]
        ]);
    }

}
