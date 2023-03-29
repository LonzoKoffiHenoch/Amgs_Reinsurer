<template>
    <label class="block text-xs font-medium text-gray-400 dark:text-gray-300 -mb-1">
        <span v-if="value">{{ value }}</span>
        <span v-else>
            <slot />
        </span>
    </label>
</template>

<script setup>
defineProps({
    value: String,
});
</script>
