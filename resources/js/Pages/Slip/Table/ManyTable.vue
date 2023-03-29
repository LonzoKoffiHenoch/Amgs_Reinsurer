<template>
    <div>
        <h3 class="text-center font-bold">{{ heading }}</h3>
        <div :class="['grid gap-2',classGrid]">
            <template v-for="(tab,indexes) in datas" :key="indexes">
                <div>
                    <h4 class="text-center font-bold text-xs">{{ indexes }}</h4>
                    <table id="dataTable" class="relative w-full divide-gray-300 dark:bg-dark-eval-1 table">
                        <thead
                            class="sticky bg-white  top-0 z-20 border border-red-700  ">
                        <tr>
                            <th class="px-6 py-2 text-xs">N°</th>
                            <th class="px-6 py-2 text-xs">%</th>
                            <th class="px-6 py-2 text-xs">Capital</th>
                            <th class="px-6 py-2 text-xs">Prime</th>
                        </tr>
                        </thead>
                        <tbody class="w-full bg-white divide-y divide-gray-300 dark:bg-dark-eval-1"
                               style="width: 50vh;">
                        
                        <template
                            v-for="(cession,index) in maxCession"
                            :key="index">
                            
                            <tr class="text-center whitespace-nowrap text-[10px]  dark:text-white dark:bg-dark-eval-1">
                                
                                <td class="px-6 py-4">{{
                                        
                                        datas[indexes][index + 1] ? datas[indexes][index + 1][props.name] : ' - '
                                    }}
                                </td>
                                
                                <td class="px-6 py-4">{{
                                        datas[indexes][index + 1] ? formatAsPercentage(
                                            datas[indexes][index + 1].price / 100) : ' - '
                                    }}
                                </td>
                                <td class="px-6 py-4">
                                    {{
                                        datas[indexes][index + 1] ? formatAsMonney(
                                            datas[indexes][index + 1].capital) : ' - '
                                    }}
                                </td>
                                <td class="px-6 py-4">
                                    {{
                                        datas[indexes][index + 1] ? formatAsMonney(
                                            datas[indexes][index + 1].prime) : ' - '
                                    }}
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
            </template>
        </div>
    </div>
</template>

<script setup>
import {toRefs} from "vue";
import useFormat from "@/Services/useFormat";

const props = defineProps(['datas', 'maxCession', 'heading', 'classGrid', 'name'])
const {datas, maxCession, heading} = toRefs(props)
const {formatAsPercentage, formatAsMonney} = useFormat()
</script>

<style scoped>

</style>