<!DOCTYPE html>
<html lang="en">
<head>
    @include('include/head')
    <title>{{$title}}</title>
</head>
<body>
    <header></header>
    <main>
        <section class="width-90 margin-auto">
            <h1 class="mx-3 my-5">Employee Performance Monitoring System</h1>
            <div class="login-portal-container flex flex-column flex-center my-5">
                <a href="{{ url('/admin/login')}}">Admin Login</a>
                <a href="{{ url('/head/login')}}">Department Head Login</a>
                <a href="{{ url('/employee/login')}}">Employee Login</a>
            </div>
        </section>
    </main>
</body>
<footer>
    @include('include/footer')
</footer>
</html>