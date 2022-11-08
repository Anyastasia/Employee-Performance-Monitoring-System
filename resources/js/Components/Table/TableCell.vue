<template>
    <th v-if="isHeader === true">
        <slot></slot>
    </th>

    <td v-else>
        <slot></slot>
    </td>
</template>

<script>
    export default {
        props: ['isHeader']
    }
</script>