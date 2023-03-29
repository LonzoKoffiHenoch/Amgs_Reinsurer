<template>
    <div class="dark:bg-dark-eval-1">
        <!-- {{ props }} -->
        <nav class="inline-flex -space-x-px rounded-md shadow-sm isolate dark:bg-dark-eval-1" aria-label="Pagination">
            <Link :href="props.prev"
                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 focus:z-20 hover:dark:bg-secondary dark:bg-primary">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                    clip-rule="evenodd" />
            </svg>
            </Link>
            <ul class="dark:bg-dark-eval-1">
                <Link
                    class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-medium text-black bg-white border border-gray-300 active focus:z-20 hover:bg-primary hover:text-white hover:dark:bg-secondary dark:bg-primary"
                    :class="{ 'bg-primary text-[#FFF] dark:bg-gray-700 ': lien.active }" v-for="lien in computedLinks"
                    :key="lien.id" :href="lien.url">
                {{ lien.label }}
                </Link>
            </ul>
            <Link :href="props.next"
                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 focus:z-20 hover:dark:bg-secondary dark:bg-primary">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                    clip-rule="evenodd" />
            </svg>
            </Link>
        </nav>
    </div>
</template>
<script setup>
import { computed } from 'vue'
const props = defineProps({
    links: {
        type: Object
    },
    prev: {
        type: String,
        default: ""
    },
    next: {
        type: String,
        default: ""
    }
})

const computedLinks = computed(() => {
    props.links.shift()
    props.links.pop()

    return props.links

})
</script>