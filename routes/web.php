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

// Route::get('/', function () {
//     return view('welcome');
// });
//

Auth::routes(['verify' => true]);

Route::get('/home','HomeController@index')->name('home');
//Route::get('/home/{locale}','HomeController@home')->name('home');
Route::get('/termsAndConditions', 'HomeController@termsAndConditions')->name('termsAndConditions');
Route::get('/privacyPolicy', 'HomeController@privacyPolicy')->name('privacyPolicy');
Route::get('/cookiePolicy', 'HomeController@cookiePolicy')->name('cookiePolicy');
Route::get('/acceptCookie', 'HomeController@acceptCookie')->name('acceptCookie');
Route::get('/rejectCookie', 'HomeController@rejectCookie')->name('rejectCookie');

Auth::routes(['verify' => true]);

//Per eseguire il logout nel guest
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('index');

Route::middleware('auth')->namespace('Admin')->prefix('admin')->name('admin.')->group(function(){

    Route::resource('/users', 'UserController');
    Route::get('/getUser', 'UserController@getUser')->name('getUser');

    Route::get('/advancedSearch', 'SearchController@advancedSearch')->name('advancedSearch');

    //Route::get('/', 'HomeController@index')->name('index');
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
    Route::get('/addMember/{account_id}', 'TeamController@addMember')->name('teams.addMember');
    Route::post('/storeMember/{account_id}', 'TeamController@storeMember')->name('teams.storeMember');
    Route::delete('/deleteMember', 'TeamController@deleteMember')->name('deleteMember');
    Route::put('/changeTeamPosition', 'TeamController@changeTeamPosition')->name('teams.changeTeamPosition');


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

    //Need
    Route::resource('/needs', 'NeedController');
    Route::post('/updateNeed', 'NeedController@updateNeed')->name('needs.updateNeed');

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

    //TOPIC
    Route::resource('/topics', 'TopicController');

});
