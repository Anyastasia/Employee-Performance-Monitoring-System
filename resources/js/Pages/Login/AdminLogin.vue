<template>
    <LoginLayout>
        <template #content>
            <h1>Admin Login</h1>
            <div class="login-form">
                <form @submit.prevent="submitLogin">
                    <div>
                        <p v-if="errors.username">{{errors.username}}</p>
                        <label for="text">Username</label>
                        <input v-model="loginForm.username" type="text" name="username" id="username">
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input v-model="loginForm.password" type="password" name="password" id="password">
                    </div>

                    <PrimaryButton type="submit" class="w-100 mt-1">Log in</PrimaryButton>
                </form>
            </div>
        </template>
    </LoginLayout>

</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import LoginLayout from '../../Layouts/LoginLayout.vue'
import PrimaryButton from '@/Components/Button/PrimaryButton.vue';
export default {
    components: {
        LoginLayout,
        PrimaryButton,
    },
    props: ['errors'],
    data(){
        return {
            loginForm: {
                username: '',
                password: '',
            }
        }
    },
    methods: {
        submitLogin() {
            Inertia.post('/login/admin/auth', this.loginForm)
        }
    },
}
</script>