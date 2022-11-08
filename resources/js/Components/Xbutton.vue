<template>
    <button @click="increment" :class="{red: count > 5}">{{count}}</button>
</template>

<style scoped>

button {
    border: 0;
    border-radius: 15px;
    background-color: #333;
    color: white;
    padding: 1em;
}

.red {
    background-color: red;
}

</style>

<script>

export default {
    data() {
        return {
            count: 0
        }
    },

    methods: {
        increment() {
            this.count++
            console.log(this.count)
        }
    },
    computed: {
        
    }
}
</script>