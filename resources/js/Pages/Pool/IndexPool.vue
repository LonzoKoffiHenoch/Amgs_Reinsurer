<template>
    
    <div class="mt-4">
        <div class="flex flex-col">
            <div class="relative h-screen overflow-x-auto border-b border-gray-200 shadow ">
                <table id="dataTable" class="relative w-full divide-gray-300 dark:bg-dark-eval-1">
                    <thead class="sticky top-0 z-20 bg-primary">
                    <tr>
                        <th class="sticky left-0 px-6 py-2 text-xs text-white bg-primary ">Convention</th>
                        <th class="px-6 py-2 text-xs text-white whitespace-nowrap">Année</th>
                        <th class="px-6 py-2 text-xs text-white">Date d'effet</th>
                        <th class="px-6 py-2 text-xs text-white">Date d'écheance</th>
                    </tr>
                    </thead>
                    <tbody class="w-full bg-white divide-y divide-gray-300 dark:bg-dark-eval-1"
                           style="width: 50vh">
                    <template v-for="(pool,index) in pools">
                        <tr class="text-center whitespace-nowrap  dark:text-white text-xl lg:text-md ">
                            <td class="px-2 py-4">{{ pool.label }}</td>
                            <td class="px-2 py-4">{{ pool.year }}</td>
                            <td class="px-2 py-4">{{ pool.date_effet }}</td>
                            <td class="px-2 py-4">{{ pool.date_echeance }}</td>
                        </tr>
                    </template>
                    
                    </tbody>
                </table>
                
                <!-- Paginate -->
            </div>
            <!-- </div> -->
        </div>
    </div>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";

export default {layout: AuthenticatedLayout,};
</script>
<script setup>

import {toRefs} from "vue";

const props = defineProps({pools: Object})
const {pools} = toRefs(props)
console.log(pools.value.length)
</script>

<style scoped>

</style>