<!DOCTYPE html>
<html lang="en">
<head>
    @include('include/head')
    <title>Department Head Login | EPMS</title>
</head>
<body>
    <main class="flex flex-center vh-90">
        <section class="flex flex-column flex-center row-gap-2">
            <h1>Department Head Login</h1>
            <div class="login-form">
                <form action="">
                    <div>
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" placeholder="johndoe@email.com">
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password">
                    </div>

                    <button type="submit" class="button button-primary w-100 mt-1">Log in </button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>