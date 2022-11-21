<template>
    <Link>
        <li>
            <h2>{{title}}</h2>
            <h5>{{dueDate +' ' + timeDue}}</h5>
        </li>
    </Link>
</template>

<script>

    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        props: ['title', 'dueDate', 'timeDue'],
        components: {
            Link,
        }
    }
</script>