<template>
    <BaseButton class="button-primary">
        <slot>
        </slot>
    </BaseButton>
</template>

<script>
    import BaseButton from './BaseButton.vue';

    export default {
        components: {
            BaseButton,
        }
    }
</script>




