<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Download extends Controller
{
    //
    public function getFile($file) {
        
        $xfile = '/uploads/'.$file;
        // dd($xfile);
        return Storage::download($xfile);
    }
}
