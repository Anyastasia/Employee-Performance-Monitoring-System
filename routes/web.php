<?php

use App\Http\Controllers\Head;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Employee;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Register\RegisterEmployee;
use App\Http\Controllers\Register\RegisterDivision;
use App\Http\Controllers\Register\RegisterHead;

use App\Http\Controllers\Login\LoginEmployee;
use App\Http\Controllers\Login\LoginHead;
use App\Http\Controllers\Login\LoginAdmin;

use App\Http\Controllers\AssignedTask;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/sample', function(){
    return Inertia::render('Employee/EmployeeHome');
});

Route::get('/sample2', function(){
    return Inertia::render('Sample');
});


Route::controller(Employee::class)->middleware('employee')->group(function() {
    Route::get('/employee', [Employee::class, 'home']);
    Route::get('/employee/home', [Employee::class, 'home']);
    Route::get('/employee/profile', [Employee::class, 'profile']);
    Route::get('/employee/tasks', [Employee::class, 'tasks']);
    Route::post('employee/logout', [Employee::class, 'logout']);
});


Route::controller(Admin::class)->group(function() {
    Route::get('/admin/employees', [Admin::class, 'employees']);
    Route::get('/admin/divisions', [Admin::class, 'divisions']);
    Route::get('/admin/heads', [Admin::class, 'heads']);
});


Route::controller(Head::class)->middleware('head')->group(function() {
    Route::get('/head', [Head::class, 'home'])->name('head_home');
    Route::get('/head/home', [Head::class, 'home']);
    Route::get('/head/employees', [Head::class, 'home']);
    Route::get('/head/dashboard', [Head::class, 'dashboard']);
});


Route::get('/login/employee', [LoginEmployee::class, 'create'])->name('login_employee');
Route::post('/login/employee/auth', [LoginEmployee::class, 'store']);

Route::get('/login/head', [LoginHead::class, 'create'])->name('login_head');
Route::post('/login/head/auth', [LoginHead::class, 'store']);

Route::get('/login/admin', [LoginAdmin::class, 'create'])->name('login_admin');
Route::post('/login/admin/auth', [LoginAdmin::class, 'store']);


Route::get('/task/id', function(){
    return Inertia::render('Employee/EmployeeTask');
});

Route::post('/assign/task/store', [AssignedTask::class, 'store']);


Route::post('/register/employee/store', [RegisterEmployee::class, 'store']);
Route::post('/register/division/store', [RegisterDivision::class, 'store']);
Route::post('/register/head/store', [RegisterHead::class, 'store']);


Route::post('/something', function() {
    return inertia('Welcome');
})->middleware('sample');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
