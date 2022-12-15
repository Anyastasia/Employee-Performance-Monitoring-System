<template>
    <div class="alert" :class="[type]" ref="alert" >
        <p>{{message}}</p>
    </div>
</template>

<script>

export default {
    props: ['type', 'message'],
    data() {
        return {
        }
    }

}
</script>