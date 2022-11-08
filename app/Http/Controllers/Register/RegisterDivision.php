<?php


namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Division;

class RegisterDivision extends Controller {

    function store(Request $request) {

        $division = new Division;

        $division->name = $request->name;
        $division->save();
    }

}

?>