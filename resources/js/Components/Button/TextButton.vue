<template>
    <BaseButton class="button-text">
        <slot></slot>
    </BaseButton>
</template>

<script>
    import BaseButton from '@/Components/Button/BaseButton.vue';

    export default {
        components: {
            BaseButton
        }
    }
</script>