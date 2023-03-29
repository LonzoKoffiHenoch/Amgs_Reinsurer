<template>
    <input type="checkbox" :value="value" v-model="proxyChecked" class="
            text-primary
            border-gray-300
            rounded
            focus:border-primary focus:ring focus:ring-primary
            dark:border-gray-600
            dark:bg-dark-eval-1
            dark:focus:ring-offset-dark-eval-1
        " />
</template>

<script setup>
import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit("update:checked", val);
    },
});
</script>
