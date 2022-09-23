<!DOCTYPE html>
<html lang="en">
<head>
    @include('include/head')
    <title>Department Heads | EPMS</title>
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
                    <h1 class="my-1 h1">Edit Department Head</h1>
                    <div class="name">
                        <div>
                            <label for="firstname">First Name</label>
                            <input type="text" id="firstname" name="firstname">

                        </div>

                        <div>
                            <label for="firstname">Middle Name</label>
                            <input type="text" id="middlename" name="middlename">
                        </div>

                        <div>
                            <label for="firstname">Last Name</label>
                            <input type="text" id="lastname" name="lastname">
                        </div>
                    </div>

                    <div>
                        <label for="email" >Email</label>
                        <input type="email" name="email" id="email">
                    </div>

                    <div>
                        <label for="department" >Department</label>
                        <input type="text" name="department" id="department">
                    </div>

                    <div>
                        <label for="password" >Password</label>
                        <input type="password" name="password" id="password">
                    </div>

                    <button type="submit" class="button button-primary">Submit</button>
                    <button class="button button-text close-dialog">Close</button>
                </form>
            </section>
        </dialog>

        <main>
            <a class="icon-link display-inline-block ml-4 mr-1" href="{{url('/admin/dashboard')}}">
                <i class="h1 bi bi-arrow-left"></i>
            </a>
            <h1 class="display-inline">Department Heads</h1>
            <div class="flex flex-center mt-2 flex-col">

                <section class="mb-2">
                    <label for="search">Search</label>
                    <input type="search" name="search" id="search" class="px--75 py--5">
                </section>

                <section class="table-container px-4 py-1"">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Alice Margatroid</td>
                                <td>Dpartment of Something</td>
                                <td>email@email.com</td>
                                <td class="flex flex-center py-75 px-1">
                                    <button class="button button-primary dialog-button">Edit</button>
                                    <button class="button button-text">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
    </div>

    <script src="{{url('js/dialog.js')}}"></script>
    <script src="{{url('js/dropdown.js')}}"></script>
</body>
</html>