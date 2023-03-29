<template>
    <template v-for="(affaire, indexes) in affaires" :key="indexes">
        <tr class="text-center whitespace-nowrap text-[10px] dark:text-white ">
            <!-- Bouton showreas -->
            <td class="sticky left-0 z-10"></td>
            <!-- Nom assure -->
            <td class="sticky left-0 z-10 flex items-center gap-2 px-6 py-8 text-start">
                <div class="">
                    <button v-if="
                                                showreas[indexes] == false &&
                                                affaire.reinsurers.length >= 1
                                            " class="text-xl transition-all ease-out delay-300"
                            @click.prevent="toggleAccordion(indexes)">
                        +
                    </button>
                    <button v-if="showreas[indexes] == true"
                            class="text-xl transition-all ease-out delay-300"
                            @click.prevent="toggleAccordion(indexes)">
                        -
                    </button>
                </div>
                <div class="mt-1 text-xs font-bold text-center text-gray-900 dark:text-white">
                    {{ affaire.nom_assure }}
                </div>
                <warningIcons v-if="
                                            ((parseFloat(affaire.prime) *
                                                parseFloat(affaire.part_offerte)) /
                                                100) *
                                            (1 - parseFloat(affaire.commission_cedante / 100)) -
                                            parseFloat(
                                                affaire.reinsurers_sum_businesse_reinsurerprime_a_reverser
                                            ) <
                                            0
                                        " class="w-4 h-4 animate-ping"/>
            </td>
            <!-- Date de reception -->
            <td class="px-6 py-4">
                <div class="">
                    {{ new Date(affaire.date_reception).toLocaleDateString("fr-FR") }}
                </div>
            </td>
            <!-- Cédante -->
            <td class="px-6 py-4">
                <div class="">{{ affaire.transferor.raison_social }}</div>
            </td>
            <!-- Date d'effet -->
            <td class="px-6 py-4">
                <div class="">
                    {{
                        new Date(affaire.date_effet).toLocaleDateString("fr-FR")
                    }}
                </div>
            </td>
            <!-- Date d'echeance -->
            <td class="px-6 py-4">
                <div class="">
                    {{
                        new Date(affaire.date_echeance).toLocaleDateString(
                            "fr-FR"
                        )
                    }}
                </div>
            </td>
            <!-- Monnaie -->
            <td class="px-6 py-4">
                <div class="">
                    {{ affaire.monnaie }}
                </div>
            </td>
            <!-- Prime à 100% -->
            <td class="px-6 py-4">
                <div class="">
                    {{
                        new Intl.NumberFormat("fr-FR", {
                            currency: affaire.monnaie,
                            style: "currency",
                        }).format(affaire.prime)
                    }}
                </div>
            </td>
            <!-- Part offerte	 -->
            <td class="px-6 py-4">
                <div class="">
                    {{
                        new Intl.NumberFormat("fr-FR", {
                            style: "percent",
                            minimumFractionDigits: 2,
                        }).format(affaire.part_offerte / 100)
                    }}
                </div>
            </td>
            <!-- Prime de reassurance -->
            <td class="px-6 py-4">
                <div class="">
                    {{
                        new Intl.NumberFormat("fr-FR", {
                            currency: affaire.monnaie,
                            style: "currency",
                        }).format(
                            (parseFloat(affaire.prime) *
                                parseFloat(affaire.part_offerte)) /
                            100
                        )
                    }}
                </div>
            </td>
            <!-- Commission cedante -->
            <td class="px-6 py-4">
                <div class="">
                    {{
                        new Intl.NumberFormat("fr-FR", {
                            style: "percent",
                            minimumFractionDigits: 2,
                        }).format(affaire.commission_cedante / 100)
                    }}
                </div>
            </td>
            <!-- prime cedée -->
            <td class="px-6 py-4">
                <div class="">
                    {{
                        new Intl.NumberFormat("fr-FR", {
                            currency: affaire.monnaie,
                            style: "currency",
                        }).format(
                            ((parseFloat(affaire.prime) *
                                    parseFloat(affaire.part_offerte)) /
                                100) *
                            (1 - parseFloat(affaire.commission_cedante / 100))
                        )
                    }}
                </div>
            </td>
            
            <!-- Prime à recevoir -->
            <td class="px-6 py-4">
                <div class="">
                    {{
                        new Intl.NumberFormat("fr-FR", {
                            currency: affaire.monnaie,
                            style: "currency",
                        }).format(
                            ((parseFloat(affaire.prime) *
                                    parseFloat(affaire.part_offerte)) /
                                100) *
                            (1 - parseFloat(affaire.commission_cedante / 100))
                        )
                    }}
                </div>
            </td>
            
            <!-- Prime à recevoir -->
            <td :class="
                                        ((parseFloat(affaire.prime) *
                                            parseFloat(affaire.part_offerte)) /
                                            100) *
                                            (1 - parseFloat(affaire.commission_cedante / 100)) -
                                            parseFloat(
                                                affaire.reinsurers_sum_businesse_reinsurerprime_a_reverser
                                            ) <
                                            0
                                            ? 'bg-primary text-white'
                                            : ''
                                    " class="px-6 py-4">
                <div class="">
                    {{
                        new Intl.NumberFormat("fr-FR", {
                            currency: affaire.monnaie,
                            style: "currency",
                        }).format(
                            affaire.reinsurers_sum_businesse_reinsurerprime_a_reverser
                        )
                    }}
                </div>
            </td>
            <td class="px-6 py-4">
                <a v-if="$page.props.auth.permissions.includes('businesse:edit')"
                   :href="route('business.edit', { affaires: affaire.id, })"
                   class="inline-block text-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                            stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"/>
                    </svg>
                </a>
                
                <a v-if="
                                            $page.props.auth.permissions.includes(
                                                'businesse:delete'
                                            )
                                        " class="inline-block text-center" href="#"
                   @click.prevent="deleteBusiness(affaire)">
                    <svg class="w-6 h-6 text-red-400" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"/>
                    </svg>
                </a>
            </td>
        </tr>
        
        <!-- Second Tableau dans ce TR -->
        <!-- Listes des reassureur  -->
        
        <tr v-if="showreas[indexes] === true"
            class="relative text-xs text-center text-white transition-all ease-out delay-300 bg-gray-200 ">
            <td class="px-10" colspan="15">
                <table class="sticky left-0 m-0">
                    <thead class="-mt-1 text-left bg-secondary">
                    <tr>
                        <th class="px-6 py-2 text-xs text-white"></th>
                        <th class="px-6 py-2">Réassureur</th>
                        <th class="px-6 py-2">Part acceptée</th>
                        <th class="px-6 py-2">Commission réassureur</th>
                        <th class="px-6 py-2">Prime réassurance</th>
                        <th class="px-6 py-2">Prime à reverser</th>
                        <th class="px-6 py-2">PPW</th>
                        <th class="px-6 py-2">Date acceptation</th>
                    </tr>
                    </thead>
                    
                    <tr v-for="(reass, index) in affaire.reinsurers"
                        :key="index" class="text-left transition-all ease-out delay-300">
                        <!-- {{ reass }} -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-black">
                                {{ index + 1 }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">
                                {{ reass.raison_social }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">
                                {{
                                    new Intl.NumberFormat("fr-FR", {
                                        style: "percent",
                                        minimumFractionDigits: 2,
                                    }).format(reass.pivot.part_accepte / 100)
                                }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">
                                {{
                                    new Intl.NumberFormat("fr-FR", {
                                        style: "percent",
                                        minimumFractionDigits: 2,
                                    }).format(
                                        reass.pivot.commission_reassurance / 100
                                    )
                                }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">
                                {{
                                    new Intl.NumberFormat("fr-FR", {
                                        currency: affaire.monnaie,
                                        style: "currency",
                                    }).format(reass.pivot.prime_reassurance)
                                }}
                            </div>
                        </td>
                        <!-- <span class="text-black"> {{reass}}</span> -->
                        <td class="px-6 py-4">
                            <div class="text-gray-900">
                                {{
                                    new Intl.NumberFormat("fr-FR",
                                        {
                                            currency: affaire.monnaie, style: "currency",
                                        }).format(reass.pivot.prime_a_reverser)
                                }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="text-gray-900">
                                {{ reass.pivot.ppw }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">
                                {{
                                    new Date(reass.pivot.date_accept).toLocaleDateString("fr-FR")
                                }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </template>
</template>

<script setup>

import {onMounted, onUpdated, reactive} from "vue";
import useBusiness from "@/Services/useBusiness";
import WarningIcons from "@/Components/Icons/warningIcons.vue";

const props = defineProps(['affaires', 'showreas'])


onMounted(() => {
})
onUpdated(() => {
})
const toggleAccordion = (index) => {
    props.showreas[index] = !props.showreas[index];
};
const {business, destroyBusiness, loading} = useBusiness();
</script>

<style scoped>

</style>