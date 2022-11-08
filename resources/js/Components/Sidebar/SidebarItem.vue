<template>
    <span class="sidebar-item" v-if="notLink">
        <div>
            <i :class="icon"></i>
            <li>
                <slot></slot>
            </li>
        </div>
    </span>

    <Link class="sidebar-item" v-else>
        <div>
            <i :class="icon"></i>
            <li>
                <slot></slot>
            </li>
        </div>
    </Link>
</template>


<script>

    import { Link } from '@inertiajs/inertia-vue3';
    export default {
        props: {
            icon: String,
            notLink: Boolean
        },
        components: {
            Link
        }
    }
</script>


