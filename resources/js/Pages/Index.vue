<template>
<main>
    <section class="margin-auto">
        <h1 class="mx-3 my-5">Employee Performance Monitoring System</h1>
        <div class="login-portal-container flex flex-column flex-center my-5">
            <Link href="/login/admin">Admin Login</Link>
            <Link href="/login/head">Division Head Login</Link>
            <Link href="/login/employee">Employee Login</Link>
        </div>
    </section>
</main>
</template>


<script>
import {Link} from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link,
    }
}
</script>
