<template>
    <LoginLayout>
        <template #content>
            <h1>Employee Login</h1>
            <div class="login-form">
                <form @submit.prevent="submitLogin">
                    <div>
                        <p v-if="errors.email">Email and Password do not match.</p>
                        <label for="email">Email</label>
                        <input v-model="loginForm.email" type="text" name="email" id="email" placeholder="johndoe@email.com" required>
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input v-model="loginForm.password" type="password" name="password" id="password" required>
                    </div>

                    <PrimaryButton type="submit" class="w-100 mt-1">Log in</PrimaryButton>
                </form>
            </div>
        </template>
    </LoginLayout>

</template>

<script>

import LoginLayout from '../../Layouts/LoginLayout.vue'
import PrimaryButton from '../../Components/Button/PrimaryButton.vue';
import {Inertia} from '@inertiajs/inertia';

export default {
    components: {
        LoginLayout,
        PrimaryButton,
    },

    props: ['errors'],
    data() {
        return {
            loginForm: {
                email: '',
                password: ''
            }
        }
    },
    methods: {
        submitLogin() {
            Inertia.post('/login/employee/auth', this.loginForm)
        }
    }
}
</script>