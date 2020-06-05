<?php

use Illuminate\Support\Facades\Route;

// function gravaratar_url($email){
//     $email = md5($email);
//     return "https://gravatar.com/avatar/{ $email }?s=60&d=https://s3.amazonaws.com/laracast/images/default-square-avatar.jpg";
// }
// \App\Activity::created(function($project){
//     \App\Activity::create([
//         'project_id' => $Project->id,
//         'description' => 'created',
//     ]);
// });
// \App\Activity::updated(function($project){
//     \App\Activity::create([
//         'project_id' => $Project->id,
//         'description' => 'updated',
//     ]);
// });
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

Route::group(['middleware' => 'auth'], function(){
    // Route::get('/projects', 'ProjectsController@index');
    // Route::get('/projects/create', 'ProjectsController@create');
    // Route::get('/projects/{project}', 'ProjectsController@show');
    // Route::get('/projects/{project}/edit', 'ProjectsController@edit');
    // Route::patch('/projects/{project}', 'ProjectsController@update');
    // Route::post('/projects', 'ProjectsController@store');
    // Route::delete('/projects/{project', 'ProjectsController@destroy');
    Route::resource('projects', 'ProjectsController');

    Route::post('/projects/{project}/invitations', 'ProjectInvitationsController@store');
    
    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectTasksController@update');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();

