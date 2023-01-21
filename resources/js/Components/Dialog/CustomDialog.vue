<template>
    <dialog class="dialog" ref="dialog"> 
        <slot></slot>
    </dialog>
</template>

<script>

export default {
    props: ['show', 'exit'],
    watch: {
        show() {
            this.$refs.dialog.showModal()
        },
        exit() {
            this.$refs.dialog.close()
        }
    }
    
}
</script>