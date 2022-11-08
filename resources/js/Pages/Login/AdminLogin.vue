<template>
    <LoginLayout>
        <template #content>
            <h1>Admin Login</h1>
            <div class="login-form">
                <form action="">
                    <div>
                        <label for="text">Username</label>
                        <input type="text" name="username" id="username">
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password">
                    </div>

                    <button type="submit" class="button button-primary w-100 mt-1">Log in </button>
                </form>
            </div>
        </template>
    </LoginLayout>

</template>

<script>
import LoginLayout from '../../Layouts/LoginLayout.vue'

export default {
    components: {
        LoginLayout,
    }
}
</script>