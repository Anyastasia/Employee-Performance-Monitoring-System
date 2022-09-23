<!DOCTYPE html>
<html lang="en">
<head>
    @include('include/head')
    <title>Home | EPMS</title>
</head>
<body>
    <div class="master-grid">
        <header>
            <nav class="dropdown flex flex-right mt-1 mr-3">
                <span class="dropdown-button" role="button">
                    <img src="{{url('images/profile-placeholder.png')}}" alt="">
                </span>

                <ul class="dropdown-content">
                    <li class="dropdown-item">Settings</li>
                    <li class="dropdown-item">Log out</li>
                </ul>
            </nav>  
        </header>

        <x-notification>
            <x-slot:header>Notifications</x-slot:header>
            <x-notification.item href="">
                <x-slot:description>X person assigned a new task</x-slot>
                <x-slot:time>1 hour ago</x-slot:time>
            </x-notification.item>
        </x-notification>

        @include('include/employee/sidebar')

        <main class="px-3"> 
            <h1>Tasks</h1>

            <section class="py-1">
                <div>
                    <button class="button button-text button-text-underlined">Active</button>
                    <button class="button button-text">Completed</button>
                </div>
            </section>

            <x-tasks>
                <x-tasks.item href="{{url('/employee/tasks/task')}}">
                    <x-slot:header>Task</x-slot>
                    <x-slot:deadline>September 17, 2021</x-slot>
                </x-tasks.item>
            </x-tasks>
        </main> 
    </div>
    <script src="{{url('js/dialog.js')}}"></script>
    <script src="{{url('js/dropdown.js')}}"></script>

    {{-- <script src="{{ url('js/admin.js')}}"></script> --}}
</body>
</html>