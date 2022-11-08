<template>
    <button>
        <slot />
    </button>
</template>


<style scoped>
    button {
        border-radius: var(--corner-radius);
        border: 0;
        background-color: var(--primary);
        color: #FFF;
        padding-inline: .75em;
        padding-block: .5em;
    }
</style>

<script setup>
</script>




