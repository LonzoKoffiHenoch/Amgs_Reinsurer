<template>
    <div>
        <MyModal :show="props.show" @close="setIsOpened(false)" :closeable="true" :max-width="'6xl'"
            :max-height="'h-[50%]'">
            <template #content>
                <div class="fixed inset-0 p-4 overflow-y-auto">
                    <div class="flex justify-between">
                        <h3 class="text-2xl font-bold">Solder une affaire</h3>
                        <div class="flex gap-8 left">
                            <button
                                class="text-xl w-8 h-8 transition-all hover:bg-primary hover:rounded-[100%] hover:w-8 hover:h-8 p-[0.15rem] hover:p-[0.15rem] hover:text-white "
                                @click="setIsOpened(false)">
                                x
                            </button>
                        </div>

                    </div>
                    <div class="mt-4">
                        <table class="w-full divide-gray-300" id="dataTable">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="px-2 py-2 text-xs text-white">Nom affaire</th>
                                    <th class="px-2 py-2 text-xs text-white">Montant affaire</th>
                                    <th class="px-2 py-2 text-xs text-white">Devise</th>
                                    <th class="px-2 py-2 text-xs text-white">Iban du réassureur</th>
                                    <th class="px-1 py-1 text-xs text-white">Date envoie</th>
                                    <th class="px-2 py-2 text-xs text-white">Montant à reverser</th>
                                    <th class="px-2 py-2 text-xs text-white">Banque Amgs</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                <template v-for="(ced, indexes) in tabBusinessToPay" :key="indexes">
                                    <!-- {{ ced }} -->
                                    <tr class="text-center whitespace-nowrap">
                                        <td class="hidden px-2 py-4">
                                            <div class="text-sm text-gray-900">
                                                <input type="text" name="" id="">

                                            </div>
                                        </td>
                                        <td class="px-2 py-4">
                                            <div class="text-sm text-gray-900">{{ ced.nom_assure }}</div>
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500 ">
                                            <div class="text-sm text-gray-500 contient_monnaie">
                                                {{
                                                    new Intl.NumberFormat
                                                        ("fr-FR", {
                                                            currency:
                                                                ced.monnaie,
                                                            style: "currency",
                                                        })
                                                        .format(((parseFloat(ced.prime) * parseFloat(ced.part_offerte)) / 100)
                                                            * (1 - parseFloat(ced.commission_cedante / 100)))
                                                }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-4">
                                            <div class="text-sm text-gray-500 ">{{ ced.monnaie }}</div>
                                        </td>
                                        <td class="px-2 py-4">
                                            <div class="text-sm text-gray-500 ">
                                                <select class="w-90% bank"
                                                    v-model="formsolde.business[indexes].bank_id_reinsurer">
                                                    <template v-for="(bank, index) in banks_for_reinsurer.banks"
                                                        :key="index">
                                                        <option :value="bank.id">{{ bank.iban }} | {{
                                                            bank.raison_social
                                                        }}</option>
                                                    </template>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="px-2 py-4">
                                            <div class="text-sm text-gray-500">
                                                <!-- {{ formsolde.business[indexes] }} -->
                                                <input class="py-2 text-sm rounded-xl" type="date" name="" id=""
                                                    v-model="formsolde.business[indexes].date_reception">
                                            </div>
                                        </td>
                                        <td class="px-2 py-4">
                                            <div class="text-sm text-gray-500 rounded-xl">
                                                <input type="text" name="" id="" class="w-[95%] rounded-xl"
                                                    v-model="formsolde.business[indexes].montant_recu">

                                            </div>
                                        </td>

                                        <td class="px-2 py-4">
                                            <div class="font-black text-center text-black">
                                                <select
                                                    class="px-1 py-3 text-xs font-black text-center uppercase bank rounded-xl"
                                                    v-model="formsolde.business[indexes].bank_id">
                                                    <template v-for="(bank, index) in banks" :key="index">
                                                        <option :value="bank.id" class="text-xs font-bold uppercase">{{
                                                            bank.raison_social
                                                        }} | {{ bank.pays.label }}</option>
                                                    </template>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Second Tableau dans ce TR -->
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-end">
                        <Button class="self-end gap-2 mt-4 text-center" @click.prevent="soumettre">
                            <span>Solder</span>
                        </Button>
                    </div>
                </div>
            </template>

        </MyModal>
    </div>
</template>

<script setup>
import MyModal from "@/Components/DialogModal.vue";
import Button from "@/Components/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import {
    useSwalConfirm,
    useSwalSuccess,
    useSwalError,
} from "../../../Composables/alert";

