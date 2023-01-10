<template>
    <div class="progress-bar-container" :style="{backgroundColor: colors[0], color: colors[2], borderRadius: borderRadius, height: height}">
        <div class="progession-bar" :style="{backgroundColor: colors[1], width: progress}">
            {{content}}
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'content',
            'colors',
            'height',
            'progress',
            'borderRadius'
        ]
    }
</script>


<style>
</style>
