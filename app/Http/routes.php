<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {


    Route::group(['prefix'=>'api'], function(){

        //Logs in a user.
        Route:: post('login', 'UserController@login');

        //Registers a user
        Route:: post('register', 'UserController@register');

        //Logout a user.
        Route:: get('logout', 'UserController@logout');



        Route::group(['middleware'=>'auth'],function(){

            //Get logged in user info.
            Route:: get('user', 'UserController@user');


        });


        //===========//=============//=================//====================//========================//=============================//
        //Documentation
        Route::get('/', function () {
            return response()->json([
                'success'   =>  true,
                'message'   =>  "You are in the API of BengalDeals.",
                'API'       =>  [

                    'login' => [
                        'url'       => '/login',
                        'method'    => 'POST',
                        'params'    => 'email, password',
                        'response'  => 'success: true/false',
                        'task'      => 'Logs in a user'],

                    'register' => [
                        'url'       => '/register',
                        'method'    => 'POST',
                        'params'    => 'name, email, password',
                        'response'  => 'success: true/false',
                        'task'      => 'Registers a user or sends validation message.'],

                    'logout' => [
                        'url'       => '/logout',
                        'method'    => 'GET',
                        'response'  => 'success: true',
                        'task'      => 'Logs out current user'],

                    'current user'  => [
                        'url'       => '/user',
                        'method'    => 'GET',
                        'response'  => 'success: true [authentication required]',
                        'task'      => 'Gets current logged in user'],

                ]
            ]);

        });
        //===========//=============//=================//====================//========================//=============================//
    });



});
