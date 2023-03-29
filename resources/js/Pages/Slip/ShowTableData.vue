<template>
    <Authenticated>
        <div class="absolute top-1/2 left-1/2 z-50">
            <spinner v-if="loader" class=""></spinner>
        </div>
        
        <div
            class="border-2 my-8 rounded-t-xl pb-3 border-gray-300 shadow-xl bg-white dark:bg-dark-eval-1 dark:border-dark-eval-1">
            <h2 class="text-3xl text-center bg-primary p-2 font-bold text-white rounded-t-xl mb-2">{{
                    props.borderau.label
                }}</h2>
            <div class="p-4">
                
                <table id="dataTable" class="relative w-full  divide-gray-300 dark:bg-dark-eval-1 table">
                    <thead class="sticky top-0 z-20 border bg-secondary text-white ">
                    <tr>
                        <th class="px-6 py-2 text-xs">N°</th>
                        <th class="px-6 py-2 text-xs">Assurés</th>
                        <th class="px-6 py-2 text-xs">Pays</th>
                        <th class="px-6 py-2 text-xs">Cédantes</th>
                        <th class="px-6 py-2 text-xs">Risques</th>
                        <th class="px-6 py-2 text-xs">Activité</th>
                        <th class="px-6 py-2 text-xs">Capital 100%</th>
                        <th class="px-6 py-2 text-xs">Prime 100%</th>
                        <th class="px-6 py-2 text-xs">Conservation Cédante</th>
                    </tr>
                    </thead>
                    <tbody class="w-full bg-white divide-y divide-gray-300 dark:bg-dark-eval-1"
                           style="width: 50vh;">
                    <template v-for="(business,index) in props.borderau.business" :key="index">
                        
                        <tr class="text-center whitespace-nowrap text-[10px]  dark:text-white dark:bg-dark-eval-1 text-black font-bold">
                            <td class="px-6 py-4">{{ index + 1 }}</td>
                            <td class="px-6 py-4">
                                {{ business.nom_assure }}
                            </td>
                            <td class="px-6 py-4">
                                {{ business.pays_assure }}
                            </td>
                            <td class="px-6 py-4">
                                {{ business.transferor.raison_social }}
                            </td>
                            <td class="px-6 py-4 text-md uppercase">
                                {{ business.activity_rate.type }}
                            </td>
                            <td class="px-6 py-4 text-md uppercase">
                                {{ business.activity_rate.activity }}
                            </td>
                            <td class="px-6 py-4">
                                {{ formatAsMonney(business.capitaux, business.monnaie) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ formatAsMonney(business.prime) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ formatAsPercentage(business.commission_cedante / 100) }}
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
            
            <div class="grid grid-cols-2 gap-4 p-4">
                
                <!-- Cession au 1er Franc-->
                <many-table :class-grid="classGrid" :datas="datas['Cession Légale au 1er Franc']"
                            :heading="'Cessions légales au 1er Franc'" :max-cession="maxCession" :name="'affaire'"/>
                
                <!-- Cession Facs-->
                <many-table :class-grid="classGrid" :datas="datas['Cession Légale Facs']"
                            :heading="'Cessions légales Facs'" :max-cession="maxCession" :name="'name'"/>
                
                
                <!-- Conservation Cédante-->
                <normal-table v-if="datas['Conservation_cedante']!==[]"
                              :datas="datas['Conservation_cedante']" :heading="'Conservation CEDANTE'"
                />
                
                <!-- Cession Pool PVT-->
                <normal-table v-if="datas['cession_facultative']!==[]"
                              :datas="datas['cession_pool']" :heading="'CESSION POOL WPVT'"
                />
                
                <!-- fact-->
                <normal-table v-if="datas['cession_facultative']!==[]"
                              :datas="datas['cession_facultative']" :heading="'Cession Facultative'"
                />
                
                <!-- Reversement Réassureurs-->
                <normal-table
                    :datas="datas['reversement_reinsurer']" :heading="'Reversement aux réassureurs'"
                />
            
            </div>
            <reversement-reinsurer :datas="datas['reassureurs']" :heading="'Reversement aux réassureurs'"
                                   :total="datas['total_prime']" class="p-4"
            />
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from "@/Layouts/Authenticated.vue";
import useFormat from "@/Services/useFormat";
import {onMounted, ref, toRefs} from "vue";
import Spinner from "@/Shared/Spinner.vue";
import NormalTable from "@/Pages/Slip/Table/NormalTable.vue";
import ManyTable from "@/Pages/Slip/Table/ManyTable.vue";
import ReversementReinsurer from "@/Pages/Slip/Table/ReversementReinsurer.vue";

const props = defineProps(['borderau', 'datas'])
const {datas, borderau} = toRefs(props)
const maxCession = ref(0);

const classGrid = ref('');
const {formatAsPercentage, formatAsMonney} = useFormat()
onMounted(() => {
    //au demmarage on check si la cession contien au moins deux elements si oui on ajoute grid-cols-2
    if (Object.keys(datas.value['Cession Légale au 1er Franc']).length > 1) classGrid.value = 'grid-cols-2';
    
    //On comptablise le nombre d'affaire
    maxCession.value = borderau.value.business.length
    
    console.log(datas)
})
</script>