import { onUpdated, computed, ref, onBeforeUpdate } from "vue";
const props = defineProps(["show", "data", "tabBusinessToPay", "reas", "businesseid"]);
const emit = defineEmits(["toggle"]);
function setIsOpened(value) {
    emit("toggle", value);
}
const shower = ref(false);
const banks = ref([]);
const banks_for_reinsurer = ref([]);
const vbanks = computed(() => {
    get: () => { }
    set: () => {
        banks.value = banks.value
        return banks.value;
    }
});
const formsolde = useForm({
    bank_id: null,
    business: [],
});
const verifPourcentage = (values, type, model) => {
    //console.log(value);
    //let regex = /^[0-9]{1,50}$/; //regex de verification
    let regex = /^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$/; //regex de verification

    if (!regex.test(document.getElementById(values).value)) {
        document.getElementById(values).value = "";
        // console.log(type);
    }
    if (model == "currency") {
        document.getElementById(values).value = new Intl.Numberformsoldeat("fr-FR", {
            currency: type,
            style: "currency",
        }).formsoldeat(document.getElementById(values).value);
        //console.log(document.getElementById(value).value);
    }
    if (model === "percent") {
        document.getElementById(values).value += " %";
    }
};
const changeMonnaie = (type, index) => {
    const list_champ_monnaie =
        document.querySelectorAll('[class*="contient_monnaie"]');
    //document.getElementsByClassName("contient_monnaie");
    //formsolde.capitaux = formsolde.capitaux.replace(formsolde.monnaie, "");

    const res = parseFloat(
        list_champ_monnaie[index].innerHTML
            .replace(/\s/g, "")
            .replace(/,/g, ".")
    );
    //console.log(res);
    list_champ_monnaie[index].innerHTML = new Intl.Numberformsoldeat("fr-FR", {
        currency: type,
        style: "currency",
    }).formsoldeat(res);


};
for (let index = 0; index < props.tabBusinessToPay.length; index++) {
    formsolde.business.push({
        id: props.reasid,
        bank_id: null,
        bank_id_reinsurer: null,
        date_reception: null,
        montant_recu: "",
        businessid: props.tabBusinessToPay[index].id
    });
}
const execu = () => {
    formsolde.business = [];

    for (let index = 0; index < props.tabBusinessToPay.length; index++) {
        formsolde.business.push({
            id: props.reas,
            bank_id: null,
            bank_id_reinsurer: null,

            date_reception: null,
            montant_recu: "",
            businessid: props.tabBusinessToPay[index].id
        });
    }
}
const getBank = () => {
    axios
        .get(route("api.getAllBank"))
        .then((response) => {
            banks.value = response.data.banks;
            //    console.log(props.reas);
        })
        .catch((error) => {
            console.log(error);
        });
}

const getBankForReinsurer = () => {
    axios
        .get(route("api.get_bank_for_reinsurer", {
            reinsurer: props.reas,
        }))
        .then((response) => {
            banks_for_reinsurer.value = response.data.reinsurer;
            // console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });
}
onBeforeUpdate(() => {
    for (let index = 0; index < props.tabBusinessToPay.length; index++) {
        formsolde.business.push({
            paymentable_id: props.reas,
            bank_id: null,
            bank_id_reinsurer: null,

            businessid: props.tabBusinessToPay[index].id


        });
        getBank();
        getBankForReinsurer();
    }
});

onUpdated(() => {

    if (formsolde.business.length = 0) {
        for (let index = 0; index < props.tabBusinessToPay.length; index++) {
            formsolde.business.push({
                paymentable_id: props.reas,
                businessid: props.tabBusinessToPay[index].id

            });
        }
    }
    else {
        // formsolde.business = [];
        for (let index = 0; index < props.tabBusinessToPay.length; index++) {
            formsolde.business.push({
                paymentable_id: props.reas,
                businessid: props.tabBusinessToPay[index].id

            });
        }
    }
    shower.value = true



});
const getCed = () => {
    axios
        .get(route("api.reas"))
        .then((response) => {
            props.cedante = response.data.reas;
            // console.log(cedante.value.length);
            // for (let index = 0; index < props.cedante.length; index++) {
            //     //showreas.push(false);
            // }
        })
        .catch((error) => {
            console.log(error);
        });
};
const changeBankAllBusiness = (valueBank) => {
    var totalCheckedToPay = document.querySelectorAll(
        '.bank');
    for (let index = 0; index < totalCheckedToPay.length; index++) {
        formsolde.business[index].bank_id = valueBank;

    }
    // console.log(totalCheckedToPay);
}
const soumettre = () => {
    formsolde.post(route("paymentsolde.storepayreas"), {
        onSuccess: (page) => {
            emit("recharge");
            // console.log(page.props.flash.message);
            if (page.props.flash.message == "sinistre de commission") {

                useSwalConfirm(page.props.flash.message);
            } else {

                useSwalSuccess(page.props.flash.message);
            }
            setIsOpened(false);
            // formsolde.reset();
            getCed();
        },
        onError: (errors) => {
            useSwalError("Une erreur s'est produite.");
            preserveState: true;
        },
    });
};

</script>
