<?php 

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;

    class Profile extends Controller {

        public function show() {
            return view('profile.show');
        }
    }
?>