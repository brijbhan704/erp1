<?php

use Illuminate\Http\Request;

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
Use App\Rest;

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::post('sendotp', 'UserController@sendotp');
//update device token
 Route::post('updateDeviceToken', 'UserController@updateDeviceToken');
Route::post('fetchCategory', 'CategoryController@fetchCategory');
Route::post('fetchDepartment', 'DepartmentController@fetchDepartment');
Route::post('getProject', 'UserController@getProject');

Route::post('userList', 'UserController@getUserList');
Route::post('getUserByCity', 'UserController@getUserByCity');


Route::post('eventList', 'EventController@getEventList');

Route::post('cityList', 'CountryController@getCityList');
Route::post('otpVerification', 'UserController@otpVerification');

Route::post('notifyMe', 'UserController@notifyMe');
Route::post('resentRegisterOtp', 'UserController@resentRegisterOtp');

Route::post('setLatestVersion', 'VersionController@setLatestVersion');
Route::post('getLatestVersion', 'VersionController@getLatestVersion');
Route::post('deleteVersion', 'VersionController@deleteVersion');

Route::post('forgotPassword', 'UserController@forgotPassword'); 
Route::post('verifyForgotPassword', 'UserController@verifyForgotPassword'); 

Route::post('addRating', 'RatingController@addRating');  

Route::post('getHomePage', 'AmenitiesController@getHomePage');  
Route::post('getAmenityGallery', 'AmenitiesController@getAmenityGallery');
Route::post('getAmenityGallery', 'AmenitiesController@getAmenityGallery');

Route::post('getMasterPlan', 'MasterplanController@getMasterPlan');
Route::post('getMasterChildPlan', 'MasterplanController@getMasterChildPlan');

Route::post('getFloorPlan', 'FloorplanController@getFloorPlan');
Route::post('getFloorChildPlan', 'FloorplanController@getFloorChildPlan');
Route::post('teamlist', 'UserController@teamlist');
Route::post('getnews', 'UserController@getnews');


Route::get('commonData', 'UserController@commonData');  



Route::post('contactus', 'UserController@contactus');
Route::post('appointments', 'UserController@appointments');

Route::get('constructionUpdate', 'ConstructionsController@constructionUpdate');


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');       
    Route::post('apilogout', 'UserController@apilogout');
    Route::post('addEvent', 'EventController@addEvent');
    Route::post('changePassword', 'UserController@changePassword');
    Route::post('getMyEventList', 'EventController@getMyEventList');      
    Route::post('editMyEvent', 'EventController@editMyEvent');
    Route::post('editMyProfile', 'UserController@editMyProfile');   
    //expenses  
    Route::post('addExpense','ExpenseController@addExpense');
    Route::post('viewAllExpense','ExpenseController@viewAllExpense');
    Route::post('deleteExpense','ExpenseController@deleteExpense');
    Route::post('updateExpense','ExpenseController@updateExpense');
	Route::post('viewExpense','ExpenseController@viewExpense');

    Route::post('userProfile','UserController@userProfile');
    
    Route::post('updateUser','UserController@updateUser');
	Route::post('viewExpenseByUser','ExpenseController@viewExpenseByUser');
	
});

