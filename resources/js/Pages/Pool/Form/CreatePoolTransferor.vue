<template>
    <form class=" bg-white">
        
        <div class="grid grid-cols-2 gap-4">
            <!-- Le choix du pays -->
            <div class="space-y-2 ">
                <Label for="countries" value="Pays"/>
                <div class="flex flex-col text-xs">
                    <VueSelect v-model="formValues.country"
                               :options="props.countries"
                               label="label" @option:selected="getTransferorsFromCountry">
                    </VueSelect>
                </div>
            </div>
            
            <!-- Affichage des cedante en fonction du pays -->
            <div class="space-y-2 ">
                <Label for="transferor" value="Cédante"/>
                <div class="flex flex-col text-xs">
                    <VueSelect v-model="formValues.transferor"
                               :options="getTransferorsFromCountry"
                               label="raison_social">
                    </VueSelect>
                </div>
            </div>
            
            
            <div class="space-y-2">
                <Label for="date_effet" value="Entrez la d'effet"/>
                <Input id="date_effet" v-model="formValues.date_effet" autocomplete="date_effet" autofocus
                       class="block w-full lg:placeholder:text-sm" placeholder="Nom de la date d'effet"
                       required type="date"
                       withIcon/>
            </div>
            <div class="space-y-2">
                <Label for="date_echeance" value="Entrez la date d'echeance"/>
                <Input id="date_echeance" v-model="formValues.date_echeance" autocomplete="date_echeance"
                       autofocus
                       class="block w-full lg:placeholder:text-sm"
                       placeholder="Nom de la date d'écheance" required type="date"
                       withIcon/>
            </div>
        
        </div>
        
        <div class="flex">
            <button class="w-full justify-end p-2 mt-4 text-white rounded-md bg-primary"
                    @click.prevent="validateTaux()">
                Valider les taux
            </button>
        </div>
        
        <FormTransferorModal v-if="showModalFormTransferorModal" :formValues="formValues"
                             :show="showModalFormTransferorModal"
                             @toggle="(value)=>showModalFormTransferorModal=value"/>
    
    
    </form>
</template>

<script setup>
import VueSelect from "vue-select";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import {useSwalError} from "@/Composables/alert";
import {computed, onMounted, ref, toRefs} from "vue";
import FormTransferorModal from "@/Pages/Pool/Form/Modal/Transferor/FormTransferorModal.vue";

const props = defineProps(['formValues', 'transferors', 'countries'])
const {transferors} = toRefs(props)
const showModalFormTransferorModal = ref(false)
const validateTaux = () => {
    if (props.formValues.transferor === "") useSwalError('veuillez choisir la cedante');
    else {
        showModalFormTransferorModal.value = true
    }
}

const getTransferorsFromCountry = computed(() => {
    props.formValues.transferor = {};
    return transferors.value.filter(function (entry) {
        return entry.pays_id === props.formValues.country.id;
    });
    
});
</script>

<style scoped>

</style>