<?php

use App\Http\Controllers\Head;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Employee;
use App\Http\Controllers\AssignedTask;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Register\RegisterEmployee;
use App\Http\Controllers\Register\RegisterDivision;
use App\Http\Controllers\Register\RegisterHead;

use App\Http\Controllers\Login\LoginEmployee;
use App\Http\Controllers\Login\LoginHead;
use App\Http\Controllers\Login\LoginAdmin;

use App\Http\Controllers\Change\Employee\Password as EmployeeChangePassword;
use App\Http\Controllers\Change\Head\Password as HeadChangePassword;
use App\Http\Controllers\SubmittedTask;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function(){
    return Inertia::render('Index');
});

Route::controller(Employee::class)->middleware(['employee'])->group(function() {
    Route::get('/employee', [Employee::class, 'home']);
    Route::get('/employee/home', [Employee::class, 'home']);
    Route::get('/employee/completed', [Employee::class, 'completed']);
    Route::get('/employee/active', [Employee::class, 'active']);
    Route::get('/employee/profile', [Employee::class, 'profile'])->name('employee.profile');
    Route::get('/employee/task/{id}', [Employee::class, 'task'])->name('employee.task');
    Route::post('/employee/logout', [Employee::class, 'logout']);
});

Route::controller(Admin::class)->middleware('admin')->group(function() {
    Route::get('/admin', [Admin::class, 'employees']);
    Route::get('/admin/employees', [Admin::class, 'employees']);
    Route::get('/admin/divisions', [Admin::class, 'divisions']);
    Route::get('/admin/heads', [Admin::class, 'heads']);
    Route::post('/admin/delete/division/{id}', [Admin::class, 'deactivate_division']);
    Route::post('/admin/delete/employee/{id}', [Admin::class, 'deactivate_employee']);
    Route::post('/admin/delete/head/{id}', [Admin::class, 'deactivate_division']);
    Route::post('/admin/logout', [Admin::class, 'logout']);
});


Route::controller(Head::class)->middleware('head')->group(function() {
    Route::get('/head', [Head::class, 'home'])->name('head_home');
    Route::get('/head/profile', [Head::class, 'profile']);
    Route::get('/head/home', [Head::class, 'home']);
    Route::get('/head/employees', [Head::class, 'home'])->name('head_employees');
    Route::get('/head/dashboard', [Head::class, 'dashboard']);
    Route::get('/head/employee/{id}',[Head::class, 'employee']);
    Route::get('/head/task/{id}',[Head::class, 'task']);
    Route::get('head/view/task/{id}', [Head::class, 'view_task']);
    Route::post('/head/logout', [Head::class, 'logout']);
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
Route::post('/head/task/approve/{id}', [AssignedTask::class, 'update_status']);
Route::post('/head/task/revise/{id}', [AssignedTask::class, 'revise']);

Route::post('/task/submit/store', [SubmittedTask::class, 'store']);
Route::post('/task/submit/update', [SubmittedTask::class, 'update']);
Route::post('/task/submit/resubmit', [SubmittedTask::class, 'resubmit']);

Route::post('/register/employee/store', [RegisterEmployee::class, 'store']);
Route::post('/register/division/store', [RegisterDivision::class, 'store']);
Route::post('/register/head/store', [RegisterHead::class, 'store']);


Route::post('/employee/profile/changePassword', [EmployeeChangePassword::class, 'update']);
Route::post('/head/profile/changePassword', [HeadChangePassword::class, 'update']);

Route::post('/something', function() {
    return inertia('Welcome');
})->middleware('sample');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
