<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Employee;
use App\Http\Controllers\Head;
use App\Http\Controllers\Profile;
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
    return view('welcome');
});

Route::controller(Admin::class)->group(function (){
    Route::get('/admin/login', [Admin::class, 'login']);
    Route::get('/admin/home', [Admin::class, 'dashboard']);
    Route::get('/admin/dashboard', [Admin::class, 'dashboard']);
    Route::get('/admin/employees', [Admin::class, 'employees']);
    Route::get('/admin/heads', [Admin::class, 'heads']);
    Route::get('/admin/departments', [Admin::class, 'departments']);
});

Route::controller(Employee::class)->group(function(){
    Route::get('employee/login', [Employee::class, 'login']);
    Route::get('employee/home', [Employee::class, 'home']);
    Route::get('employee/', [Employee::class, 'home']);
    Route::get('employee/tasks', [Employee::class, 'home']);
    Route::get('employee/task/id', [Employee::class, 'task']);
    Route::get('employee/profile', [Employee::class, 'profile']);
    
});

Route::controller(Head::class)->group(function() {
    Route::get('head/login', [Head::class, 'login']);
    Route::get('head/home', [Head::class, 'home']);
    Route::get('head/', [Head::class, 'home']);
});

Route::controller(Profile::class)->group(function(){
    Route::get('profile/id', [Profile::class, 'show']);
});