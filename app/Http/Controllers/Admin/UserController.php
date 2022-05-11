<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Events\MyEvent;
use File;
use App\View;
use App\Language;
use App\User;
use App\Page;
use App\Usertype;
use App\Pagetype;
use App\Moneyrange;
use App\Sector;
use App\GiveUserService;
use App\Region;
use App\Country;
use App\Collaboration;
use App\Notification;
use App\MailSetting;
use App\UserMailSetting;
use App\Background;

class UserController extends Controller
{
    public function __construct()
    {
      $this->middleware(['auth','verified']);
    }

    public function accounts($id){

        $user = Auth::user();
        $userTypes = Usertype::where('hidden',null)->get();
        $pageTypes = Pagetype::where('hidden',null)->get();

        $data = [
            'user' => $user,
            'userTypes' => $userTypes,
            'pageTypes' => $pageTypes,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.users.accounts', $data);

    }

    public function storeAccounts($id,Request $request){

        $request->validate([
            'usertypes'=> 'exists:usertypes,id',
            'pagetypes'=> 'exists:pagetypes,id',
        ]);

        $data = $request->all();

        $user = Auth::user();

        if(array_key_exists('usertypes', $data)){
            $user->usertypes()->sync($data['usertypes']);
        }else{
            $user->usertypes()->sync([]);
        }

        if(array_key_exists('pagetypes', $data)){
            $user->pagetypes()->sync($data['pagetypes']);
        }else{
            $user->pagetypes()->sync([]);
        }

        //elimino i background precaricati nel caso ho deselezionato aspiarnte cofounder o studente
        if(!$user->usertypes->contains(1)
        && !$user->usertypes->contains(5)){
            $user->backgrounds()->sync([]);
        }

        $default_images = Usertype::pluck('image')->toArray();
        // dd($user->image);
        if(in_array($user->image,$default_images)){
            $user_usertypes = $user->usertypes->pluck('id')->toArray();
            if(in_array(1,$user_usertypes)){
                $user->image = $default_images[0];
            }
          //UTENTE
          if(in_array(7,$user_usertypes)){
              $user->image = $default_images[6];
          }
          //STUDENTE
          if(in_array(5,$user_usertypes)){
              $user->image = $default_images[4];
          }
          //ASPIRANTE COFOUNDER
          if(in_array(1,$user_usertypes)){
              $user->image = $default_images[0];
          }
          //DIPENDENTI
          if(in_array(4,$user_usertypes)){
              $user->image = $default_images[3];
          }
          //FREELANCER
          if(in_array(3,$user_usertypes)){
              $user->image = $default_images[2];
          }
          //STARTUPPER
          if(in_array(6,$user_usertypes)){
              $user->image = $default_images[5];
          }
          //BUSINESS ANGEL
          if(in_array(2,$user_usertypes)){
              $user->image = $default_images[1];
          }
          //dd($user->image);
          $user->save();
      }

        if(Auth::user()->tutorial){
            return redirect()->route('admin.users.create');
        }else{
            return redirect()->route('admin.users.show',$user->id);
        }

    }

    public function create(){

        $user = Auth::user();

        $data = [
            'user' => $user,
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.users.create', $data);

    }

    public function store(Request $request){

        $request->validate([
            'summary' => 'required|min:50|max:250',
            'description' => 'nullable|max:1000',
            'website' => 'nullable|max:255',
            'linkedin'=> 'nullable|max:255',
            'cv' => 'nullable|mimes:pdf|max:6144',
            'municipality' => 'nullable',
            'region_id' => 'nullable|integer|min:1|max:20',
        ]);

        $data = $request->all();

        $user = Auth::user();

        if(array_key_exists('remove_cv',$data)
        && $data['remove_cv']=='true' && $user->cv){
            $old_cv_name = $user->cv;
            if($old_cv_name){
                Storage::delete($old_cv_name);
            }
            $data['cv'] = '';
        }

        if(array_key_exists('cv',$data) && $data['cv']){
            $old_cv_name = $user->cv;
            if($old_cv_name){
                Storage::delete($old_cv_name);
            }
            $cv_path = Storage::put('cv', $data['cv']);
            $data['cv'] = $cv_path;
        }

        if(array_key_exists('municipality',$data)){
            $user->municipality = Str::lower($data['municipality']);
        }

        $user->fill($data);

        $user->update();

        if(Auth::user()->tutorial){
            if($user->usertypes->contains(1)
            || $user->usertypes->contains(5)){
                return redirect()->route('admin.users.background',$user->id);
            }elseif($user->usertypes->contains(2)){
                return redirect()->route('admin.users.businessAngel',$user->id);
            }else{
                $user->tutorial = null;
                $user->update();
                return redirect()->route('admin.users.show',$user->id);
            }
        }else{
            return redirect()->route('admin.users.show',$user->id);
        }

    }

    public function edit($id){

      $user = Auth::user();

      if($user->id==$id){
        $data = [
          'user' => $user,
          'userTypes' => $user->userTypes,
          'moneyranges' => Moneyrange::all(),
          'sectors' => Sector::all(),
          'countries'=> Country::all(),
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.users.edit', $data);
      }abort(404);

    }

    public function update(Request $request, $id){

        $request->validate([
            'name' => 'required|string|min:3|max:70',
            'surname' => 'required|string|min:3|max:70',
            'summary' => 'required|min:50|max:250',
            'description' => 'nullable|max:1000',
            'website' => 'nullable|max:255',
            'linkedin'=> 'nullable|max:255',
            'cv' => 'nullable|mimes:pdf|max:6144',
            'moneyrange_id' => 'nullable|integer|min:1|max:5',
            'startup_n' => 'nullable|integer',
            'municipality' => 'nullable',
            'region_id' => 'nullable|integer|min:1|max:20',
        ]);

        $data = $request->all();

        $user = Auth::user();

        if($user->id == $id){
            if(!array_key_exists('cv',$data) && array_key_exists('remove_cv',$data)
            && $data['remove_cv']=='true' && $user->cv){
                $old_cv_name = $user->cv;
                if($old_cv_name){
                    Storage::delete($old_cv_name);
                }
                $data['cv'] = '';
            }

            if(array_key_exists('cv',$data) && $data['cv']){
                $old_cv_name = $user->cv;
                if($old_cv_name){
                    Storage::delete($old_cv_name);
                }
                $cv_path = Storage::put('cv', $data['cv']);
                $data['cv'] = $cv_path;
            }

            $user->fill($data);

            if($request->name){
                $user->name = Str::lower($request->name);
            }
            if($request->municipality){
                $user->municipality = Str::lower($request->municipality);
            }

            $user->update();

            if(Auth::user()->tutorial){
                $user->tutorial = null;
                $user->update();
                return redirect()->route('admin.users.show',$user->id);
            }else{
                return redirect()->route('admin.users.show',$user->id);
            }

      }abort(404);
    }

    public function businessAngel(){
        $user = Auth::user();
        if($user->usertypes->contains(2)){
            $data = [
                'user' => $user,
                'moneyranges' => Moneyrange::all(),
            ];
            app()->setLocale(Language::find($user->language_id)->lang);
            return view('admin.users.business-angel', $data);
        }abort(404);
    }

    public function show(User $user){

        //event(new MyEvent(2,'prova evento bello'));
        if(Auth::user()->tutorial>=2){
            return redirect()->route('admin.users.tutorial');
        }

        if($user){
            //dd($user->currency);
            $give_services = GiveUserService::where('user_id',$user->id)
            ->join('services','services.id','service_id')
            ->select('give_user_services.id','services.name')
            ->get();

            $my_user_id = Auth::user()->id;
            $already_viewed = View::where('user_id',$my_user_id)->where('viewed_user_id',$user->id)->first();
            if($already_viewed){
                $already_viewed->touch();
            }else{
                $new_view = new View();
                $new_view->user_id = $my_user_id;
                $new_view->viewed_user_id = $user->id;
                $new_view->save();
            }

            $data = [
              'user' => $user,
              'userTypes' => Usertype::where('hidden',null)->get(),
              'is_my_user' => Auth::user()->id==$user->id?true:false,
              'pageTypes' => $user->pagetypes->where('hidden',null),
              'currencies' => $user->currencies,
              'give_services' => $give_services,
            ];

            app()->setLocale(Language::find(Auth::user()->language_id)->lang);
            return view('admin.users.show', $data);

        }abort(404);

    }

    public function sectors($id){

      $user = Auth::user();

      if($user->id==$id){
        $data = [
          'user' => $user,
          'sectors' => Sector::all(),
        ];
        app()->setLocale(Language::find(Auth::user()->language_id)->lang);
        return view('admin.users.sectors', $data);

      }abort(404);

    }

    public function storesectors(Request $request, $id){

        $request->validate([
            'sectors'=> 'exists:sectors,id',
        ]);

        $data = $request->all();

        $user = Auth::user();

        if(array_key_exists('sectors', $data)){
            $user->sectors()->sync($data['sectors']);
        }else{
            $user->sectors()->sync([]);
        }

        return redirect()->route('admin.users.show',$user->id);

    }

    public function getUser(Request $request){

      if(Auth::check()){
          $result = Auth::user()->id;
      }else{
          $result = false;
      }

      return response()->json([
          'success' => true,

          'results' => [
              'user_id' => $result,
          ]
      ]);

    }

    public function settings($id){

      $user = User::find($id);
      $languages = Language::all();
      $data = [
        'user' => $user,
        'languages' => $languages,
        'mail_settings' => MailSetting::all(),
      ];
      app()->setLocale(Language::find(Auth::user()->language_id)->lang);
      return view('admin.users.settings', $data);

    }

    public function mailSettingToggle(Request $request){

        $request->validate([
            'mail_setting_id' => 'nullable|integer',
        ]);
        $mail_setting_id = $request->mail_setting_id;
        $user = Auth::user();

        $exist = UserMailSetting::where('user_id',$user->id)
                            ->where('mail_setting_id',$mail_setting_id)
                            ->first();

        if($exist){
            $exist->delete();
        }else{
            $new_mail_setting = new UserMailSetting();
            $new_mail_setting->user_id = $user->id;
            $new_mail_setting->mail_setting_id = $mail_setting_id;
            $new_mail_setting->save();
        }

    }

    public function destroy(User $user){

        //dd('qua');
        if(Auth::user()->id == $user->id){

            $pages = $user->pages;

            foreach ($pages as $page) {
                if(count($page->users)<=1){
                    $page->delete();
                }
            }

            $user->delete();

            return redirect()->route('home');

        }abort(404);

    }

    public function addAdmin(Request $request){

        $request->validate([
            'user_id' => 'required|integer',
            'page_id' => 'required|integer',
        ]);

        $user_id = $request->user_id;
        $page_id = $request->page_id;

        $page = Page::find($page_id);

        //controllo se sono il propietario della pagina
        if($page->users->contains(Auth::user())){
            //aggiungo un nuovo amministratore
            $user = User::find($user_id);
            $page->users()->attach($user);
            if(!$user->pagetypes->contains($page->pagetype)){
                $user->pagetypes()->attach($page->pagetype);
            }
            //NOTIFICATIONS
            $new_notf = new Notification();
            $new_notf->user_id = $user->id;
            $new_notf->notification_type_id = 16;
            $new_notf->ref_user_id = Auth::user()->id;
            $new_notf->ref_to_page_id = $page->id;
            $new_notf->parameter = $page->id;
            $new_notf->save();
        }
    }

    public function getAdmin(Request $request){

      $request->validate([
          'page_id' => 'required|integer',
      ]);

      $page_id = $request->page_id;

      $page = Page::find($page_id);

      //controllo se sono il propietario della pagina
      if($page->users->contains(Auth::user())){

        return response()->json([
            'success' => true,
            'results' => [
                'admins' => $page->users,
            ]
        ]);

      }

    }

    public function removeAdmin(Request $request){

      $request->validate([
          'user_id' => 'required|integer',
          'page_id' => 'required|integer',
      ]);

      $user_id = $request->user_id;
      $page_id = $request->page_id;

      $page = Page::find($page_id);

      //controllo se sono il propietario della pagina
      if($page->users->contains(Auth::user())){

        $message = '';

        //controllo se esiste almeno un'altro admin
        if(count($page->users) > 1){
          //se sto elimnando me stesso
          if(Auth::user()->id == $user_id){
            $message = 'auto-delete';
          }
          //rimuovo l' amministratore
          $user = User::find($user_id);
          $page->users()->detach($user);
          //NOTIFICATIONS
          $new_notf = new Notification();
          $new_notf->user_id = $user->id;
          $new_notf->notification_type_id = 17;
          $new_notf->ref_user_id = Auth::user()->id;
          $new_notf->ref_to_page_id = $page->id;
          $new_notf->parameter = $page->id;
          $new_notf->save();
        }else{
          $message = 'Sei l\'unico admin';
        }

      }

      return response()->json([
          'success' => true,
          'results' => [
              'message' => $message,
          ]
      ]);

    }

    public function getMyAccounts(){

        $user = Auth::user();

        return response()->json([
            'success' => true,
            'results' => [
                'user' => $user->only(['id', 'image', 'name',  'surname']),
                'pages' => $user->pages()->select('pages.id','pages.image','pages.name')->get(),
                'page_selected' => Page::where('id',$user->page_selected_id)->select('id','image','name')->first(),
            ]
        ]);

    }

    public function setPageSelected(Request $request){

        $request->validate([
            'page_id' => 'nullable|integer',
        ]);

        $page_id = $request->page_id;
        $user = Auth::user();

        if($page_id){
            $page = Page::find($page_id);
            if($user->pages->contains($page)){
                $user->page_selected_id = $page_id;
                $page_selected = $page->only('id','image','name');
            }
        }else{
            $user->page_selected_id = null;
            $page_selected = '';
        }
        $user->update();

        return response()->json([
            'success' => true,
            'results' => [
                'page_selected' => $page_selected,
            ]
        ]);

    }

    public function background($id){

        $user = Auth::user();

        if($user->userTypes->contains(1) || $user->userTypes->contains(5)){

            $data = [
                'user' => $user,
                'user_backgrounds' => $user->backgrounds,
                'backgrounds' => Background::where('hidden',null)
                                            ->orderBy('name')
                                            ->get(),
            ];
            app()->setLocale(Language::find($user->language_id)->lang);
            return view('admin.users.background', $data);

        }abort(404);

    }

    public function storeBackground($id,Request $request){

        $request->validate([
            'backgrounds'=> 'exists:backgrounds,id',
        ]);

        $data = $request->all();

        $user = Auth::user();

        if($user->userTypes->contains(1) || $user->userTypes->contains(5)){

            if(array_key_exists('backgrounds', $data)){
                $user->backgrounds()->sync($data['backgrounds']);
            }else{
                $user->backgrounds()->sync([]);
            }

            if(Auth::user()->tutorial){
                if($user->usertypes->contains(2)){
                    return redirect()->route('admin.users.businessAngel',$user->id);
                }else{
                    $user->tutorial = null;
                    $user->update();
                    return redirect()->route('admin.users.show',$user->id);
                }
            }else{
                return redirect()->route('admin.users.show',$user->id);
            }

        }

    }

}
