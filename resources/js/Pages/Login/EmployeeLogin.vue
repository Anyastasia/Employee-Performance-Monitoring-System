<template>
    <LoginLayout>
        <template #content>
                <section class="flex justify-content-center align-items-center g-1 flex-column">
                    <img class="display-block" src="../../../../public/images/seal-120.png">
                    <h1 class="h1 display-block">CITY GOVERNMENT OF MUNTINLUPA</h1>
                    <h3 class="h3 display-block">Business Permits and Licensing Office</h3>
                    <h3 class="h3 display-block">Employee Performance Monitoring System</h3>
                </section>
                <!-- <h1>Employee Login</h1> -->
            <div class="login-form">
                <form @submit.prevent="submitLogin">
                    <div>
                        <Error v-if="errors.email" :message="errors.email"></Error>
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

import LoginLayout from '@/Layouts/LoginLayout.vue'
import PrimaryButton from '@/Components/Button/PrimaryButton.vue';

import Error from '@/Components/Error.vue';
import {Inertia} from '@inertiajs/inertia';

export default {
    components: {
        LoginLayout,
        PrimaryButton,
        Error,
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