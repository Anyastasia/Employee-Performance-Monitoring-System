<template>
    <Link>
        <li>
            <h2>{{title}}</h2>
            <h5>{{formatDate(dueDate)}}</h5>
            <p v-if="isApproved" class="success h5">Task Approved</p>
            <Error v-if="isRejected" class="h5" message="Needs Revision"></Error>
            <Error v-if="isPriority" class="h5" message="Task due"></Error>
        </li>
    </Link>
</template>

<script>

    import { Link } from '@inertiajs/inertia-vue3';
    import Error from '@/Components/Error.vue'
    export default {
        props: ['title', 'dueDate', 'timeDue', 'isPriority', 'isApproved', 'isRejected'],
        components: {
            Link,
            Error,
        },

        methods: {
            formatDate(date) {
                const xdate = new Date(date)
                return `${xdate.toDateString()} ${xdate.toLocaleTimeString()}`
            },
        }
    }
</script>