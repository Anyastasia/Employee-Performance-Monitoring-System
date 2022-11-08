<?php 

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Inertia\Inertia;
    use Illuminate\Http\Request;

    use App\Models\Employee;
    use App\Models\Division;


    use Illuminate\Support\Facades\Auth;
    use App\Models\Head as HeadModel;

    class Head extends Controller {


        public function __construct()
        {
            $this->middleware('head');
        }

        public function home(Request $request) {
            return Inertia::render('Head/HeadHome', [
                'employees' => Employee::all('id', 'first_name', 'last_name', 'email', 'division_id', 'position'),
                'divisions' => Division::all(),
                'head' => Auth::guard('head')->id(),
            ]);
        }

        public function profile() {
            return view('layout.head.profile');
        }

        public function dashboard() {
            return Inertia::render('Head/HeadDashboard');
        }
    }

?>