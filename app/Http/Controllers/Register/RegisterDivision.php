<?php


namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Division;
use Illuminate\Support\Facades\Redirect;

class RegisterDivision extends Controller {

    function store(Request $request) {

        $division = new Division;

        $division->name = $request->name;
        $division->save();

        return Redirect::route('admin.divisions')->with('success', 'Division added.');
    }

}

?>