<!DOCTYPE html>
<html lang="en">
<head>
    @include('include/head')
    <title>Departments | EPMS</title>
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

        <main>
            <a class="icon-link display-inline-block ml-4 mr-1" href="{{url('/admin/dashboard')}}">
                <i class="h1 bi bi-arrow-left"></i>
            </a>
            <h1 class="display-inline">Departments</h1>

            <div class="flex flex-center">
                <section class="table-container px-4 py-1">
                    <table class="table m-inline-auto">
                        <thead>
                            <tr>
                                <th>Department Name</th>
                                <th>Department Head</th>
                                <th># of Active Employees</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Department of Health</td>
                                <td>Marisa Kirisame</td>
                                <td>44</td>
                            </tr>

                            <tr>
                                <td>Department of What</td>
                                <td>Alice Margatroid</td>
                                <td>101</td>
                            </tr>

                            <tr>
                                <td>Department of What</td>
                                <td>Reisen Inaba</td>
                                <td>10</td>
                            </tr>

                        </tbody>
                    </table>
                </section>
            </div>

        </main>
    </div>
    <script src="{{url('js/admin.js')}}"></script>
</body>
</html>