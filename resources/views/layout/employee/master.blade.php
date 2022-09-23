@php
$data = array(
    array('description' => 'lorem ipsum dolor wahahaha', 'time' => 'septermber 17, 2021'),
    array('description' => 'lorem ipsum dolor wahahaha', 'time' => 'septermber 17, 2021'),
    array('description' => 'lorem ipsum dolor wahahaha', 'time' => 'septermber 17, 2021'),
    array('description' => 'lorem ipsum dolor wahahaha', 'time' => 'septermber 17, 2021'),
);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    @include('include/head')
    <title>@yield('title')</title>
</head>
<body>
    <div class="master-grid">

        @section('primary-navigation')
        <header>
            @include('include.employee.primary-navigation')
        </header>
        @show
        
        @include('include/employee/notification', $data)

        @section('sidebar')
            @include('include.employee.sidebar')
        @show

        @yield('main')
    </div>

    {{-- <script src="{{ url('js/admin.js')}}"></script> --}}
    <script src="{{url('js/dialog.js')}}"></script>
    <script src="{{url('js/dropdown.js')}}"></script>
</body>
</html>