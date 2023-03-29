<template>
    <solde-modal :show="show" :closeable="closeable" :data="props.cedante" @toggle="(value) => (show = value)"
        @recharge="recharge" :tabBusinessToPay="tabBusinessToPay" :cedante="props.cedante" />
    <div class="mt-4">
        <div class="flex flex-col">
            <div class="w-full">
                <div class="border-b border-gray-200 shadow">
                    <table class="w-full divide-gray-300" id="dataTable2">
                        <thead class="text-left bg-primary ">
                            <tr>
                                <th class="text-[0.1rem] w-[20px] ml-2"></th>
                                <th class="px-6 py-2 text-xs text-white whitespace-nowrap w-[20%]">Cédante</th>
                                <th class="px-6 py-2 text-xs text-white w-[20%]">Pays</th>
                                <th class="px-6 py-2 text-xs text-center text-white">Nombre d'affaires</th>
                                <th class="px-6 py-2 text-xs text-center text-white">Action</th>
                            </tr>
                        </thead>

                        <tbody class="object-contain bg-white divide-y divide-gray-300">
                            <template v-for="(ced, indexes) in cedante" :key="indexes">
                                <!-- {{ ced }} -->
                                <tr class="object-contain text-left whitespace-nowrap">
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
                                        <!-- selectAllBusiness(indexes), -->
                                        <input type="checkbox" :id="ced.id" ref="" v-model="form.selectGroup[indexes]"
                                            @change="checkAll(ced.id, indexes)" />
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ ced.raison_social }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap w-1/100">
                                        <div class="text-sm text-gray-500">{{ ced.pays.label }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-lg font-bold text-center text-gray-500">
                                            {{
                                                ced.businesses_with_not_pay_count
                                            }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center"
                                        v-if="$page.props.auth.permissions.includes('finance:edit')">
                                        <Button class="text-center" @click.prevent="getPayment(ced.id)">
                                            <!-- <LoginIcon aria-hidden="true" :class="iconSizeClasses" /> -->
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
                                                    <th class="px-6 py-2 text-xs text-left w-[10%] ">Affaire</th>
                                                    <th class="px-6 py-2 text-xs text-left">Branche</th>
                                                    <th class="px-6 py-2 text-xs ">Prime à recevoir</th>
                                                    <th class="px-6 py-2 text-xs ">Part offerte</th>
                                                    <th class="self-start px-6 py-2 text-xs">Statuts</th>
                                                </tr>
                                            </thead>

                                            <tr class="transition-all ease-out delay-300"
                                                v-for="(reass, index) in ced.businesses_with_not_pay" :key="reass.id">
                                                <td class="w-[110px]">
                                                    <div class="flex gap-10 text-sm font-bold text-left text-black ">
                                                        <input type="checkbox" :name="reass.id"
                                                            @change="checkChange(ced.id)" :value="reass.id"
                                                            :class="'' + ced.id" />
                                                        <span class="text-left">{{ index + 1 }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-left text-gray-900 ">{{ reass.nom_assure }}
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 ">{{ reass.branche }}</div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 ">{{
                                                        new
                                                                                                            Intl.NumberFormat("fr-FR",
                                                            {
                                                                currency:
                                                                    reass.monnaie,
                                                                style: "currency",
                                                            }
                                                        ).format(reass.prime_a_recevoir)
                                                    }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900">
                                                        {{
                                                            new Intl.NumberFormat("fr-FR",
                                                                {
                                                                    style: "percent",
                                                                }
                                                            ).format(reass.part_offerte / 100)
                                                        }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm"
                                                        :class="reass.statut == 1 ? 'bg-green-700 text-white' : 'bg-red-700 text-white'">
                                                        {{ reass.statut == 1 ? "Soldé" : "Non-soldé" }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <!-- {{ props }} -->
                    </table>
                </div>
            </div>
        </div>

    </div>

</template>
<script setup>
import Button from "@/Components/Button.vue";
import SoldeModal from "./Modal/SoldeModal.vue";
import {
    useSwalConfirm,
    useSwalSuccess,
    useSwalError,
} from "../../Composables/alert";
import { useForm } from "@inertiajs/inertia-vue3";
import { onMounted, ref, onUpdated } from "vue";
const show = ref(false);
const tabBusinessToPay = ref([]);
const props = defineProps(["showreas", "cedante"]);
const emit = defineEmits(["toggle", "recharge"]);

const currentPage = ref(1);
const toggleAccordion = (index) => {
    props.showreas[index] = !props.showreas[index];
    // console.log(props.showreas);
};
const form = useForm({
    selected: [],
    selectGroup: [],
    indeterminate: false,
    flavours: [],
});
const formsolde = useForm({
    business: []
});
const testGroup = [];

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
//MISE EN FORME TABLEAU
const tableFormat = () => {
    dataTable = new DataTable("#dataTable");
}
// const page = () => {
//     emit('page', currentPage)
//     recharge()
// }
const recharge = () => {
    emit('recharge');
    // console.log('test');
}
const checkChange = (e) => {
    var totalCheckbox = document.querySelectorAll(
        'input[class="' + e + '"]'
    ).length;
    var totalChecked = document.querySelectorAll(
        'input[class="' + e + '"]:checked'
    ).length;

    // When total options equals to total checked option
    if (totalCheckbox == totalChecked) {
        document.getElementById(e).checked = true;
    } else {
        document.getElementById(e).checked = false;
    }
};
const getPayment = (e) => {
    // console.log(e);
    var totalCheckedToPay = document.querySelectorAll(
        'input[class="' + e + '"]:checked'
    );
    const element = ref([]);
    for (let index = 0; index < totalCheckedToPay.length; index++) {
        element.value.push(totalCheckedToPay[index].value);

    }
    if (!totalCheckedToPay.length == 0) {
        // log(e);
        sendBusinessToPay(element.value);
    } else {
        useSwalError("Aucune affaire n'a été selectionné pour cette cedante");
    }

};
const getSavePay = () => {
    axios
        .get(route("api.reas"))
        .then((response) => {
            props.cedante = response.data.reas;
        })
        .catch((error) => {
            console.log(error);
        });
};
const sendBusinessToPay = async (tab) => {
    // console.log(tab);
    await axios
        .post(route("send.businesspay"), {
            tab: tab,
        })
        .then((response) => {
            // console.log(response);

            tabBusinessToPay.value = response.data.tab;
            for (let index = 0; index < tabBusinessToPay.length; index++) {
                formsolde.business.push({
                    id: tabBusinessToPay[index].id,
                    date_reception: null,
                    montant_recu: "",
                });
            }
            // console.log(formsolde);
            show.value = true;

            //console.log(tabBusinessToPay.value);

        })
        .catch((error) => {
            console.log(error);
        });
}
onMounted(() => { });
onUpdated(() => {
});

</script>
<style scoped>

</style>