<template>
    <div class="grid grid-cols-8 gap-4 -m-[0.3rem]" v-for="(reinsu, index) in props.formValues.reinsurer"
        v-bind:key="index">
        <hr class="col-span-9 mt-4" />
        <h2>Reassureur {{ index + 1 }}</h2>

        <!-- Reassureur -->
        <div class="space-y-2 col-span-2 col-start-1">
            <div class="space-y-2">
                <Label for="Réassureur" value="Réassureur" />
                <div class="flex flex-col">
                    <v-select :options="reinsurer" v-model="props.formValues.reinsurer[index].raison_social">
                    </v-select>
                </div>
            </div>
        </div>
        <!-- Part Accepté -->
        <div class="space-y-2">
            <Label :for="'part_accepte' + [index]" value="Entrez la part acceptée" />
            <InputIconWrapper>
                <template #icon>
                    <UserIcon aria-hidden="true" class="w-5 h-5" />
                </template>
                <Input withIcon :id="'part_accepte' + [index]" type="text" placeholder="Part Accepté"
                    class="block w-full part_accepte text-xs" v-model="props.formValues.reinsurer[index].part_accepte"
                    @focusout="
    verifPourcentage('part_accepte' + [index], '', 'percent');
calculer(index);
verif();
                    " @change="calculer(index)" @focus="deleteMonnaie('part_accepte' + [index], 'percent')" required
                    autofocus />
            </InputIconWrapper>
        </div>
        <!-- commission_reassurance -->
        <div class="space-y-2">
            <Label for="Commission_reassurance" value="Commision de réassurance" />
            <InputIconWrapper>
                <template #icon>
                    <UserIcon aria-hidden="true" class="w-5 h-5" />
                </template>
                <Input withIcon :id="'commission_reassurance' + [index]" type="text"
                    class="block w-full part_accepte text-xs"
                    v-model="props.formValues.reinsurer[index].commission_reassurance"
                    @focusout="verifPourcentage('commission_reassurance' + [index], '', 'percent')"
                    @focus="deleteMonnaie('commission_reassurance' + [index], 'percent')" required />
            </InputIconWrapper>
        </div>

        <!-- Prime reception Affaire -->
        <div class="space-y-2">
            <Label for="prime_reassurance" value="Prime reassureur" />
            <InputIconWrapper>
                <template #icon>
                    <UserIcon aria-hidden="true" class="w-5 h-5" />
                </template>
                <Input withIcon :id="'prime_reassurance' + [index]" type="text"
                    class="block w-full contient_monnaie text-xs"
                    v-model="props.formValues.reinsurer[index].prime_reassurance" readonly="readonly" required
                    autofocus />
            </InputIconWrapper>
        </div>

        <!-- Date reception Affaire -->
        <div class="space-y-2">
            <Label :for="'prime_reçu' + [index]" value="Prime à recevoir" />
            <InputIconWrapper>
                <template #icon>
                    <UserIcon aria-hidden="true" class="w-5 h-5" />
                </template>
                <Input withIcon :id="'prime_reçu' + [index]" type="text" class="block w-full contient_monnaie text-xs"
                    v-model="props.formValues.reinsurer[index].prime_reçu"
                    @focusout="verifPourcentage('prime_reçu' + [index], props.formValues.monnaie, 'currency'); verif();"
                    @focus="deleteMonnaie('prime_reçu' + [index], props.formValues.monnaie)" required autofocus />
            </InputIconWrapper>
        </div>
        <!-- PPW -->
        <div class="space-y-2">
            <Label for="ppw" value="PPW" />
            <InputIconWrapper>
                <template #icon>
                    <UserIcon aria-hidden="true" class="w-5 h-5" />
                </template>
                <Input withIcon id="ppw" type="number" class="block w-full text-xs"
                    v-model="props.formValues.reinsurer[index].ppw" required autofocus autocomplete="name" />
            </InputIconWrapper>
        </div>

        <!-- Date Accept -->
        <div class="space-y-2">
            <Label for="date_accept" value="Date acceptation" />
            <InputIconWrapper>
                <template #icon>
                    <UserIcon aria-hidden="true" class="w-5 h-5" />
                </template>
                <Input withIcon id="date_accept" type="date" class="block w-full part_accepte text-xs"
                    v-model="props.formValues.reinsurer[index].date_accept" required autofocus />
            </InputIconWrapper>
        </div>
    </div>
</template>

<script setup>
import vSelect from "vue-select";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import { useSwalSuccess, useSwalError, useSwalConfirm } from "../../../Composables/alert";
import { ref, reactive } from "vue";

const props = defineProps({
    reinsurer: Array,
    pays: Array,
    formValues: Object,
    calcul: Number,
});

const add = () => {
    props.formValues.reinsurer.push({
        ppw: 30,
    });
};
const calculer = (index) => {
    props.formValues.reinsurer[index].prime_reassurance = (props.formValues.prime * props.formValues.reinsurer[index].part_accepte) / 100;
    props.formValues.reinsurer[index].prime_reçu = props.formValues.reinsurer[index].prime_reassurance;
    changeMonnaie(props.formValues.monnaie);
};
const verif = (type) => {
    if (type != "fermer") {
        props.calcul = 0;
        for (let index = 0; index < props.formValues.reinsurer.length; index++) {
            props.calcul += parseFloat(props.formValues.reinsurer[index].part_accepte);
        }
        if (props.calcul < props.formValues.part_offerte) {
            add();
        }
        if (props.calcul > props.formValues.part_offerte) {
            useSwalConfirm("Veuillez reduire la part du dernier reassureur ");
        }
    } else {
        if (type == "fermer" && props.calcul == props.formValues.part_offerte) {
            setIsCloser(false);
        }
    }
    // console.log(props.calcul);
};
const remove = () => {
    this.props.formValues.reinsurer.pop();
};

const verifPourcentage = (values, type, model) => {
    let regex = /^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$/; //regex de verification

    if (!regex.test(document.getElementById(values).value)) {
        document.getElementById(values).value = "";
    }
    if (model == "currency") {
        document.getElementById(values).value = new Intl.NumberFormat("fr-FR", {
            currency: type,
            style: "currency",
        }).format(document.getElementById(values).value);
        //console.log(document.getElementById(value).value);
    }
    if (model === "percent") {
        document.getElementById(values).value += " %";
    }
};

const changeMonnaie = (type) => {
    const list_champ_monnaie = document.getElementsByClassName("contient_monnaie");
    for (let index = 0; index < list_champ_monnaie.length; index++) {
        if (list_champ_monnaie[index].value != 0) {
            //props.formValues.capitaux = props.formValues.capitaux.replace(props.formValues.monnaie, "");

            const res = parseFloat(
                list_champ_monnaie[index].value.replace(/\s/g, "").replace(/,/g, ".")
            );
            //console.log(res);
            list_champ_monnaie[index].value = new Intl.NumberFormat("fr-FR", {
                currency: type,
                style: "currency",
            }).format(res);
        }
    }
};
const deleteMonnaie = (value, type) => {
    if (type != "percent") {
        if (document.getElementById(value).value != 0) {
            document.getElementById(value).value = parseFloat(
                document.getElementById(value).value.replace(/\s/g, "").replace(/,/g, ".")
            );
        }
    }
    if (type == "percent") {
        //console.log("tedst");
        document.getElementById(value).value = document
            .getElementById(value)
            .value.replace(" %", "");
    }
};
</script>
