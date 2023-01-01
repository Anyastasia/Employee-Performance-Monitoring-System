<template>
    <div class="custom-select">
        <OutlineButton @click="xtoggle">
            {{defaultSelectMessage}}
            <i class="bi bi-caret-down"></i>
        </OutlineButton>

        <ul class="options" v-show="show">
            <slot name="options"></slot>
        </ul>
    </div>

</template>

<script>
import OutlineButton from '@/Components/Button/OutlineButton.vue';
import CustomSelectOption from './CustomSelectOption.vue';

export default {
    emits: ['toggle'],
    props: ['default_message', 'selected', 'list'],
    components: {
        OutlineButton,
        CustomSelectOption,
    },
    data() {
        return {
            show: false,
            defaultSelectMessage: this.default_message,
        }
    },
    methods: {
        xtoggle() {
            this.show = !this.show
            this.defaultSelectMessage = this.selected
        },  
    },
    watch: {
        selected() {
            this.defaultSelectMessage = this.selected
            this.show = !this.show
        }
    }
}
</script>
