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
Route::get('/incubators', 'HomeController@incubators')->name('incubators');

Auth::routes(['verify' => true]);

//Per eseguire il logout nel guest
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('index');

Route::middleware('auth')->namespace('Admin')->prefix('admin')->name('admin.')->group(function(){

    Route::get('/', 'MainController@search');
    Route::get('/search', 'MainController@search')->name('search');
    Route::post('/found', 'MainController@found')->name('found');
    Route::get('/loadInfo', 'MainController@loadInfo')->name('loadInfo');

    //USER
    Route::resource('/users', 'UserController');
    Route::get('users/{user_id}/accounts', 'UserController@accounts')->name('users.accounts');
    Route::put('users/{user_id}/storeAccounts', 'UserController@storeAccounts')->name('users.storeAccounts');
    Route::get('users/{user_id}/background', 'UserController@background')->name('users.background');
    Route::put('users/{user_id}/storeBackground', 'UserController@storeBackground')->name('users.storeBackground');
    Route::get('/getUser', 'UserController@getUser')->name('getUser');
    Route::post('/addAdmin', 'UserController@addAdmin')->name('users.addAdmin');
    Route::get('/getAdmin', 'UserController@getAdmin')->name('users.getAdmin');
    Route::delete('/removeAdmin', 'UserController@removeAdmin')->name('users.removeAdmin');
    Route::get('users/{user_id}/settings', 'UserController@settings')->name('users.settings');
    Route::get('users/{user_id}/sectors', 'UserController@sectors')->name('users.sectors');
    Route::put('users/{user_id}/storesectors', 'UserController@storesectors')->name('users.storesectors');
    Route::get('/businessAngel', 'UserController@businessAngel')
    ->name('users.businessAngel');
    Route::get('getMyAccounts', 'UserController@getMyAccounts')->name('getMyAccounts');
    Route::put('setPageSelected', 'UserController@setPageSelected')->name('setPageSelected');
    Route::put('/mailSettingToggle', 'UserController@mailSettingToggle')
    ->name('mailSettingToggle');

    //PAGE
    Route::resource('/pages', 'PageController');
    Route::get('/newPage/{pagetype_id}', 'PageController@newPage')->name('pages.newPage');
    Route::get('pages/{page_id}/settings', 'PageController@settings')->name('pages.settings');
    Route::get('pages/{page_id}/sectors', 'PageController@sectors')->name('pages.sectors');
    Route::put('pages/{page_id}/storesectors', 'PageController@storesectors')->name('pages.storesectors');
    Route::get('/incubator/{page_id}', 'PageController@incubator')
    ->name('pages.incubator');

    //IMAGE
    Route::get('/editUserImage', 'ImageController@editUserImage')->name('images.editUserImage');
    Route::put('/updateUserImage', 'ImageController@updateUserImage')
    ->name('images.updateUserImage');
    Route::delete('/removeUserImage', 'ImageController@removeUserImage')->name('removeUserImage');
    Route::get('/editPageImage/{page_id}', 'ImageController@editPageImage')->name('images.editPageImage');
    Route::put('/updatePageImage', 'ImageController@updatePageImage')
    ->name('images.updatePageImage');
    Route::delete('/removePageImage/{page_id}', 'ImageController@removePageImage')->name('images.removePageImage');

    //GiveUserSkills
    Route::resource('/give_user_skills', 'GiveUserSkillController');

    //OFFERTE NECESSITA'
    Route::get('/needs', 'GiveHaveController@getAllHave')
    ->name('needs.getAllHave');
    Route::get('/offers', 'GiveHaveController@getAllGive')
    ->name('offers.getAllGive');
    Route::get('/loadNeedInfo', 'GiveHaveController@loadNeedInfo')->name('loadNeedInfo');
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

    // TEAM
    Route::resource('/teams', 'TeamController');
    Route::get('/addTeam/{page_id}', 'TeamController@addTeam')->name('teams.addTeam');
    Route::post('/storeTeam/{page_id}', 'TeamController@storeTeam')->name('teams.storeTeam');
    Route::delete('/deleteTeam', 'TeamController@deleteTeam')->name('deleteTeam');
    Route::put('/changeTeamPosition', 'TeamController@changeTeamPosition')->name('teams.changeTeamPosition');

    //COMPANY
    Route::resource('/companies', 'CompanyController');

    //LIFECYCLE
    Route::resource('/lifecycles', 'LifecycleController');

    //FOLLOW
    Route::resource('/follows', 'FollowController');
    Route::post('/toggleFollowing', 'FollowController@toggleFollowing')->name('toggleFollowing');
    Route::get('/getFollowed', 'FollowController@getFollowed')->name('getFollowed');

    //COLLABORATIONS
    Route::resource('/collaborations', 'CollaborationController');
    Route::get('collaborations/my/{id}/{user_or_page}', 'CollaborationController@my')->name('collaborations.my');
    Route::get('getCollaborations', 'CollaborationController@getCollaborations')->name('getCollaborations');
    Route::get('getProposalCollaborations', 'CollaborationController@getProposalCollaborations')->name('getProposalCollaborations');
    Route::delete('deleteCollaboration', 'CollaborationController@deleteCollaboration')
    ->name('deleteCollaboration');
    Route::put('confirmCollaboration', 'CollaborationController@confirmCollaboration')
    ->name('confirmCollaboration');
    Route::post('addCollaboration', 'CollaborationController@addCollaboration')
    ->name('addCollaboration');
    Route::get('/loadCollaborationsInfo', 'CollaborationController@loadCollaborationsInfo')
    ->name('loadCollaborationsInfo');
    Route::get('/latestCollaborations', 'CollaborationController@latestCollaborations')
    ->name('latestCollaborations');

    //CHATS
    Route::resource('/chats', 'ChatController');
    Route::get('chats/show/{chat_id}/{page_id}', 'ChatController@show')
    ->name('chats.show');
    Route::post('/createChat', 'ChatController@createChat')
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
    // Route::get('/mailMessage', 'MailController@mailMessage')
    // ->name('mails.mailMessage');

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

    //VIEW
    Route::get('/myLatestViews', 'ViewController@myLatestViews')->name('myLatestViews');
    Route::get('/mostViewedAccounts', 'ViewController@mostViewedAccounts')->name('mostViewedAccounts');

});
