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
            if (this.show === true)
                console.log('wew')
                
        },
        exit() {
            this.$refs.dialog.close()
        }
    }
    
}
</script>