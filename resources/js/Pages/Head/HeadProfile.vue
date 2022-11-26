<template>
    <HeadLayout>
        <template #content>
            <main class="px-3"> 
                <h1 class="my-2">Profile</h1>
                <section class="profile-container">
                    <div class="profile-img-container">
                        <img src="../../../../public/images/profile-placeholder.png" alt=""/>
                        <article class="display-inline-block">
                            <h2 class="h2">{{`${head.first_name} ${head.last_name}`}}</h2>
                            <p>{{`${head.position} | ${head.email}`}}</p>
                        </article>
                    </div>
                </section>

                <section class="flex flex-row g--75">
                    <TextButton @click="toggleChangeProfilePicture">Change profile picture</TextButton>
                    <TextButton @click="toggleChangePassword">Change password</TextButton>
                </section>

                <Dialog :show="showChangeProfilePicture" :exit="exitChangeProfilePicture">
                    <section>
                        <h2 class="h2">Change Profile Picture</h2>
                    </section>
                    <section>
                        <form @submit.prevent="submitProfilePicture">

                            <div>
                                <label for="profile-picture">Select image</label>
                                <input @change="changeProfilePictureForm.path" type="file" name="profile-picture">
                            </div>


                            <div class="flex flex-row g--75 mt-1">
                                <TextButton type="button" @click="closeChangeProfilePicture">Exit</TextButton>
                                <PrimaryButton type="submit">Save Changes</PrimaryButton>
                            </div>

                        </form>
                    </section>
                </Dialog>

                <Dialog :show="showChangePassword" :exit="exitChangePassword">
                    <section>
                        <h2 class="h2">Change password</h2>
                    </section>

                    <section>
                        <form @submit.prevent="submitChangePassword">
                            <div class="flex flex-column g-1 mt-1">
                                <div>
                                    <Error v-if="errors.current_password" :message="errors.current_password"></Error>
                                    <label class="display-block mb--5 required" for="current-password">Enter current password</label>
                                    <input class="py--5" v-model="changePasswordForm.current_password" type="password" name="current-password" required>
                                </div>

                                <div>
                                    <Error v-if="errors.password" :message="errors.password"></Error>
                                    <label class="display-block mb--5 required" for="new-password">Enter new password</label>
                                    <input class="py--5" v-model="changePasswordForm.password" type="password" name="password" required>
                                </div>

                                <div>
                                    <Error v-if="errors.password_confirmation" :message="errors.password_confirmation"></Error>
                                    <label class="display-block mb--5 required" for="confirm-new-password">Confirm new password</label>
                                    <input class="py--5" v-model="changePasswordForm.password_confirmation" type="password" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="flex flex-row g--75 mt-1">
                                <TextButton type="button" @click="closeChangePassword">Exit</TextButton>
                                <PrimaryButton type="submit">Save Changes</PrimaryButton>
                            </div>
                        </form>
                    </section>
                </Dialog>
            </main> 
        </template>
    </HeadLayout>
</template>

<script>
import HeadLayout from '@/Layouts/HeadLayout.vue';
import Dialog from '@/Components/Dialog/CustomDialog.vue';
import PrimaryButton from '@/Components/Button/PrimaryButton.vue';
import TextButton from '@/Components/Button/TextButton.vue';
import Error from '@/Components/Error.vue'
import { Inertia } from '@inertiajs/inertia';
import { useForm} from '@inertiajs/inertia-vue3';

export default {
    components: {
        HeadLayout,
        Dialog,
        PrimaryButton,
        TextButton,
        Error,
    },

    props: ['head', 'errors'],

    data() {
        return {
            showChangeProfilePicture: false,
            showChangePassword: false,
            exitChangeProfilePicture: false,
            exitChangePassword: false,

            changeProfilePictureForm: useForm({
                path: '',
            }),
            
            changePasswordForm: useForm({
                current_password: '',
                password: '',
                password_confirmation: '',
            }),
        }
    },
    methods: {
        toggleChangeProfilePicture() {
            this.showChangeProfilePicture = !this.showChangeProfilePicture
        },
        
        closeChangeProfilePicture() {
            this.exitChangeProfilePicture = !this.exitChangeProfilePicture
        },

        submitProfilePicture() {
            Inertia.post('/head/profile/changeAvatar', this.changeProfilePictureForm)
        },

        toggleChangePassword() {
            this.showChangePassword = !this.showChangePassword
        },

        closeChangePassword() {
            this.changePasswordForm.reset()
            this.changePasswordForm.clearErrors()
            this.exitChangePassword = !this.exitChangePassword
        },

        submitChangePassword(){
            Inertia.post('/head/profile/changePassword', this.changePasswordForm)
        }
    },

}
</script>