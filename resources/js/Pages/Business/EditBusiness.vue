<template>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Modification de l'affaire :
        <strong class="ml-5 text-2xl">{{ affaires.nom_cedante }}</strong>
    </h2>
    <form @submit.prevent="editBusiness" id="formulaireEdition">
        <hr class="mb-4 border-black" />
        <div class="grid grid-cols-4 gap-4 p-3 border-2">

            <!-- assuré -->
            <div class="space-y-2">
                <Label for="nomAssure" value="Nom de l'assuré" />
                <InputIconWrapper>
                    <Input withIcon id="nomAssure" type="text" placeholder="Nom de l'assuré" class="block w-full pl-2"
                        v-model="form.nom_assure" required autofocus autocomplete="nomAssure" />
                </InputIconWrapper>
            </div>

            <!-- Date reception Affaire -->
            <div class="space-y-2">
                <Label for="DateReception" value="Date de reception de l'affaire" />
                <InputIconWrapper>
                    <Input withIcon id="DateReception" type="date" class="block w-full pl-2"
                        v-model="form.date_reception" required autofocus />
                </InputIconWrapper>
            </div>


            <div class="space-y-2">
                <Label for="Pays" value="Pays de l'assuré" />
                <v-select class="text-[0.90rem]" :options="country" label="label" v-model="form.pays_assure"
                    @option:selected="getTransferorFromCountry, changing()">
                </v-select>
            </div>
            {{ form.transferors_id }}

            <!-- Cedante -->
            <div class="space-y-2">
                <Label for="Cedante" value="Choisir la cedante" />
                <v-select class="text-[0.75rem] cedantSelectionner" v-model="form.transferor"
                    :options="getTransferorFromCountry" label="raison_social">
                </v-select>
            </div>

            <!-- branche -->
            <div class="space-y-2">
                <Label for="Branches" value="Branche" />
                <v-select class="text-[0.90rem]" v-model="form.branche" :reduce="(option) => option" :options="branche"
                    label="label">
                </v-select>
            </div>

            <!-- Date effet -->
            <div class="space-y-2">
                <Label for="DateEffet" value="Date d'effet" />
                <InputIconWrapper>
                    <Input withIcon id="DateEffet" type="date" placeholder="Date d'effet" class="block w-full pl-2"
                        v-model="form.date_effet" required autofocus autocomplete="name" />
                </InputIconWrapper>
            </div>

            <!-- Date echeance -->
            <div class="space-y-2">
                <Label for="DateEcheance" value="Date d'echeance" />
                <InputIconWrapper>
                    <Input withIcon id="DateEchance" type="date" placeholder="Date d'echeance" class="block w-full pl-2"
                        v-model="form.date_echeance" required autofocus autocomplete="name" />
                </InputIconWrapper>
            </div>

            <!-- monnaie -->
            <div class="w-full space-y-2">
                <Label for="monnaie" value="Choisir la monnaie" />
                <select name="monnaie" id="monnaie" v-model="form.monnaie" @change="getCurrency(form.monnaie)"
                    class="w-full text-center border-gray-600 rounded-md">
                    <option value="USD">Dollars</option>
                    <option value="EUR">Euro</option>
                    <option value="XOF">Fcfa</option>
                    <option value="GBP">Livres</option>
                </select>
            </div>

            <!-- Capitaux à 100% -->
            <div class="space-y-2">
                <Label for="capitaux_100" value="Capitaux" />
                <InputIconWrapper>
                    <Input withIcon id="capitaux_100" type="text" placeholder="Capitaux à 100%"
                        class="block w-full pl-2 contient_monnaie" v-model="form.capitaux"
                        @focusout="checkingPercentage('capitaux_100', form.monnaie, 'currency')"
                        @focus="deleteCurrency('capitaux_100', form.monnaie)" required autofocus />
                </InputIconWrapper>
            </div>

            <!-- Prime à 100% -->
            <div class="space-y-2">
                <Label for="Prime" value="Prime à 100%" />
                <InputIconWrapper>
                    <Input withIcon id="Prime" type="text" placeholder="Entrez la prime"
                        class="block w-full pl-2 contient_monnaie" v-model="form.prime" @focusout="
                            checkingPercentage('Prime', form.monnaie, 'currency')
                        " @focus="deleteCurrency('Prime', form.monnaie)" required autofocus />
                </InputIconWrapper>
            </div>
            <!-- Commission Cedente -->
            <div class="space-y-2">
                <Label for="Commission_cedante" value="Commission de la cedante" />
                <InputIconWrapper>
                    <Input withIcon id="Commission_cedante" type="text" placeholder="Commission de la cédante"
                        class="block w-full pl-2 contientPercent" v-model="form.commission_cedante"
                        @focusout="checkingPercentage('Commission_cedante', '', 'percent')"
                        @focus="deleteCurrency('Commission_cedante', 'percent')" required autofocus />
                </InputIconWrapper>
            </div>
            <!-- Part offert -->
            <div class="space-y-2">
                <Label for="part_offerte" value="Part Offerte" />
                <InputIconWrapper>
                    <Input withIcon id="part_offerte" type="text" placeholder="Entrez la part offerte"
                        class="block w-full pl-2 contientPercent" v-model="form.part_offerte"
                        @focusout="checkingPercentage('part_offerte', '', 'percent')"
                        @focus="deleteCurrency('part_offerte', 'percent')" required autofocus />
                </InputIconWrapper>
            </div>
        </div>

        <!-- Affichage des Reassureurs -->
        <div class="grid grid-cols-4 gap-4 p-3" v-for="(reinsu, index) in props.affaires.reinsurers" v-bind:key="index">
            <hr class="col-span-4 mt-4 border-black" />

            <!-- Reassureur -->
            <div class="col-span-2 col-start-1 space-y-2 ">
                <div class="space-y-2">
                    <Label for="Réassureur" value="Réassureur" />
                    <div class="flex flex-col">
                        <v-select v-model="form.reinsurer[index].raison_social" :options="reas">
                        </v-select>
                    </div>
                </div>
            </div>

            <!-- Part Accepté -->
            <div class="space-y-2">
                <Label :for="'part_accepte' + [index]" value="Entrez la part acceptée" />
                <InputIconWrapper>
                    <Input withIcon :id="'part_accepte' + [index]" type="text" placeholder="Part Accepté"
                        class="block w-full pl-2 part_accepte contientPercent"
                        v-model="form.reinsurer[index].part_accepte"
                        @focusout="checkingPercentage('part_accepte' + [index], '', 'percent'); checkingParts(); calculer(index);"
                        @focus="deleteCurrency('part_accepte' + [index], 'percent')" required autofocus />
                </InputIconWrapper>
            </div>
            <!-- commission_reassurance -->
            <div class="space-y-2">
                <Label :for="'Commission_reassurance' + [index]" value="Commision de réassurance" />
                <InputIconWrapper>
                    <Input withIcon :id="'commission_reassurance' + [index]" type="text"
                        class="block w-full pl-2 part_accepte contientPercent"
                        v-model="form.reinsurer[index].commission_reassurance"
                        @focusout="checkingPercentage('commission_reassurance' + [index], '', 'percent')"
                        @focus="deleteCurrency('commission_reassurance' + [index], 'percent')" required autofocus />
                </InputIconWrapper>
            </div>

            <!-- Prime reception Affaire -->
            <div class="space-y-2">
                <Label :for="'prime_reassurance' + [index]" value="Prime reassureur" />
                <InputIconWrapper>
                    <Input withIcon :id="'prime_reassurance' + [index]" type="text"
                        class="block w-full pl-2 contient_monnaie" v-model="form.reinsurer[index].prime_reassurance"
                        @focusout="checkingPercentage('prime_reassurance' + [index], form.monnaie, 'currency');"
                        @focus="deleteCurrency('prime_reassurance' + [index], form.monnaie)" required autofocus />
                </InputIconWrapper>
            </div>

            <!-- Date reception Affaire -->
            <div class="space-y-2">
                <Label :for="'prime_reçu' + [index]" value="Prime à recevoir" />
                <InputIconWrapper>
                    <Input withIcon :id="'prime_reçu' + [index]" type="text" class="block w-full pl-2 contient_monnaie"
                        v-model="form.reinsurer[index].prime_a_reverser"
                        @focusout="checkingPercentage('prime_reçu' + [index], form.monnaie, 'currency')"
                        @focus="deleteCurrency('prime_reçu' + [index], form.monnaie)" required autofocus />
                </InputIconWrapper>
            </div>
            <!-- PPW -->
            <div class="space-y-2">
                <Label for="ppw" value="PPW" />
                <InputIconWrapper>
                    <Input withIcon id="ppw" type="number" class="block w-full pl-2" v-model="form.reinsurer[index].ppw"
                        required autofocus autocomplete="ppw" />
                </InputIconWrapper>
            </div>

            <!-- Date Accept -->
            <div class="space-y-2">
                <Label for="date_accept" value="Date acceptation" />
                <InputIconWrapper>
                    <Input withIcon id="date_accept" type="date" class="block w-full pl-2"
                        v-model="form.reinsurer[index].date_accept" required autofocus />
                </InputIconWrapper>
            </div>
        </div>
        <div class="flex">
            <button class="justify-end p-2 mt-4 text-white rounded-md bg-secondary" form="formulaireEdition">
                Enregistrer
            </button>
        </div>
    </form>
