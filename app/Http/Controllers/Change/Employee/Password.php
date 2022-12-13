<?php

namespace App\Http\Controllers\Change\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
class Password extends Controller
{
    //
    public function update(ChangePasswordRequest $request) {

        $validator = $request->validated();

        $id = Auth::guard('employee')->id();
        $model = Employee::where('id', $id)->get()->first();

        $model->password = Hash::make($validator['password']);
        $model->save();

        return Redirect::route('employee.profile');
    }
}
