<template>
    <div>
        <h3 class="text-center font-bold mb-2">CESSION Facultative</h3>
        <table id="dataTable"
               class="relative w-full divide-gray-300 dark:bg-dark-eval-1 table border border-red-700 rounded-xl">
            <thead class="sticky top-0 z-20 border border-red-700 text-secondary">
            <tr>
                <th class="px-6 py-2 text-xs ">N°</th>
                <th class="px-6 py-2 text-xs ">%</th>
                <th class="px-6 py-2 text-xs ">Capital</th>
                <th class="px-6 py-2 text-xs">Prime</th>
            </tr>
            </thead>
            <tbody class="w-full bg-white divide-y divide-gray-300 dark:bg-dark-eval-1"
                   style="width: 50vh;">
            
            <template v-for="(business,index) in props.borderau.business" :key="index">
                <tr class="text-center whitespace-nowrap text-[10px]  dark:text-white dark:bg-dark-eval-1">
                    <td class="px-6 py-4">{{ index + 1 }}</td>
                    <td class="px-6 py-4">{{ formatAsPercentage(0) }}</td>
                    <td class="px-6 py-4">{{ 0 }}</td>
                    <td class="px-6 py-4">{{ 0 }}</td>
                </tr>
            </template>
            
            </tbody>
        </table>
    </div>
    
    
    <div>
        <h3 class="text-center font-bold mb-2">Reversement aux réassureurs</h3>
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
            
            <template v-for="(business,index) in props.borderau.business" :key="index">
                <tr class="text-center whitespace-nowrap text-[10px]  dark:text-white dark:bg-dark-eval-1">
                    <td class="px-6 py-4">{{ index + 1 }}</td>
                    <td class="px-6 py-4">{{
                            formatAsPercentage(
                                (
                                    1 - (
                                        (
                                            (
                                                1 -
                                                (
                                                    0.0225 +
                                                    (0.1 * (1 - 0.0225 - parseFloat(business.commission_cedante) / 100)) +
                                                    parseFloat(business.commission_cedante) / 100
                                                )
                                            )
                                        ) +
                                        (0.1 * ((1 - 0.0225 - parseFloat(business.commission_cedante) / 100)))
                                    )
                                )
                            )
                        }}
                    </td>
                    <td class="px-6 py-4">
                        {{ formatAsMonney(((business.capitaux * 2.25) / 100), business.monnaie) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ formatAsMonney(((business.capitaux * 2.25) / 100), business.monnaie) }}
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "old"
}
</script>

<style scoped>

</style>