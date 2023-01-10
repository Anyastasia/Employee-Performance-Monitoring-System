<template>
    <Link class="button button-text" as="button">
        <div v-show="showBadge" class="button-badge"></div>
        <slot></slot>
    </Link>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';
    export default {
        components: {
            Link,
        },
        props: {
            showBadge: {
                required: false,
                default: false,
            }
        }
    }
</script>