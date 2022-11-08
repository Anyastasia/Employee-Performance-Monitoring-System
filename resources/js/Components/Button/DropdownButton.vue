<template>
    <span class="dropdown-button" role="button" @click="$emit('toggle')">
        <slot></slot>
    </span>
</template>
