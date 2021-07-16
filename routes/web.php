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

Route::get('/', function () {
    return redirect('/home');
});

// Students routes
Route::get('student/create', 'StudentController@create')->name('student.create');
Route::post('student/create', 'StudentController@create')->name('student.create');
Route::get('student/search', 'StudentController@search')->name('student.search');
Route::get('student/edit/{id}', 'StudentController@edit')->name('student.edit');
Route::post('student/edit/{id}', 'StudentController@edit')->name('student.edit');

// Guardians routes
Route::get('guardian/create', 'GuardianController@create')->name('guardian.create');
Route::post('guardian/create', 'GuardianController@create')->name('guardian.create');
Route::get('guardian/search', 'GuardianController@search')->name('guardian.search');
Route::get('guardian/edit/{id}', 'GuardianController@edit')->name('guardian.edit');
Route::post('guardian/edit/{id}', 'GuardianController@edit')->name('guardian.edit');

// Courses routes
Route::get('course/search', 'CourseController@search')->name('course.search');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
