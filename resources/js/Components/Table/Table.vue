<template>
    <table class="table">
        <TableHeader>
            <slot name="table-header"></slot>
        </TableHeader>

        <TableBody>
            <slot name="table-body"></slot>
        </TableBody>
    </table>
</template>

<script>

    import TableBody from './TableBody.vue';
    import TableHeader from './TableHeader.vue'
    export default {
        components: {
            TableBody, 
            TableHeader,
        }
    }
</script>