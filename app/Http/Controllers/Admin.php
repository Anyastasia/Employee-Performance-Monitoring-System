<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\Models\Employee;
    use App\Models\Division;
    use App\Models\Head;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Auth;

    use Inertia\Inertia;

    class Admin extends Controller {


        public function division_list_admin() {
            return Inertia('Admin/AdminDivision', [
                'divisions' => Division::where('status', 'active')->get(),
                // 'employee' => Employee::where('id', Auth::guard('employee')->id())->get()->first(),
            ]);
        }

        public function employee_list_admin($id) {
            if ($id == 0) {
                return Inertia('Admin/AdminEmployee', [
                    'employees' => Employee::where('status', 'active')->get(), 
                    'divisions' => Division::where('status', 'active')->get(),
                    // 'employee' => Employee::where('id', Auth::guard('employee')->id())->get()->first(),
                    "division_id" => $id,
                ]);
            } else {
                return Inertia('Admin/AdminEmployee', [
                    'employees' => Employee::where('status', 'active')
                    ->where('division_id', $id)->get(), 
                    'divisions' => Division::where('status', 'active')->get(),
                    // 'employee' => Employee::where('id', Auth::guard('employee')->id())->get()->first(),
                    "division_id" => $id,
                ]);
            }
        }

        public function deactivate_division($id) {
            $model = Division::where('id', $id)->get()->first();
            $model->status = 'inactive';
            $model->save();

            return Redirect::route('admin.divisions')->with('info', 'Division deleted');
        }

        public function deactivate_employee(Request $request) {
            $model = Employee::where('id', $request->id)->get()->first();
            $model->status = 'inactive';
            $model->save();

            return Redirect::route('admin.employees', 0)->with('info', 'Employee removed.');
        }

    }

?>