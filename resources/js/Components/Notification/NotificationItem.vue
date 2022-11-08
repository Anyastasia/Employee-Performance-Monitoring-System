<template>
    <a>
        <li>
            <p>{{description}}</p>
            <h5>{{time}}</h5>
        </li>
    </a>
</template>


<script>

    export default {
        props: ['description', 'time']
    }
</script>