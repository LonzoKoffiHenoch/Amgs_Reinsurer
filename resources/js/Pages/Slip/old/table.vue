<template>
    <div>
        <h3 class="text-center font-bold mb-2">CESSION POOL WPVT</h3>
        <table id="dataTable" class="relative w-full divide-gray-300 dark:bg-dark-eval-1 table">
            <thead class="sticky top-0 z-20 border border-red-700  ">
            <tr>
                <th class="px-6 py-2 text-xs">N°</th>
                <th class="px-6 py-2 text-xs">%</th>
                <th class="px-6 py-2 text-xs">Capital</th>
                <th class="px-6 py-2 text-xs">Prime</th>
            </tr>
            </thead>
            <tbody class="w-full bg-white divide-y divide-gray-300 dark:bg-dark-eval-1"
                   style="width: 50vh;">
            
            <template v-for="(business,index) in props.datas['cession_pool']" :key="index">
                <tr class="text-center whitespace-nowrap text-[10px]  dark:text-white dark:bg-dark-eval-1">
                    <td class="px-6 py-4">{{ index }}</td>
                    <td class="px-6 py-4">
                        {{
                            formatAsPercentage(business[0].price / 100)
                        }}
                    </td>
                    <td class="px-6 py-4">
                        {{
                            formatAsMonney(business[0].capital, business.monnaie)
                        }}
                    </td>
                    <td class="px-6 py-4">
                        {{
                            formatAsMonney(business[0].prime, business.monnaie)
                        }}
                    </td>
                </tr>
            </template>
            
            </tbody>
        </table>
    </div>
    
    
    <div>
        <h3 class="text-center font-bold mb-2">Conservation CEDANTE</h3>
        <table id="dataTable" class="relative w-full  divide-gray-300 dark:bg-dark-eval-1 table">
            <thead class="sticky top-0 z-20 border border-red-700  ">
            <tr>
                <th class="px-6 py-2 text-xs">N°</th>
                <th class="px-6 py-2 text-xs">%</th>
                <th class="px-6 py-2 text-xs">Capital</th>
                <th class="px-6 py-2 text-xs">Prime</th>
            </tr>
            </thead>
            <tbody class="w-full bg-white divide-y divide-gray-300 dark:bg-dark-eval-1"
                   style="width: 50vh;">
            
            <template v-for="(business,index) in props.datas['Conservation_cedante']" :key="index">
                <tr class="text-center whitespace-nowrap text-[10px]  dark:text-white dark:bg-dark-eval-1">
                    <td class="px-6 py-4">{{ index }}</td>
                    <td class="px-6 py-4">{{ formatAsPercentage(business[0].price / 100) }}</td>
                    <td class="px-6 py-4">
                        {{
                            formatAsMonney(business[0].capital, business.monnaie)
                        }}
                    </td>
                    <td class="px-6 py-4">
                        {{
                            formatAsMonney(business[0].prime, business.monnaie)
                        }}
                    </td>
                </tr>
            </template>
            
            </tbody>
        </table>
    </div>

</template>

<script setup>

import {onMounted} from "vue";

onMounted(() => {
    /* for (let i = 0; i < Object.keys(datas.value['Cession Légale au 1er Franc']).length; i++) {
         let key = Object.keys(datas.value['Cession Légale au 1er Franc'])[i]
         
         if (Object.keys(datas.value['Cession Légale au 1er Franc'][key]).length > maxCession.value) {
             maxCession.value += Object.keys(datas.value['Cession Légale au 1er Franc'][key]).length
         }
         
         console.log(maxCession.value)
     }*/
})
</script>

<style scoped>

</style>