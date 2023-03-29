<script setup>
import Modal from "./Modal.vue";

const emit = defineEmits(["close"]);

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "2xl",
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    maxHeight: {
        type: String,
        default: "auto",
    },
});

const close = () => {
    emit("close");
};
</script>

<template>
    <Modal :closeable="closeable" :max-height="maxHeight" :max-width="maxWidth" :show="show" @close="close">
        <div class="px-6 py-4">
            <div class="mt-4">
                <slot name="content"/>
            </div>
        </div>
    </Modal>
</template>
