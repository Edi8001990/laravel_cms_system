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



Auth::routes();

// Route::get('/home', 'HomeController@index');



Route::get('/home', 'HomeController@index')->name('home');





Route::group(['middleware'=>'admin'], function(){



  Route::name('admin')->resource('/admin/users', 'AdminUsersController');
  Route::get('/', function(){
    return view('admin.index');
  });



});

// Route::resource('/admin/users', 'AdminUsersController');

// Route::resource('admin/users/create', 'AdminUsersController');
