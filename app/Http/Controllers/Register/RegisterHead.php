<?php

namespace App\Http\Controllers\Register;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Head;
use Illuminate\Validation\Rule;

class RegisterHead extends Controller
{
    //
    private $table = 'heads';
    public function store(Request $request) {

        $validate = $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email', Rule::unique($this->table, 'email')],
            'division_id' => ['required'],
            'position' => ['required'],
            'password' => ['required'],
        ]);

        $head = Head::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'division_id' => $request->division_id,
            'position' => $request->position,
            'avatar_path' => $request->avatar_path,
            'password' => bcrypt($request->password),
       ]);
    

    }
}
