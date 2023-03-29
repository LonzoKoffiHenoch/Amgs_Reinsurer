<template>

    <solde-reinsurer-modal :show="show" :closeable="closeable" :data="props.cedante" @toggle="(value) => (show = value)"
        @recharge="recharge" :tabBusinessToPay="tabReinsurrerToPay" :reas="reasid" :businesseid="businessid" />

    <div class="mt-4">
        <div class="flex flex-col">
            <div class="w-full">
                <div class="border-b border-gray-200 shadow">
                    <table class="w-full divide-gray-300" id="dataTable2">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-[0.1rem] w-[20px] ml-2"></th>
                                <th class="px-6 py-2 text-xs text-white">Reassureur</th>
                                <th class="px-6 py-2 text-xs text-white">Registre de Commerce</th>
                                <th class="px-6 py-2 text-xs text-white">RIB</th>
                                <th class="px-6 py-2 text-xs text-white">Prime</th>
                                <th class="px-6 py-2 text-xs text-white">Actions</th>
                            </tr>
                        </thead>


                        <tbody class="bg-white divide-y divide-gray-300">
                            <template v-for="(ced, indexes) in reas" :key="indexes">
                                <tr class="text-center whitespace-nowrap">
                                    <td class="">
                                        <button
                                            v-if="showreas[indexes] == false && ced.businesses_with_not_pay.length >= 1"
                                            class="m-2 text-xl transition-all ease-out delay-300 "
                                            @click.prevent="toggleAccordion(indexes)">
                                            +
                                        </button>
                                        <button v-if="showreas[indexes] == true"
                                            class="m-2 text-xl transition-all ease-out delay-300 "
                                            @click.prevent="toggleAccordion(indexes)">
                                            -
                                        </button>
                                        <input type="checkbox" :id="ced.id" @change="checkAll(ced.id, indexes)"
                                            v-model="form.selectGroup[indexes]"
                                            v-if="$page.props.auth.permissions.includes('finance:edit')" />
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ ced.raison_social }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <div class="text-sm text-gray-500">{{ ced.nom_cedante }}</div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500">{{ ced.monnaie }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500"></div>
                                    </td>
                                    <td class="px-6 py-4" v-if="$page.props.auth.permissions.includes('finance:edit')">
                                        <Button class="text-center" @click.prevent="getPayment(ced.id)">
                                            <span>Payer</span>
                                        </Button>
                                    </td>
                                </tr>

                                <!-- Second Tableau dans ce TR -->
                                <tr class="text-center text-white transition-all ease-out delay-300 bg-gray-200"
                                    v-show="showreas[indexes] == true">
                                    <td colspan="10" class="px-10">
                                        <table class="w-full m-0">
                                            <thead class="-mt-1 bg-secondary">
                                                <tr>
                                                    <th class="px-6 py-2 text-xs text-white"></th>
                                                    <th class="px-6 py-2 text-xs ">Nom assure </th>
                                                    <th class="px-6 py-2 text-xs ">Branches </th>
                                                    <th class="px-6 py-2 text-xs ">Prime à 100% </th>
                                                    <th class="px-6 py-2 text-xs ">Part offerte</th>
                                                    <th class="self-start px-6 py-2 text-xs">Stauts de l'affaire</th>
                                                </tr>
                                            </thead>

                                            <tr class="transition-all ease-out delay-300 "
                                                v-for="(reass, index) in ced.businesses_with_not_pay" :key="index">
                                                <td class="w-[110px]">
                                                    <div class="flex justify-between text-sm font-bold text-black">
                                                        <input type="checkbox" :name="reass.id"
                                                            @change="checkChange(ced.id)" :value="reass.id"
                                                            :class="'' + ced.id" />
                                                        <span>Affaires {{ index + 1 }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 ">{{ reass.nom_assure }}</div>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 ">{{ reass.branche }}</div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 ">
                                                        {{
                                                            new Intl.NumberFormat("fr-FR",
                                                                {
                                                                    currency:
                                                                        reass.monnaie,
                                                                    style: "currency",
                                                                }
                                                            ).format(
                                                                reass.prime
                                                            )
                                                        }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 ">
                                                        {{
                                                            new Intl.NumberFormat("fr-FR", {
                                                                style: "percent",
                                                            }).format(reass.part_offerte / 100)
                                                        }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-xm"
                                                        :class="reass.statut == 1 ? 'bg-green-700 text-white' : 'bg-red-700 text-white'">
                                                        {{
    reass.statut == 1 ? "Soldé" : reass.statut == 0
        ? " soldé partielement"
        : "nom-soldé"
                                                        }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import Button from "@/Components/Button.vue";
import {
    useSwalConfirm,
    useSwalSuccess,
    useSwalError,
} from "../../Composables/alert";
import SoldeReinsurerModal from "./Modal/SoldeReinsurerModal.vue";

import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
const show = ref(false);

const props = defineProps(["showreas", "reas"]);
const emit = defineEmits(["toggle", "recharge"]);
const toggleAccordion = (index) => { props.showreas[index] = !props.showreas[index]; };
const tabReinsurrerToPay = ref([]);

const form = useForm({
    selected: [],
    selectGroup: [],
    indeterminate: false,
    flavours: [],
});
const recharge = () => {
    emit('recharge');

}
// fonctions des cases à cocher---------------------------
const checkAll = (e, indexes) => {
    var checkboxes = document.getElementsByClassName(e);
    var parentCheckboxes = document.getElementById(e);
    if (parentCheckboxes.checked) {
        if (props.showreas[indexes] == true) {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
        } else {
            toggleAccordion(indexes);
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }
    }
};
const checkChange = (e) => {
    var totalCheckbox = document.querySelectorAll('input[class="' + e + '"]').length;
    var totalChecked = document.querySelectorAll('input[class="' + e + '"]:checked').length;

    // When total options equals to total checked option
    if (totalCheckbox == totalChecked) {
        document.getElementById(e).checked = true;
    } else {
        document.getElementById(e).checked = false;
    }
};

const getPayment = (e) => {
    let totalCheckedToPay = document.querySelectorAll('input[class="' + e + '"]:checked');
    const element = ref([]);
    for (let index = 0; index < totalCheckedToPay.length; index++) {
        element.value.push(totalCheckedToPay[index].value);
        // console.log(element);
    }
    if (!totalCheckedToPay.length == 0) {
        sendBusinessToPay(element.value, e);
    } else {
        useSwalError("Aucune affaire n'a été selectionné pour cette cedante");
    }

};
// fin fonctions des cases à cocher-----------------------
const tabBusinessToPay = ref([]);
const reasid = ref(null);
const businessid = ref(null);
const sendBusinessToPay = async (tab, reasidV) => {
    // console.log(tab);
    await axios
        .post(route("send.reaspay"), { tab: tab, reasid: reasidV })
        .then((response) => {
            tabReinsurrerToPay.value = response.data.tab;
            reasid.value = reasidV;
            for (let index = 0; index < tabBusinessToPay.length; index++) {
                formsolde.business.push({ id: tabReinsurrerToPay[index].id, date_reception: null, montant_recu: "", });
            }
            show.value = true;
        })
        .catch((error) => {
            console.log(error);
        });
}
</script>