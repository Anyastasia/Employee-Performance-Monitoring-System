<template>
    <div class="dropdown">
        <DropdownButton @toggle="show = !show">
            <slot name="dropdown-button"></slot> 
        </DropdownButton>

        <ul class="dropdown-content" v-show="show">
            <slot name="dropdown-content"></slot>
        </ul>
    </div>
</template>


<script>
    import DropdownButton from '../Button/DropdownButton.vue';
    export default {
        emits: ['toggle'],
        components: {
            DropdownButton
        },
        data(){
            return {
                show: false
            }
        },
        methods: {
        }
    }
</script>