<template>
    <div>
        <MyModal :show="props.show" @close="setIsOpened(false)" :closeable="true" :max-width="'6xl'"
            :max-height="'h-[50%]'">
            <template #content>
                <div class="fixed inset-0 overflow-y-auto p-4">
                    <div class="flex justify-between">
                        <h3 class="text-2xl font-bold">Solder une affaire</h3>
                        <div class="left flex gap-8">
                            <button class="
                                    text-xl
                                    w-8
                                    h-8
                                    transition-all
                                    hover:bg-primary
                                    hover:rounded-[100%]
                                    hover:w-8
                                    hover:h-8
                                    p-[0.15rem]
                                    hover:p-[0.15rem] hover:text-white
                                " @click="setIsOpened(false)">
                                x
                            </button>
                        </div>

                    </div>
                    <div class="mt-4 overflow-x-auto ">
                        <!-- <select class="w-90%" v-model="formsolde.bank_id" @change="changeBankAllBusiness(formsolde.bank_id)">
                                                <template  v-for="(bank, index) in banks" :key="index">
                                                    <option :value="bank.id">{{ bank.raison_social }}</option>
                                                </template>
                                            </select> -->
                        <table class="divide-gray-300 w-full" id="dataTable">
                            <thead class="bg-primary">
                                <tr>

                                    <th class="px-2 py-2 text-xs text-white">
                                        Affaire
                                    </th>
                                    <th class="px-2 py-2 text-xs text-white">
                                        Montant à recevoir
                                    </th>
                                    <!-- <th class="px-2 py-2 text-xs text-white">
                                        Date
                                    </th> -->
                                    <th class="px-2 py-2 text-xs text-white">
                                        Devise
                                    </th>

                                    <th class="px-2 py-2 text-xs text-white">
                                        Date réception
                                    </th>
                                    <th class="px-2 py-2 text-xs text-white">
                                        Banque
                                    </th>
                                    <th class="px-2 py-2 text-xs text-white whitespace-nowrap ">
                                        Montant reçu
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                <template v-for="(ced, indexes) in tabBusinessToPay" :key="indexes">
                                    <tr class="text-center whitespace-nowrap">
                                        <td class="px-2 py-4 hidden">
                                            <div class="text-sm text-gray-900">
                                                <input type="text" name="" id="">

                                            </div>
                                        </td>
                                        <!-- <td class="">
                                            <button
                                                v-if="
                                                    showreas[indexes] ==
                                                        false &&
                                                    ced.businesses_with_not_pay
                                                        .length >= 1
                                                "
                                                class="
                                                    m-2
                                                    text-xl
                                                    transition-all
                                                    ease-out
                                                    delay-300
                                                "
                                                @click.prevent="
                                                    toggleAccordion(indexes)
                                                "
                                            >
                                                +
                                            </button>
                                            <button
                                                v-if="showreas[indexes] == true"
                                                class="
                                                    m-2
                                                    text-xl
                                                    transition-all
                                                    ease-out
                                                    delay-300
                                                "
                                                @click.prevent="
                                                    toggleAccordion(indexes)
                                                "
                                            >
                                                -
                                            </button>
                                            <input
                                                type="checkbox"
                                                name=""
                                                id=""
                                            />
                                        </td> -->
                                        <td class="px-2 py-4">
                                            <div class="text-sm text-gray-900">
                                                {{ ced.nom_assure }}
                                            </div>
                                        </td>
                                        <td class="
                                                px-2
                                                py-4
                                                text-sm text-gray-500
                                            ">
                                            <div class="text-sm text-gray-500 contient_monnaie">
                                                <!-- {{ ced.prime }} -->
                                                {{
                                                        new Intl.NumberFormat(
                                                            "fr-FR",
                                                            {
                                                                currency:
                                                                    ced.monnaie,
                                                                style: "currency",
                                                            }
                                                        ).format(
                                                            ((parseFloat(
                                                                ced.prime
                                                            ) *
                                                                parseFloat(
                                                                    ced.part_offerte
                                                                )) /
                                                                100) *
                                                            (1 -
                                                                parseFloat(
                                                                    ced.commission_cedante /
                                                                    100
                                                                ))
                                                        )
                                                }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-4">
                                            <div class="text-sm text-gray-500 ">
                                                {{ ced.monnaie }}
                                            </div>
                                        </td>


                                        <td class="px-2 py-4">
                                            <div class="text-xs text-gray-500">
                                                <!-- {{ formsolde.business[indexes] }} -->
                                                <input class="text-sm rounded-xl" type="date" name="" id=""
                                                    v-model="formsolde.business[indexes].date_reception">
                                            </div>
                                        </td>
                                        <td class="px-2 py-4">
                                            <div class="font-black text-black text-center">
                                                <select
                                                    class="text-xs font-black bank uppercase text-center px-1 rounded-xl py-3"
                                                    v-model="formsolde.business[indexes].bank_id">
                                                    <template v-for="(bank, index) in banks" :key="index">
                                                        <option :value="bank.id"
                                                            class="text-xs font-bold uppercase py-2">{{
                                                                    bank.raison_social
                                                            }} | {{ bank.pays.label }}</option>
                                                    </template>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="px-2 py-4 ">
                                            <div class="text-sm text-gray-500">
                                                <input type="text" name="" id="" class="w-[95%] rounded-xl"
                                                    v-model="formsolde.business[indexes].montant_recu">

                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Second Tableau dans ce TR -->

                                </template>
                            </tbody>
                            <!-- {{ banks }} -->
                        </table>
                    </div>
                    <div class="flex justify-end">
                        <Button class="gap-2 text-center mt-4 self-end" @click.prevent="soumettre">
                            <!-- <LoginIcon aria-hidden="true" :class="iconSizeClasses" /> -->
                            <span>Solder</span>
                        </Button>
                    </div>
                </div>
                <!-- {{ tabBusinessToPay }} -->
            </template>

        </MyModal>
    </div>
</template>

<script setup>
import MyModal from "@/Components/DialogModal.vue";
import Button from "@/Components/Button.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import {
    useSwalConfirm,
    useSwalSuccess,
    useSwalError,
} from "../../../Composables/alert";

