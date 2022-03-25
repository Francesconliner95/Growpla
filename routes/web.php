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
    Route::post('/found', 'MainController@found')->name('found');
    Route::get('/loadInfo', 'MainController@loadInfo')->name('loadInfo');

    Route::resource('/users', 'UserController');
    Route::get('/tutorial', 'UserController@tutorial')->name('users.tutorial');
    Route::get('/getUser', 'UserController@getUser')->name('getUser');
    Route::post('/addAdmin', 'UserController@addAdmin')->name('users.addAdmin');
    Route::get('/getAdmin', 'UserController@getAdmin')->name('users.getAdmin');
    Route::delete('/removeAdmin', 'UserController@removeAdmin')->name('users.removeAdmin');
    Route::get('users/{user_id}/settings', 'UserController@settings')->name('users.settings');
    Route::get('users/{user_id}/sectors', 'UserController@sectors')->name('users.sectors');
    Route::put('users/{user_id}/storesectors', 'UserController@storesectors')->name('users.storesectors');
    Route::get('getMyAccounts', 'UserController@getMyAccounts')->name('getMyAccounts');
    Route::put('setPageSelected', 'UserController@setPageSelected')->name('setPageSelected');

    //admin.users.settings

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

    //GiveUserSkills
    Route::resource('/give_user_skills', 'GiveUserSkillController');

    //GiveUserService
    Route::resource('/give-user-services', 'GiveUserServiceController');
    //HaveUserService
    Route::resource('/have-user-services', 'HaveUserServiceController');
    //GivePageService
    Route::get('/create-give-page-services/{page_id}', 'GivePageServiceController@create_service')
    ->name('give-page-services.create_service');
    Route::post('/store-give-page-services', 'GivePageServiceController@store_service')
    ->name('give-page-services.store_service');
    Route::resource('/give-page-services', 'GivePageServiceController');
    //HavePageService
    Route::get('/create-have-page-services/{page_id}', 'HavePageServiceController@create_service')
    ->name('have-page-services.create_service');
    Route::post('/store-have-page-services', 'HavePageServiceController@store_service')
    ->name('have-page-services.store_service');
    Route::resource('/have-page-services', 'HavePageServiceController');
    //HavePagePagetype
    Route::resource('/have-page-pagetypes', 'HavePagePagetypeController');
    //HavePageUsertype
    Route::resource('/have-page-usertypes', 'HavePageUsertypeController');


    //Route::get('/advancedSearch', 'SearchController@advancedSearch')->name('advancedSearch');

    Route::get('/', 'HomeController@index')->name('index');
    // Route::resource('/accounts', 'AccountController');
    // Route::get('/getMyAccounts', 'AccountController@getMyAccounts')->name('getMyAccounts');
    // Route::put('/setAccount', 'AccountController@setAccount')->name('setAccount');
    // Route::put('/removeFile', 'AccountController@removeFile')->name('removeFile');
    // Route::get('/showImageEditor/{account_id}', 'AccountController@showImageEditor')->name('accounts.showImageEditor');
    // Route::put('/updateImage/{account_id}', 'AccountController@updateImage')->name('accounts.updateImage');
    // Route::get('/showCoverImageEditor/{account_id}', 'AccountController@showCoverImageEditor')->name('accounts.showCoverImageEditor');
    // Route::put('/updateCoverImage/{account_id}', 'AccountController@updateCoverImage')->name('accounts.updateCoverImage');


    // TEAM
    Route::resource('/teams', 'TeamController');
    Route::get('/addTeam/{page_id}', 'TeamController@addTeam')->name('teams.addTeam');
    Route::post('/storeTeam/{page_id}', 'TeamController@storeTeam')->name('teams.storeTeam');
    Route::delete('/deleteTeam', 'TeamController@deleteTeam')->name('deleteTeam');
    Route::put('/changeTeamPosition', 'TeamController@changeTeamPosition')->name('teams.changeTeamPosition');

    // COMPANY
    Route::resource('/companies', 'CompanyController');

    // OTHER
    // Route::post('/addMultipleSection','OtherController@addMultipleSection')
    // ->name('addMultipleSection');
    // Route::put('/updateMultipleOther','OtherController@updateMultipleOther')
    // ->name('updateMultipleOther');
    // Route::delete('/deleteMultipleOther','OtherController@deleteMultipleOther')
    // ->name('deleteMultipleOther');
    // Route::put('/changeMultipleOtherPosition', 'OtherController@changeMultipleOtherPosition')->name('others.changeMultipleOtherPosition');
    // Route::resource('/others', 'OtherController');
    // Route::get('/addOther/{section_id}', 'OtherController@addOther')->name('others.addOther');
    // Route::post('/storeOther/{section_id}', 'OtherController@storeOther')->name('others.storeOther');
    // Route::delete('/deleteOther', 'OtherController@deleteOther')->name('deleteOther');
    // Route::put('/changeOtherPosition', 'OtherController@changeOtherPosition')->name('others.changeOtherPosition');

    //Lifecycle
    Route::resource('/lifecycles', 'LifecycleController');

    //FOLLOW
    Route::resource('/follows', 'FollowController');
    Route::post('/toggleFollowing', 'FollowController@toggleFollowing')->name('toggleFollowing');
    Route::get('/getFollowed', 'FollowController@getFollowed')->name('getFollowed');

    //COLLABORATIONS
    Route::resource('/collaborations', 'CollaborationController');
    Route::get('collaborations/create/{id}/{user_or_page}', 'CollaborationController@create')->name('collaborations.create');
    Route::get('collaborations/index/{id}/{user_or_page}', 'CollaborationController@index')->name('collaborations.index');
    Route::get('getCollaborations', 'CollaborationController@getCollaborations')->name('getCollaborations');
    Route::get('getProposalCollaborations', 'CollaborationController@getProposalCollaborations')->name('getProposalCollaborations');
    Route::delete('deleteCollaboration', 'CollaborationController@deleteCollaboration')
    ->name('deleteCollaboration');
    Route::put('confirmCollaboration', 'CollaborationController@confirmCollaboration')
    ->name('confirmCollaboration');

    //CHATS
    Route::resource('/chats', 'ChatController');
    Route::get('chats/show/{chat_id}/{page_id}', 'ChatController@show')
    ->name('chats.show');
    Route::get('/createChat/{id}/{user_or_page}', 'ChatController@createChat')
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
    Route::get('/getNotReadMessages', 'MessageController@getNotReadMessages')
    ->name('messages.getNotReadMessages');

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