</template>
<script>

import AuthenticatedLayout from "@/Layouts/Authenticated.vue";

export default {
    layout: AuthenticatedLayout,
};
</script>
<script setup>
import vSelect from "vue-select";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { onMounted, ref, computed, onUpdated } from "vue";
import { useSwalSuccess, useSwalError } from "../../Composables/alert";
import utils from "@/Services/utils";
import useBusiness from "@/Services/useBusiness"

const props = defineProps({
    affaires: Object,
    reinsurer: Object,
    reas: Array,
    cedante: Array,
});
const branche = ref([]);
const cedante = ref([]);
const country = ref([]);
const ced = ref([]);
const form = useForm({ ...props.affaires, reinsurer: props.reinsurer });

const { calcul, changeCurrency, checkPercentage, checkPart, destroyCurrency, calculationPremium } = utils(form);
const getCurrency = (type) => { changeCurrency(type) };
const checkingPercentage = (values, type, model) => { checkPercentage(values, type, model) };
const checkingParts = (type) => { checkPart(type) }
const deleteCurrency = (value, type) => { destroyCurrency(value, type) };
const calculer = (index) => { calculationPremium(index) };

const updatedPercentOnLoad = () => {
    const list_champ_monnaie = document.querySelectorAll('[class*="contientPercent"]');
    let regex = /^[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)$/; //regex de verification
    for (let index = 0; index < list_champ_monnaie.length; index++) {
        if (!regex.test(list_champ_monnaie[index].value)) { }
        else { list_champ_monnaie[index].value += " %"; }
    }
}
const getTransferorFromCountry = computed(() => {
    let cedet = cedante.value;
    ced.value = cedet.filter(function (entry) { return entry.pays_id === form.pays_assure.id; });
    return ced.value;
});

onMounted(() => {
    axios
        .get(route("api.getBandC"))
        .then((response) => {
            branche.value = response.data.branche;
            cedante.value = response.data.cedante;
            country.value = response.data.pays;
        })
        .catch((error) => {
            console.log(error);
        });
});

onUpdated(() => { getCurrency(form.monnaie); updatedPercentOnLoad(); });
const { updateBusiness } = useBusiness();
const editBusiness = () => { updateBusiness(form); };

</script>