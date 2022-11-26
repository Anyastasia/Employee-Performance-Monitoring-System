<?php

namespace App\Http\Controllers\Change\Head;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Head;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Head\ChangePasswordRequest;

class Password extends Controller
{
    //
    public function update(ChangePasswordRequest $request) {

        $validator = $request->validated();

        $id = Auth::guard('head')->id();
        $model = Head::where('id', $id)->get()->first();

        $model->password = Hash::make($validator['password']);
        $model->save();
    }
}
