<!DOCTYPE html>
<html lang="en">
<head>
    @include('include/head')
    <title>Home | EPMS</title>
</head>
<body>
    @php
        $data = array(
            array('description' => 'lorem ipsum dolor wahahaha', 'time' => 'septermber 17, 2021'),
            array('description' => 'lorem ipsum dolor wahahaha', 'time' => 'septermber 17, 2021'),
            array('description' => 'lorem ipsum dolor wahahaha', 'time' => 'septermber 17, 2021'),
            array('description' => 'lorem ipsum dolor wahahaha', 'time' => 'septermber 17, 2021'),
        );
    @endphp

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

        {{-- <x-notification>
            <x-slot:header>Notifications</x-slot:header>
            <x-notification.item href="">
                <x-slot:description>X person assigned a new task</x-slot>
                <x-slot:time>1 hour ago</x-slot:time>
            </x-notification.item>
        </x-notification> --}}

        @include('include/employee/notification', $data)


        {{-- <x-sidebar>
            <x-sidebar.list icon="bi bi-bell-fill" class="notification-toggle">Notifications</x-sidebar.list>
            <x-sidebar.list href="{{ url('/employee/profile')}}" icon="bi bi-person-circle" >Profile</x-sidebar.list>
            <x-sidebar.list href="{{ url('/employee/tasks')}}" icon="bi bi-journal" >Tasks</x-sidebar.list>
        </x-sidebar> --}}

        @include('include/employee/sidebar')

        <main class="px-3"> 
            <h1>Profile</h1>
            <section class="profile-container">
                <div class="profile-img-container">
                    <img class="bi bi-person-circle" src="{{ url('/images/profile-placeholder.png')}}" alt="">
                </div>

                <article>
                    <h2>Name</h2>
                    <p>employee_name</p>
                </article>

                <article>
                    <h2>Department</h2>
                    <p>department_name</p>
                </article>

                <article>
                    <h2>Email</h2>
                    <p>email@email.com</p>
                </article>
            </section>
        </main> 
    </div>
    <script src="{{url('js/dialog.js')}}"></script>
    <script src="{{url('js/dropdown.js')}}"></script>
</body>
</html>