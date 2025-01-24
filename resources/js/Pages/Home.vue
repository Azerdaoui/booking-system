<script setup>
    defineProps({
        employees: Array,
        services: Array,
    });
</script>

<template>
    <div>
        {{ employees }}
        {{ services }}
    </div>
</template>

<style scoped>

</style>
