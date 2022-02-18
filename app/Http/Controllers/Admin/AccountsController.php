<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\MailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use File;
use Response;
use App\Account;
use App\User;
use App\AccountType;
use App\StartupState;
use App\StartupserviceType;
use App\Team;
use App\Other;
use App\AccountNeed;
use App\Cofounder;
use App\CofounderRole;
use App\Region;
use App\MultipleOther;
use App\Follow;
use App\Notification;
use App\Company;
use App\Currency;
use App\View;
use App\Language;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests;
use Image;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //Accetta automaticamente cookie quando eseguo il login
        //Cookie::queue("tecCookie", 'accept', 260000); //durata 6 mesi

        $my_accounts = Account::where('user_id', Auth::user()->id)
                        ->join('account_types','account_types.id','=','account_type_id')
                        ->select('accounts.id', 'accounts.name', 'accounts.image', 'account_types.name as accountTypeName')
                        //nel caso le tabbelle unite hanno colonne con lo stesso nome ne cambio il nome con 'as'
                        ->get();


        if(!Auth::user()->account_id && count($my_accounts)>0){
            Auth::user()->account_id = $my_accounts[0]->id;
        }

        Auth::user()->last_login = Carbon::now();
        Auth::user()->update();

        app()->setLocale(Language::find(Auth::user()->language_id)->lang);

        //CONTROLLO STATO DI COMPILAZIONE PROPRIO ACCOUNT
        if(Auth::user()->account_id){
            $account = Account::find(Auth::user()->account_id);
            if(!$account->description){
                return redirect()->route('admin.accounts.edit', $account->id);
            }
            if($account->account_type_id==1
            && !$account->startup_status_id){
                return redirect()->route('admin.needs.edit', $account->id);
            }
        }

        $needs = AccountNeed::orderBy('id', 'desc')->take(9)
        ->join('accounts', 'accounts.id', '=', 'account_needs.account_id')
        ->select('accounts.id','accounts.name','account_needs.account_type_id','account_needs.startup_service_id')
        ->get();

        foreach ($needs as $need) {
            if($need->account_type_id==7){
                $need['need_name'] = StartupserviceType::find($need->startup_service_id)->name;
            }else{
                $need['need_name'] = AccountType::find($need->account_type_id)->name;
            }
        }

        //dd($needs);

        $data = [
            'my_accounts' => $my_accounts,
            'needs' => $needs,
        ];

        return view('admin.accounts.index', $data);

    }

    public function getMyAccounts(){

        $my_accounts = Account::where('user_id', Auth::user()->id)
                        ->join('account_types','account_types.id','=','account_type_id')
                        ->select('accounts.id', 'accounts.image', 'accounts.name', 'account_types.name as accountTypeName')
                        //nel caso le tabbelle unite hanno colonne con lo stesso nome ne cambio il nome con 'as'
                        ->get();

        $account_selected = Account::where('id',Auth::user()->account_id)
                            ->select('accounts.id', 'accounts.image', 'accounts.name')
                            ->first();

        if (!$account_selected) {
            $account_selected = Account::where('user_id',Auth::user()->id)
            ->select('accounts.id', 'accounts.image', 'accounts.name')
            ->first();
        }

        return response()->json([
            'success' => true,
            'results' => [
                'account_selected' => $account_selected,
                'my_accounts' => $my_accounts,
            ]
        ]);

    }

    public function setAccount(Request $request){

        $request->validate([
            'account_selected_id' => 'required|integer',
        ]);

        $account_selected_id = $request->account_selected_id;

        $is_my_account = Account::where('id', $account_selected_id)
                        ->where('user_id',Auth::user()->id)
                        ->first();

        if($is_my_account){
            Auth::user()->account_id = $account_selected_id;
            Auth::user()->update();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $my_account = Account::where('user_id', Auth::user()->id)->first();

        if(!$my_account){


            $lang_id=Auth::user()->language_id;
            app()->setLocale(Language::find($lang_id)->lang);

            $data = [
                'lang_id' => $lang_id,
            ];

            return view('admin.accounts.create',$data);

        }else{

            return redirect()->route('admin.accounts.show', $my_account->id);

        }

    }

    public function store(Request $request)
    {
        $request->validate([
            'account_type_id' => 'required|integer|min:1|max:7',
            'name' => 'required|string|min:3|max:70',
            'private_association' => 'integer|min:1|max:2',
        ]);

        $private_association = $request->private_association;

        $my_accounts = Account::where('user_id', Auth::user()->id)->first();

        //SLUG
        $slug = Str::slug($request->name);

        $slug_base = $slug;

        $slug_exist = Account::where('slug', $slug)->first();

        $counter=1;

        while($slug_exist){
            $slug = $slug_base . '-' . $counter;
            $counter++;
            $slug_exist = Account::where('slug', $slug)->first();
        }
        //END SLUG

        if(!$my_accounts){
            $new_account = new Account();
            $new_account->user_id = Auth::user()->id;
            $new_account->account_type_id = $request->account_type_id;
            $new_account->slug = $slug;

            if($new_account->account_type_id==2){
                $new_account->private_association=1;
                $new_account->name = Str::lower($request->name);
            }else{
                $new_account->private_association=2;
                $new_account->name = $request->name;
                $new_account->incorporated = Carbon::now();
            }

            $new_account->save();

            if(!Auth::user()->account_id){
                Auth::user()->account_id = $new_account->id;
                Auth::user()->update();
            }

            return redirect()->route('admin.accounts.edit', $new_account->id);
        }abort(404);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $account = Account::find($id);

        if($account){
            $accountType = AccountType::find($account->account_type_id);
            $my_accounts_id = Account::where('user_id', Auth::user()->id)
                            ->select('accounts.id')->get();
            $my_account_selected = Account::where('id',Auth::user()->account_id)
                                ->select('id','account_type_id')->first();
            $startupStates = StartupState::all();
            $allStartupserviceTypes = StartupserviceType::all();

            //TEAM
            $team_members = Team::where('account_id', $id)
                            ->orderBy('position', 'ASC')
                            ->limit(3)
                            ->get();
            $team_num = Team::where('account_id', $id)->count();

            //SECTION
            $multipleSections = MultipleOther::where('account_id',$id)
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
                $section['edit'] = false;
            }

            $region = Region::find($account->region_id);
            $company = Company::find($account->company_id);
            $currencies = Currency::all();

            $view_exist = View::where('user_id',Auth::user()->id)
                        ->where('account_id',$id)
                        ->first();
            if(!$view_exist){
                $new_view = new View();
                $new_view->user_id = Auth::user()->id;
                $new_view->account_id = $id;
                $new_view->save();
            }

            //NOTIFICHE
            // $notifications = Notification::where('user_id',Auth::user()->id)
            //                 ->where('read', null)
            //                 ->get();
            //
            // if($notifications){
            //     foreach ($notifications as $notification) {
            //         if($notification->type==null
            //         && $notification->ref_account_id==$account->id){
            //             $notification->read = 1;
            //             $notification->update();
            //         }
            //     }
            // }
            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            //CONTROLLO STATO DI COMPILAZIONE PROPRIO ACCOUNT
            if(Auth::user()->account_id){
                $my_account = Account::find(Auth::user()->account_id);
                if(!$my_account->description){
                    return redirect()->route('admin.accounts.edit', $my_account->id);
                }
                if($my_account->account_type_id==1
                && !$my_account->startup_status_id){
                    return redirect()->route('admin.needs.edit', $my_account->id);
                }
            }

            $data = [
                'account' => $account,
                'accountType' => $accountType,
                'my_accounts_id' => $my_accounts_id,
                'startupStates' => $startupStates,
                'allStartupserviceTypes' => $allStartupserviceTypes,
                'team_members' => $team_members,
                'team_num' => $team_num,
                'multipleSections' => $multipleSections,
                'my_account_selected' => $my_account_selected,
                'region' => $region,
                'startupStates' => $startupStates,
                'company' => $company,
                'currencies' => $currencies,
            ];
            return view('admin.accounts.show', $data);
        }abort(404);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $account= Account::where('user_id', Auth::user()->id)
                        ->where('id', $id)
                        ->first();
        if($account && Auth::user()->id==$account->user_id){
            $accountType = AccountType::find($account->account_type_id);
            $startupStates = StartupState::all();
            $allStartupserviceTypes = StartupserviceType::all();
            $regions = Region::all();
            $accountNeeds = AccountNeed::where('account_id',$account->id)->get();
            $company = Company::find($account->company_id);
            $currencies = Currency::all();

            $data = [
                'account' => $account,
                'accountType' => $accountType,
                'startupStates' => $startupStates,
                'allStartupserviceTypes' => $allStartupserviceTypes,
                'regions' => $regions,
                'accountNeeds' => $accountNeeds,
                'company' => $company,
                'currencies' => $currencies,
            ];

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            return view('admin.accounts.edit', $data);
        }abort(404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //dd($request);
        $request->validate([
            'cover_image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            'name' => 'required|string|min:3|max:70',
            'description' => 'nullable|min:50',
            'website' => 'nullable|max:255',
            'linkedin'=> 'nullable|max:255',
            'phone_number'=> 'nullable|min:9|max:15',
            'email'=> '',
            'street'=> '',
            'civic'=> '',
            'city'=> '',
            'region_id'=> 'nullable|integer|min:0|max:20',
            'state_id'=> 'nullable|integer',
            'vat_number'=> '',
            'startup_status_id' => 'nullable|min:1|max:6',
            'pitch' => 'nullable|mimes:pdf|max:6144',
            'roadmap' => 'nullable|mimes:pdf|max:6144',
            'incorporated' => 'nullable',
            'role'=> 'nullable|max:50',
            'curriculum_vitae' => 'nullable|mimes:pdf|max:6144',
            'private_association' => 'nullable|min:1|max:2',
            'investor' => 'nullable|boolean',
            'service' => 'nullable|boolean',
            'cofounder' => 'nullable|boolean',
            'startupservice_type_id'=> 'nullable|integer|min:1|max:9',
            'nation_region'=> 'nullable|min:1|max:2',
            'needs_id' => 'nullable',
            'remove_cover_img' => 'nullable|integer',
            'company_name' => 'nullable|max:100',
        ]);

        $data = $request->all();

        $needs_id = $request->needs_id;

        if(Auth::user()->id==$account->user_id){
            if($needs_id){
                $accountNeeds = AccountNeed::where('account_id',$account->id)->get();
                foreach ($needs_id as $need_id) {
                    $need_already_exist = false;
                    foreach ($accountNeeds as $accountNeed) {
                        if($need_id==$accountNeed->need_id){
                            $need_already_exist = true;
                        }
                    }
                    if(!$need_already_exist){
                        $new_account_need = new AccountNeed();
                        $new_account_need->account_id = $account->id;
                        $new_account_need->need_id = $need_id;
                        $new_account_need->save();
                    }
                }
            }

            if(array_key_exists('cover_image', $data)){
                $old_cover_image_name = $account->cover_image;
                if ($old_cover_image_name!='accounts_cover_images/default_account_cover_image.jpg') {
                    Storage::delete($old_cover_image_name);
                }
                $cover_image_path = Storage::put('accounts_cover_images', $data['cover_image']);
                $data['cover_image'] = $cover_image_path;
            }

            if(array_key_exists('image', $data)){

                $old_image_name = $account->image;
                //se la vecchia immagine è diversa da quella di default
                if ($old_image_name!='accounts_images/default_account_image.png') {
                    //elimino la vecchia immagine
                    Storage::delete($old_image_name);
                }
                //recupero la path e salvo la nuova l'immagine
                $image_path = Storage::put('accounts_images', $data['image']);
                //resize
                $img = Image::make($data['image'])
                            ->resize(300,300)/*risoluzione*/
                            ->save('./storage/'.$image_path, 100 /*Qualita*/);

                $data['image'] = $image_path;
            }

            // STARTUP
            if(array_key_exists('pitch', $data)){
                $old_pitch_name = $account->pitch;
                Storage::delete($old_pitch_name);
                $pitch_path = Storage::put('startup_pitch', $data['pitch']);
                $data['pitch'] = $pitch_path;
            }

            if(array_key_exists('roadmap', $data)){
                $old_roadmap_name = $account->roadmap;
                Storage::delete($old_roadmap_name);
                $roadmap_path = Storage::put('startup_roadmap', $data['roadmap']);
                $data['roadmap'] = $roadmap_path;
            }

            if(array_key_exists('curriculum_vitae', $data)){
                $old_cv_name = $account->curriculum_vitae;
                Storage::delete($old_cv_name);
                $cv_path = Storage::put('curriculum_vitae', $data['curriculum_vitae']);
                $data['curriculum_vitae'] = $cv_path;
            }

            if($request->role){
                $data['role'] = Str::lower($request->role);

                $already_role_exist = CofounderRole::where('name',$data['role'])->first();
                if(!$already_role_exist){
                    $new_role = new CofounderRole;
                    $new_role->name = Str::lower($data['role']);
                    $new_role->save();
                }
            }

            if($account->private_association==1){
                if(!$request->investor)$account->investor=0;
                if(!$request->services)$account->services=0;
                if(!$request->cofounder)$account->cofounder=0;
            }

            $account->fill($data);

            if($request->name){
                if($account->account_type_id==2){
                    $account->name = Str::lower($request->name);
                }else{
                    $account->name = $request->name;
                }
            }

            //COMPANY
            if($request->company_name){

                $company_already_exist =
                Company::where('company_name',$request->company_name)
                ->first();

                if(!$company_already_exist){
                    $new_company = new Company();
                    $new_company->company_name = $request->company_name;
                    $new_company->save();
                    $account->company_id = $new_company->id;
                }else{
                    $account->company_id = $company_already_exist->id;
                }
            }

            $account->update();

            return redirect()->route('admin.accounts.show', ['account' => $account->id]);

        }abort(404);


    }

    public function showImageEditor($account_id){

        $account = Account::find($account_id);

        if(Auth::user()->id==$account->user_id){

            $data = [
                'account_id' => $account_id,
                'image' => $account->image,
            ];

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            return view('admin.accounts.image-editor', $data);

        }abort(404);

    }

    public function updateImage(Request $request,$account_id){

        $request->validate([
            //'account_id' => 'require|integer',
            //'cover_image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            // 'width'=> 'require',
            // 'height'=> 'require',
            // 'x' => 'require',
            // 'y'=> 'require',
        ]);

        $data = $request->all();

        $account = Account::find($account_id);
        //dd(Auth::user()->id);
        //dd($data['width'],$data['height'], $data['x'],$data['y']);

        if(Auth::user()->id==$account->user_id){
            //dd($data['y']);
            $width = $request->width;
            $height = $request->height;

            if(array_key_exists('image', $data)){
                //SE CARICO UNA NUOVA IMMAGINE
                $old_image_name = $account->image;

                //se la vecchia immagine è diversa da quella di default
                if ($old_image_name!='accounts_images/default_account_image.png') {
                    //elimino la vecchia immagine
                    Storage::delete($old_image_name);
                }
                //recupero la path e salvo la nuova l'immagine
                $image_path = Storage::put('accounts_images', $data['image']);
                //resize
                $img = Image::make($data['image'])
                            ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                            ->resize(300,300)/*risoluzione*/
                            ->save('./storage/'.$image_path, 100 /*Qualita*/);

                $account->image = $image_path;
            }elseif($width && $height){
                //SE HO MODIFICATO L'IMMAGINE ESISTENTE
                $image_path = $account->image;

                if ($image_path!='accounts_images/default_account_image.png') {

                    $filename = rand().time();
                    $ext = pathinfo($image_path, PATHINFO_EXTENSION);
                    $new_path = 'accounts_images/'.$filename.'.'.$ext;
                    Storage::move($image_path, $new_path);

                    $img = Image::make('storage/'.$new_path)
                                ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                                ->resize(300,300)/*risoluzione*/
                                ->save('./storage/'.$new_path, 100 /*Qualita*/);
                    $account->image = $new_path;
                }

            }

            $account->update();

            return redirect()->route('admin.accounts.show', ['account' => $account->id]);

        }abort(404);

    }

    public function showCoverImageEditor($account_id){

        $account = Account::find($account_id);

        if(Auth::user()->id==$account->user_id){

            $data = [
                'account_id' => $account_id,
                'image' => $account->cover_image,
            ];

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);

            return view('admin.accounts.cover-image-editor', $data);

        }abort(404);

    }

    public function updateCoverImage(Request $request,$account_id){

        $request->validate([
            //'account_id' => 'require|integer',
            //'cover_image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,swg|max:6144',
            // 'width'=> 'require',
            // 'height'=> 'require',
            // 'x' => 'require',
            // 'y'=> 'require',
        ]);

        $data = $request->all();

        $account = Account::find($account_id);

        if(Auth::user()->id==$account->user_id){
            //dd($data['y']);
            $width = $request->width;
            $height = $request->height;

            if(array_key_exists('image', $data)){
                //SE CARICO UNA NUOVA IMMAGINE
                $old_image_name = $account->cover_image;

                //se la vecchia immagine è diversa da quella di default
                if ($old_image_name!='accounts_cover_images/default_account_cover_image.jpg') {
                    //elimino la vecchia immagine
                    Storage::delete($old_image_name);
                }

                //recupero la path e salvo la nuova l'immagine
                $image_path = Storage::put('accounts_cover_images', $data['image']);

                //resize
                $img = Image::make($data['image'])
                            ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                            ->resize(1110,350)/*risoluzione*/
                            ->save('./storage/'.$image_path, 100 /*Qualita*/);
                //dd($data['width'],$data['height'], $data['x'],$data['y']);
                $account->cover_image = $image_path;
            }elseif($width && $height){
                //SE HO MODIFICATO L'IMMAGINE ESISTENTE
                $image_path = $account->cover_image;

                if ($image_path!='accounts_cover_images/default_account_cover_image.jpg') {

                    $filename = rand().time();
                    $ext = pathinfo($image_path, PATHINFO_EXTENSION);
                    $new_path = 'accounts_cover_images/'.$filename.'.'.$ext;
                    Storage::move($image_path, $new_path);
                    //dd($image_path,$new_path);

                    $img = Image::make('storage/'.$new_path)
                                ->crop($data['width'],$data['height'], $data['x'],$data['y'])
                                //->resize(1110,350)/*risoluzione*/
                                ->save('./storage/'.$new_path, 100 /*Qualita*/);
                    $account->cover_image = $new_path;
                }

            }

            $account->update();

            return redirect()->route('admin.accounts.show', ['account' => $account->id]);

        }abort(404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        if(Auth::user()->id==$account->user_id){

            if ($account->image!='accounts_images/default_account_image.png') {
                Storage::delete($account->image);
            }

            if ($account->cover_image!='accounts_cover_images/default_account_cover_image.jpg') {
                Storage::delete($account->cover_image);
            }

            $account->delete();

            Auth::user()->delete();

            return redirect()->route('home');

        }abort(404);
    }

    public function removeFile(Request $request)
    {
        $request->validate([
            'account_id' => 'required|integer',
            'file_type' => 'required',
            'item_id' => 'nullable|integer',
        ]);

        $account_id = $request->account_id;
        $file_type = $request->file_type;
        $item_id = $request->item_id;

        $account = Account::find($account_id);

        if(Auth::user()->id==$account->user_id){

            switch ($file_type) {
                case 'img':
                    if ($account->image!='accounts_images/default_account_image.png') {
                        Storage::delete($account->image);
                        $account->image = 'accounts_images/default_account_image.png';
                    }
                break;
                case 'cover_img':
                    if ($account->cover_image!='accounts_cover_images/default_account_cover_image.jpg') {
                        Storage::delete($account->cover_image);
                        $account->cover_image = 'accounts_cover_images/default_account_cover_image.jpg';
                    }
                break;
                case 'pitch':
                    if ($account->pitch) {
                        Storage::delete($account->pitch);
                        $account->pitch = null;
                    }
                break;
                case 'roadmap':
                    if ($account->roadmap) {
                        Storage::delete($account->roadmap);
                        $account->roadmap = null;
                    }
                break;
                case 'cv':
                    if ($account->curriculum_vitae) {
                        Storage::delete($account->curriculum_vitae);
                        $account->curriculum_vitae = null;
                    }
                break;
                case 'team_img':
                    $team = Team::find($item_id);
                    if ($team->image!='accounts_images/default_account_image.png') {
                        Storage::delete($team->image);
                        $team->image = 'accounts_images/default_account_image.png';
                        $team->update();
                    }
                break;
                case 'other_img':
                    $other = Other::find($item_id);
                    if ($other->image) {
                        Storage::delete($other->image);
                        $other->image = null;
                        $other->update();
                    }
                break;
                default:
                    // code...
                break;
            }

            $account->update();

        }
    }

}
