<template>
    <div class="master-grid">
        <header>
            <slot name="header"></slot>
        </header>
        
        <Sidebar>
            <slot name="sidebar"></slot>
        </Sidebar>

        <main>
            <div class="main-container">
                <slot name="main"></slot>
            </div>
        </main>
    </div>
</template>

<script setup>
    import Sidebar from '@/Components/Sidebar/Sidebar.vue';
</script>