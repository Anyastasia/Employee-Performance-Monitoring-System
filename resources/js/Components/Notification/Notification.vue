<template>
    <CustomDialog class="notification" :show="show">
        <h1>Notifications</h1>

        <ul class="notification-container">
            <slot></slot>
        </ul>
    </CustomDialog>
</template>

<script>
    import CustomDialog from '../Dialog/CustomDialog.vue';

    export default {
        components: {
            CustomDialog
        },
        data() {
            return {
                show: true
            }
        }
    }
</script>