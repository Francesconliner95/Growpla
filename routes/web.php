<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/home','HomeController@index')->name('home');
Route::get('/termsAndConditions', 'HomeController@termsAndConditions')->name('termsAndConditions');
Route::get('/privacyPolicy', 'HomeController@privacyPolicy')->name('privacyPolicy');
Route::get('/cookiePolicy', 'HomeController@cookiePolicy')->name('cookiePolicy');

Auth::routes(['verify' => true]);

//Per eseguire il logout nel guest
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('index');

Route::middleware('auth')->namespace('Admin')->prefix('admin')->name('admin.')->group(function(){

    Route::get('/search', 'MainController@search')->name('search');

    Route::resource('/users', 'UserController');
    Route::get('/getUser', 'UserController@getUser')->name('getUser');
    Route::post('/addAdmin', 'UserController@addAdmin')->name('users.addAdmin');
    Route::get('/getAdmin', 'UserController@getAdmin')->name('users.getAdmin');
    Route::delete('/removeAdmin', 'UserController@removeAdmin')->name('users.removeAdmin');
    Route::get('users/{user_id}/settings', 'UserController@settings')->name('users.settings');
    Route::get('users/{user_id}/sectors', 'UserController@sectors')->name('users.sectors');
    Route::put('users/{user_id}/storesectors', 'UserController@storesectors')->name('users.storesectors');

    // admin.users.settings

    Route::resource('/pages', 'PageController');
    Route::get('/newPage/{pagetype_id}', 'PageController@newPage')->name('pages.newPage');
    Route::get('pages/{page_id}/settings', 'PageController@settings')->name('pages.settings');
    Route::get('pages/{page_id}/sectors', 'PageController@sectors')->name('pages.sectors');
    Route::put('pages/{page_id}/storesectors', 'PageController@storesectors')->name('pages.storesectors');

    //IMAGE
    Route::get('/editUserImage', 'ImageController@editUserImage')->name('images.editUserImage');
    Route::put('/updateUserImage', 'ImageController@updateUserImage')
    ->name('images.updateUserImage');
    Route::put('/removeUserImage', 'ImageController@removeUserImage')->name('removeUserImage');
    Route::get('/editPageImage/{page_id}', 'ImageController@editPageImage')->name('images.editPageImage');
    Route::put('/updatePageImage', 'ImageController@updatePageImage')
    ->name('images.updatePageImage');
    Route::put('/removePageImage', 'ImageController@removePageImage')->name('removePageImage');

    //Skills
    Route::resource('/skills', 'SkillController');

    //GiveUserService
    Route::resource('/give-user-services', 'GiveUserServiceController');
    //GivePageService
    Route::get('/create-give-page-services/{page_id}', 'GivePageServiceController@create_service')
    ->name('give-page-services.create_service');
    Route::post('/store-give-page-services', 'GivePageServiceController@store_service')
    ->name('give-page-services.store_service');
    Route::resource('/give-page-services', 'GivePageServiceController');
    // Route::get('/edit-give-page-services/{gps_id}', 'GivePageServiceController@edit_service')
    // ->name('give-page-services.edit_service');
    // Route::put('/update-give-page-services', 'GivePageServiceController@update_service')
    // ->name('give-page-services.update_service');
    // Route::destroy('/destroy-give-page-services', 'GivePageServiceController@destroy_service')
    // ->name('destroy-give-page-services.destroy_service');

    Route::get('/advancedSearch', 'SearchController@advancedSearch')->name('advancedSearch');

    Route::get('/', 'HomeController@index')->name('index');
    Route::resource('/accounts', 'AccountController');
    Route::get('/getMyAccounts', 'AccountController@getMyAccounts')->name('getMyAccounts');
    Route::put('/setAccount', 'AccountController@setAccount')->name('setAccount');
    Route::put('/removeFile', 'AccountController@removeFile')->name('removeFile');
    Route::get('/showImageEditor/{account_id}', 'AccountController@showImageEditor')->name('accounts.showImageEditor');
    Route::put('/updateImage/{account_id}', 'AccountController@updateImage')->name('accounts.updateImage');
    Route::get('/showCoverImageEditor/{account_id}', 'AccountController@showCoverImageEditor')->name('accounts.showCoverImageEditor');
    Route::put('/updateCoverImage/{account_id}', 'AccountController@updateCoverImage')->name('accounts.updateCoverImage');


    // TEAM
    Route::resource('/teams', 'TeamController');
    Route::get('/addTeam/{page_id}', 'TeamController@addTeam')->name('teams.addTeam');
    Route::post('/storeTeam/{page_id}', 'TeamController@storeTeam')->name('teams.storeTeam');
    Route::delete('/deleteTeam', 'TeamController@deleteTeam')->name('deleteTeam');
    Route::put('/changeTeamPosition', 'TeamController@changeTeamPosition')->name('teams.changeTeamPosition');

    // COMPANY
    Route::resource('/companies', 'CompanyController');

    // OTHER
    Route::post('/addMultipleSection','OtherController@addMultipleSection')
    ->name('addMultipleSection');
    Route::put('/updateMultipleOther','OtherController@updateMultipleOther')
    ->name('updateMultipleOther');
    Route::delete('/deleteMultipleOther','OtherController@deleteMultipleOther')
    ->name('deleteMultipleOther');
    Route::put('/changeMultipleOtherPosition', 'OtherController@changeMultipleOtherPosition')->name('others.changeMultipleOtherPosition');
    Route::resource('/others', 'OtherController');
    Route::get('/addOther/{section_id}', 'OtherController@addOther')->name('others.addOther');
    Route::post('/storeOther/{section_id}', 'OtherController@storeOther')->name('others.storeOther');
    Route::delete('/deleteOther', 'OtherController@deleteOther')->name('deleteOther');
    Route::put('/changeOtherPosition', 'OtherController@changeOtherPosition')->name('others.changeOtherPosition');

    //Lifecycle
    Route::resource('/lifecycles', 'LifecycleController');

    //FOLLOW
    Route::post('/addFollow', 'FollowController@addFollow')->name('addFollow');
    Route::get('/getFollow', 'FollowController@getFollow')->name('getFollow');
    Route::get('/getFollows', 'FollowController@getFollows')->name('getFollows');

    // SUPPORTED STARTUP
    Route::post('/addCooperation', 'CooperationController@addCooperation')
    ->name('addCooperation');
    Route::delete('/deleteCooperation', 'CooperationController@deleteCooperation')
    ->name('deleteCooperation');
    Route::put('/confirmCooperation', 'CooperationController@confirmCooperation')
    ->name('confirmCooperation');

    //TAG
    Route::post('/createTag', 'TagController@createTag')
    ->name('tags.createTag');
    Route::post('/addTag', 'TagController@addTag')->name('tags.addTag');
    Route::delete('/deleteTag', 'TagController@deleteTag')
    ->name('tags.deleteTag');

    //SERVICE
    Route::post('/addService', 'ServiceController@addService')->name('services.addService');
    Route::delete('/deleteService', 'ServiceController@deleteService')
    ->name('services.deleteService');

    //ROLE
    Route::post('/createRole', 'CofounderRoleController@createRole')
    ->name('cofounder_roles.createRole');

    //COFOUNDER
    Route::post('/addCofounder', 'CofounderController@addCofounder')
    ->name('cofounders.addCofounder');
    Route::delete('/deleteCofounder', 'CofounderController@deleteCofounder')
    ->name('cofounders.deleteCofounder');

    //CHATS
    Route::resource('/chats', 'ChatController');
    Route::get('/createChat', 'ChatController@createChat')
    ->name('chats.createChat');
    Route::get('/getChats', 'ChatController@getChats')
    ->name('chats.getChats');

    //MESSAGES
    Route::post('/newMessage', 'MessageController@newMessage')
    ->name('massages.newMessage');
    Route::get('/getMessages', 'MessageController@getMessages')
    ->name('massages.getMessages');
    Route::put('/updateMessages', 'MessageController@updateMessages')
    ->name('massages.updateMessages');
    Route::get('/getMessagesCount', 'MessageController@getMessagesCount')
    ->name('massages.getMessagesCount');
    // Route::resource('/messages', 'MessageController');

    //NOMINATIONS
    Route::resource('/nominations', 'NominationController');
    Route::get('/cofounder', 'NominationController@cofounder')
    ->name('nominations.cofounder');
    Route::get('/startup/{account_id}', 'NominationController@startup')
    ->name('nominations.startup');
    Route::post('/addNomination', 'NominationController@addNomination')
    ->name('nominations.addNomination');
    Route::get('/getNeedsAndNomination', 'NominationController@getNeedsAndNomination')
    ->name('nominations.getStartupNomination');
    Route::get('/getNominations', 'NominationController@getNominations')
    ->name('nominations.getNominations');
    Route::delete('/deleteNomination', 'NominationController@deleteNomination')
    ->name('nominations.deleteNomination');
    // Route::put('/updateNomination', 'NominationController@updateNomination')
    // ->name('nominations.updateNomination');


    //FOLLOW
    Route::resource('/follows', 'FollowController');

    //MAIL
    Route::get('/mailMessage', 'MailController@mailMessage')
    ->name('mails.mailMessage');

    //NOTIFICATIONS
    Route::resource('/notifications', 'NotificationController');
    Route::get('/getNotifications', 'NotificationController@getNotifications')
    ->name('notifications.getNotifications');
    Route::get('/getNotReadNotifications', 'NotificationController@getNotReadNotifications')
    ->name('notifications.getNotReadNotifications');
    Route::put('/readNotifications', 'NotificationController@readNotifications')
    ->name('notifications.readNotifications');

    //SETTINGS
    Route::resource('/settings', 'SettingController');
    Route::put('/changeLang', 'SettingController@changeLang')
    ->name('settings.changeLang');
    Route::resource('/supports', 'SupportController');
    Route::get('/switch', 'SupportController@switch')
    ->name('supports.switch');
    Route::get('/success', 'SupportController@success')
    ->name('supports.success');
    Route::get('/getAllSupports', 'SupportController@getAllSupports')
    ->name('supports.getAllSupports');



    //FILTER MESSAGES
    Route::put('/setFilterMessage', 'FilterMessageController@setFilterMessage')
    ->name('filtermessage.setFilterMessage');
    Route::get('/getFilterMessage', 'FilterMessageController@getFilterMessage')
    ->name('filtermessage.getFilterMessage');
    //FILTER MAILS
    Route::put('/setFilterMail', 'FilterMailController@setFilterMail')
    ->name('filtermail.setFilterMail');
    Route::get('/getFilterMail', 'FilterMailController@getFilterMail')
    ->name('filtermail.getFilterMail');
    //FILTER NOTIFICATIONS
    Route::put('/setFilterNotf', 'FilterNotificationController@setFilterNotf')
    ->name('filternotification.setFilterNotf');
    Route::get('/getFilterNotf', 'FilterNotificationController@getFilterNotf')
    ->name('filternotification.getFilterNotf');

});
