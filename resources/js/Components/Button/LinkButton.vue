<template>
    <Link class="button button-text" as="button">
        <slot></slot>
    </Link>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';
    export default {
        components: {
            Link,
        }
    }
</script>