import { onActivated, onMounted, onUpdated, onUnmounted, computed, ref, reactive, onBeforeUpdate } from "vue";
const props = defineProps(["show", "data", "tabBusinessToPay", "cedante"]);
const emit = defineEmits(["toggle"]);

function setIsOpened(value) {
    emit("toggle", value);

    // if(value == false){
    // emit("recharge");

    // }
}
const shower = ref(false);
const banks = ref([]);
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
        id: props.tabBusinessToPay[index].id,
        bank_id: null,
        date_reception: null,
        montant_recu: "",
    });
}
const execu = () => {
    formsolde.business = [];

    for (let index = 0; index < props.tabBusinessToPay.length; index++) {
        formsolde.business.push({
            id: props.tabBusinessToPay[index].id,
            bank_id: null,
            date_reception: null,
            montant_recu: "",
        });
    }
}
const getBank = () => {
    axios
        .get(route("api.getAllBank"))
        .then((response) => {
            banks.value = response.data.banks;
            //    console.log(banks);
        })
        .catch((error) => {
            console.log(error);
        });
}
onBeforeUpdate(() => {
    for (let index = 0; index < props.tabBusinessToPay.length; index++) {
        formsolde.business.push({
            paymentable_id: props.tabBusinessToPay[index].id,
            bank_id: null

        });
        getBank();
    }
});

onUpdated(() => {

    if (formsolde.business.length = 0) {
        for (let index = 0; index < props.tabBusinessToPay.length; index++) {
            formsolde.business.push({
                paymentable_id: props.tabBusinessToPay[index].id,
            });
        }
    }
    else {
        // formsolde.business = [];
        for (let index = 0; index < props.tabBusinessToPay.length; index++) {
            formsolde.business.push({
                paymentable_id: props.tabBusinessToPay[index].id,
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
    formsolde.post(route("paymentsolde.store"), {
        onSuccess: (page) => {
            emit("recharge");
            useSwalSuccess("Affaire soldée avec succès!");
            setIsOpened(false);
            formsolde.reset();
            getCed();
        },
        onError: (errors) => {
            useSwalError("Une erreur s'est produite.");
            preserveState: true;
        },
    });
};

</script>
