<!DOCTYPE html>
<html lang="en">
<head>
    @include('include/head')
    <title>Admin Login | EPMS</title>
</head>
<body>
    <main class="flex flex-center vh-90">
        <section class="flex flex-column flex-center row-gap-2">
            <h1>Admin Login</h1>
            <div class="login-form">
                <form action="{{url('/admin/login/auth')}}" method="POST">
                    @csrf
                    <div>
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="John Doe" required>
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                    </div>

                    <button type="submit" class="button button-primary w-100 mt-1">Log in</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>