<!DOCTYPE html>
<html lang="en">
<head>
    @include('include/head')
    <title>Home | EPMS </title>
</head>
<body>
    <div class="master-grid">
        
        <header>
            <nav class="dropdown flex flex-right mt-1 mr-3">
                <span class="dropdown-button">
                    <img src="{{url('images/profile-placeholder.png')}}" alt="">
                </span>

                <ul class="dropdown-content">
                    <li class="dropdown-item">Settings</li>
                    <li class="dropdown-item">Log out</li>
                </ul>
            </nav>
        </header>

        @include('include/head/sidebar')

        <main>
            <div class="table-container mx-3 my-1 px-2 py-1">
                <h1 class="mb-1">Employee List</h1>

                <section class="py-1">
                    <label for="search-employee">Search Employee</label>
                    <input type="search" name="search-employee" id="search-employee">

                    <select name="employee-status" id="employee-status">
                        <option value="active">Idle</option>
                        <option value="idle">Active</option>
                        <option value="offline">Offline</option>
                        <option value="all">All</option>
                    </select>
                </section>
                
                <section> 
                    <x-table>
                        <x-table.header>
                            <x-table.header-row>Employee</x-table.header-row>
                            <x-table.header-row>Status</x-table.header-row>
                            <x-table.header-row>Actions</x-table.header-row>
                        </x-table.header>
                        <x-table.body>
                            <x-table.row>Marisa Kirisame</x-table.row>
                            <x-table.row>Active</x-table.row>
                            <x-table.row>
                                <div class="flex">
                                    <x-button>Assign</x-button>
                                    <x-button variant="text">View Tasks</x-button>
                                    <x-button variant="text">Evaluate</x-button>
                                </div>
                            </x-table.row>
                        </x-table.body>
                    </x-table>
                </section>
            </div>
        </main>
    <div>
    <script src="{{ url('js/admin.js')}}"></script>
</body>
</html>