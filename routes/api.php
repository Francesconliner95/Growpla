<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/searchUser', 'Api\UserController@searchUser');
Route::get('/searchPage', 'Api\PageController@searchPage');

Route::post('/sendEmail', 'Api\HomeController@sendEmail');

Route::post('/acceptConsentScreen', 'Api\CookieController@acceptConsentScreen');

Route::get('/getAccountTypes', 'Api\AccountTypesController@getAccountTypes');

Route::get('/getStartupStates', 'Api\StartupStateController@getStartupStates');

Route::get('/getAccountServices', 'Api\StartupserviceTypeController@getAccountServices');

Route::get('/getStartupserviceType', 'Api\StartupserviceTypeController@getStartupserviceType');

Route::get('/getAccount', 'Api\AccountController@getAccount');

Route::get('/getTeamMembers', 'Api\TeamController@getTeamMembers');

Route::get('/getLastAccounts', 'Api\AccountController@getLastAccounts');

Route::get('/getNeeds', 'Api\NeedController@getNeeds');
Route::get('/getAccountNeeds', 'Api\NeedController@getAccountNeeds');

Route::get('/getRegions', 'Api\RegionController@getRegions');

Route::get('/getCooperation', 'Api\CooperationController@getCooperation');

Route::get('/getTag', 'Api\TagController@getTag');
Route::get('/searchTag', 'Api\TagController@searchTag');

Route::get('/getCofounder', 'Api\CofounderController@getCofounder');

Route::get('/searchRole', 'Api\CofounderRoleController@searchRole');
Route::get('/searchCompany', 'Api\CompanyController@searchCompany');

Route::get('/advancedSearch', 'Api\SearchController@advancedSearch');

Route::get('/getMultipleSections', 'Api\OtherController@getMultipleSections');
Route::get('/getSectionOthers', 'Api\OtherController@getSectionOthers');
