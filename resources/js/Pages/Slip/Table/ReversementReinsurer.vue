<template>
    <div class="">
        <h3 class="text-center font-bold mb-2">{{ heading }}</h3>
        <table id="dataTable" class="relative w-full divide-gray-300 dark:bg-dark-eval-1 table">
            <thead class="sticky top-0 z-20 border border-red-700  ">
            <tr>
                <th class="px-6 py-2 text-xs">N°</th>
                <th class="px-6 py-2 text-xs">Raison_social</th>
                
                <th class="px-6 py-2 text-xs">Prime</th>
            </tr>
            </thead>
            <tbody class="w-full bg-white divide-y divide-gray-300 dark:bg-dark-eval-1"
                   style="width: 50vh;">
            <template v-for="(reas,index,key) in datas">
                
                <tr class="text-center whitespace-nowrap text-[10px]  dark:text-white dark:bg-dark-eval-1">
                    <td class="px-6 py-4">{{ key + 1 }}</td>
                    <td class="px-6 py-4">{{ index }}</td>
                    
                    <td class="px-6 py-4">{{ formatAsMonney(reas.prime) }}</td>
                
                </tr>
            
            
            </template>
            
            
            </tbody>
        </table>
    </div>
</template>

<script setup>
import {toRefs} from "vue";
import useFormat from "@/Services/useFormat";

const props = defineProps(['datas', 'heading', 'total'])
const {datas, total} = toRefs(props)
const {formatAsPercentage, formatAsMonney} = useFormat()
</script>

<style scoped>

</style>