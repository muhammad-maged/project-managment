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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/create-project', 'ProjectController@createProjectForm')->name('create-project-form');
Route::post('/add-project', 'ProjectController@createProject')->name('create-project');
Route::post('/edit-project/{id}', 'ProjectController@editProject')->name('editProject-post');
Route::get('/projects', 'ProjectController@viewProjects')->name('viewProjects');
Route::get('/project/{id}', 'ProjectController@viewProject')->name('editProject');
Route::get('/project-plan/{id}', 'ProjectController@projectPlan')->name('projectPlan');
Route::post('/add-task', 'ProjectController@createTask')->name('createTask');
Route::post('/project-days/{id}', 'ProjectController@postProjectHours')->name('postProjectHours');
Route::get('/Task/{id}', 'ProjectController@editTask')->name('editTask');
Route::post('/update-task', 'ProjectController@updateTask')->name('updateTask');
Route::get('/delete-task/{id}', 'ProjectController@deleteTask')->name('deleteTask');



