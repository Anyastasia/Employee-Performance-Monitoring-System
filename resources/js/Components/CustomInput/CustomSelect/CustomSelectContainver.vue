<template>
    <div class="custom-select">
        <OutlineButton @toggle="show = !show">
            {{selected}}
        </OutlineButton>
    </div>

    <ul class="options" v-show="show">
        <slot name="options"></slot>
    </ul>
</template>

<script>
import OutlineButton from '@/Components/Button/OutlineButton.vue';
export default {
    emits: ['toggle'],
    props: ['default-message', 'selected'],
    components: {
        OutlineButton,
    },
    data() {
        return {
            show: false,
        }
    },
}
</script>
