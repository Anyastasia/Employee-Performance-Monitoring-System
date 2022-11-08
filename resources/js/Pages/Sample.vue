<template>
    <Head>
        <title>Wew</title>
    </Head>

    <EmployeeLayout>

        <template #content>
            hello world!
        </template>
    </EmployeeLayout>

</template>

<style>

</style>



<script>
import { Head } from '@inertiajs/inertia-vue3';
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
export default {

    components: {
        EmployeeLayout,
        Head,
    },

}
</script>