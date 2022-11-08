<template>
    <Link>
        <li>
            <h2>{{title}}</h2>
            <h5>{{dueDate}}</h5>
        </li>
    </Link>
</template>

<script>

    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        props: ['title', 'dueDate'],
        components: {
            Link,
        }
    }
</script>