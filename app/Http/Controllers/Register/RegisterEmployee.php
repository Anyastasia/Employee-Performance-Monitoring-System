<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class RegisterEmployee extends Controller
{
    //
    private $table = 'employees';
    public function store(Request $request) {
        // $attributes = $request->validate([
        //     'firstname' => 'required',
        //     'lastname' => 'required',
        //     'email' => ['required', 'email'],
        //     'department' => 'required',
        //     'position' => 'required',
        //     'password' => 'required',
        // ]);

        // dd(bcrypt($request->password));

        $validate = $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email', Rule::unique($this->table, 'email')],
            'birthday' => ['required'],
            'employee_status' => ['required'],
            'division_id' => ['required'],
            'position' => ['required'],
            'password' => ['required'],
        ]);

        $employee = Employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'employee_status' => $request->employee_status,
            'division_id' => $request->division_id,
            'position' => $request->position,
            'avatar_path' => $request->avatar_path,
            'password' => bcrypt($request->password),
       ]);

       return Redirect::route('admin.employees', 0)->with('success', 'Employeed added.');
       
    }
}
