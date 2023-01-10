<template>
    <button class="button">
        <div v-show="showBadge" class="button-badge"></div>
        <slot></slot>
    </button>
</template>

<script>

export default {
    props: {
        showBadge: {
            required: false,
            default: false,
        }
    }

}
</script>