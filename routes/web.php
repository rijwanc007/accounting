<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//dashboard route
Route::get('/home', 'HomeController@index')->name('home');
//user route
Route::resource('user','Admin\UserController');
Route::post('/user/search','Admin\UserController@userSearch')->name('user.search');
//account route
Route::resource('account','Admin\AccountController');
Route::post('/account/search','Admin\AccountController@accountSearch')->name('account.search');
//main head route
Route::resource('main_head','Admin\MainHeadController');
Route::post('/main_head/account_code/serial/','Admin\MainHeadController@accountCodeSerial');
//sub head route
Route::resource('sub_head','Admin\SubHeadController');
//sub sub head
Route::resource('sub_sub__head','Admin\SubSubHeadController');
//message route
Route::resource('message','Admin\MessageController');
Route::post('/multi_user_message_store','Admin\MessageController@multiUserMessageStore')->name('multi.user.message.store');
Route::get('/message/details/{id}','Admin\MessageController@messageDetails');
Route::post('/message/search','Admin\MessageController@messageSearch')->name('message.search');
//announcement route
Route::resource('announcement','Admin\AnnouncementController');
Route::post('/announcement/search','Admin\AnnouncementController@announcementSearch')->name('announcement.search');