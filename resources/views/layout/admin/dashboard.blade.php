<!DOCTYPE html>
<html lang="en">
<head>
    @include('include/head')
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="root">
        <header>
            <nav class="dropdown flex flex-right mt-3 mr-5">
                <button class="button button-outline-primary dropdown-button">
                    Admin
                    <i class="bi bi-caret-down-fill"></i>
                </button>

                <ul class="dropdown-content">
                    <li class="dropdown-item">Settings</li>
                    <li class="dropdown-item">Log out</li>
                </ul>
            </nav>  
        </header>
        
        
        <dialog class="dialog add-staff-dialog mt-3" id="add-employee-dialog">
            <section>
                <form action="">
                    <h1 class="my-1 h1">Add Employee</h1>
                    <div class="name">
                        <div>
                            <label for="firstname" class="required">First Name</label>
                            <input type="text" id="firstname" name="firstname" required>

                        </div>

                        <div>
                            <label for="firstname">Middle Name</label>
                            <input type="text" id="middlename" name="middlename">
                        </div>

                        <div>
                            <label for="firstname" class="required">Last Name</label>
                            <input type="text" id="lastname" name="lastname" required>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="required">Email</label>
                        <input type="email" name="email" id="email" required>
                    </div>

                    <div>
                        <label for="department" class="required">Department</label>
                        <input type="text" name="department" id="department" required>
                    </div>

                    <div>
                        <label for="password" class="required">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <button type="submit" class="button button-primary">Submit</button>
                    <button class="button button-text close-dialog">Close</button>
                </form>
            </section>
        </dialog>


        <dialog class="dialog add-staff-dialog mt-3" id="add-head-dialog">
            <section>
                <form action="">
                    <h1 class="my-1 h1">Add Department Head</h1>
                    <div class="name">
                        <div>
                            <label for="firstname" class="required">First Name</label>
                            <input type="text" id="firstname" name="firstname" required>

                        </div>

                        <div>
                            <label for="firstname">Middle Name</label>
                            <input type="text" id="middlename" name="middlename">
                        </div>

                        <div>
                            <label for="firstname" class="required">Last Name</label>
                            <input type="text" id="lastname" name="lastname" required>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="required">Email</label>
                        <input type="email" name="email" id="email" required>
                    </div>

                    <div>
                        <label for="department" class="required">Department</label>
                        <input type="text" name="department" id="department" required>
                    </div>

                    <div>
                        <label for="password" class="required">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <button type="submit" class="button button-primary">Submit</button>
                    <button class="button button-text close-dialog">Close</button>
                </form>
            </section>
        </dialog>

        <main class="mx-5">

            <h1 class="h1 my-3">Dashboard</h1>

            <section>
                <button id="add-employee" class="button dialog-button"><i class="bi bi-plus-lg"></i>Add employee</button>
                <button id="add-head" class="button dialog-button"><i class="bi bi-plus-lg"></i>Add department head</button>
            </section>

            <section class="dashboard-flex">
                <a href="{{url('/admin/heads')}}" class="xcard">
                    <i class="xcard-icon bi bi-person-check-fill"></i>
                    <article class="xcard">
                        <h2>Department Heads</h2>
                    </article>
                </a>

                <a href="{{url('/admin/departments')}}" class="xcard">
                    <i class="xcard-icon bi bi-building"></i>
                    <article class="xcard">
                        <h2>Departments</h2>
                    </article>
                </a>

                <a href="{{url('/admin/employees')}}" class="xcard">
                    <i class="xcard-icon bi bi-person-fill"></i>
                    <article class="xcard">
                        <h2>Employees</h2>
                    </article>
                </a>
                
            </section>
        </main>
        <footer></footer>
    </div>
    <script src="{{url('js/admin/dashboard.js')}}"></script>
</body>
</html>