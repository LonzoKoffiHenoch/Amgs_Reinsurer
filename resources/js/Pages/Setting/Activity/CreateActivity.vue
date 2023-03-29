<template>
    <Authenticated>
        <div class="flex flex-row min-h-screen justify-center items-start">
            <div
                class="border-2 my-8 rounded-t-xl pb-3 border-gray-300 shadow-xl bg-white dark:bg-dark-eval-1 dark:border-dark-eval-1 w-1/2">
                <h3 class="text-center text-3xl font-bold bg-primary text-white py-3 rounded-t-xl">Enregistrement d'un
                    taux
                    d'activité</h3>
                <form class=" bg-white mt-2 p-6 dark:bg-dark-eval-1" @submit.prevent="storeActivity()">
                    
                    
                    <div class="grid grid-cols-3 gap-4">
                        <!-- Type -->
                        <div class="w-full space-y-2">
                            <Label for="Type" value="Choisir le type d'activité"/>
                            <select id="monnaie" v-model="form.type"
                                    class="w-full text-center border-gray-600 rounded-md"
                                    name="activity"
                                    @change="getActivityFromType"
                            >
                                <option :selected="true" value="vehicule">Véhicule</option>
                                <option value="batiment">Batiment</option>
                            </select>
                        </div>
                        <div class="w-full space-y-2">
                            <Label for="Type" value="Choisir le type d'activité"/>
                            <VueSelect v-model="form.activity" :options="activity"
                                       class="text-[0.90rem]"
                                       label="label"
                            >
                            </VueSelect>
                        </div>
                        
                        <div class="w-full space-y-2">
                            <Label for="price" value="Entrez le taux"/>
                            <InputIconWrapper>
                                <template #icon>
                                    <!-- <UserIcon aria-hidden="true" class="w-5 h-5" /> -->
                                </template>
                                <Input id="price" v-model="form.price" autofocus
                                       class="w-full text-center border-gray-600 rounded-md"
                                       placeholder="Entrez le taux"
                                       required type="text" withIcon/>
                            </InputIconWrapper>
                        </div>
                        
                        
                        <div class="w-full space-y-2">
                            <Label for="price" value="Entrez le pays"/>
                            <VueSelect v-model="form.pays" :options="props.countries"
                                       :value="props.countries.id"
                                       class="text-[0.90rem]"
                                       label="label"
                                       track-by="label"
                                       @option:selected="getTransferorFromCountry"
                            >
                            </VueSelect>
                        </div>
                        
                        <div class="w-full space-y-2 col-span-2">
                            <Label for="price" value="Entrez la cédante"/>
                            <VueSelect v-model="form.transferor" :options="getTransferorFromCountry"
                                       class="text-[0.90rem] "
                                       label="raison_social"
                                       multiple>
                            </VueSelect>
                        </div>
                    
                    </div>
                    
                    
                    <div class="flex">
                        <button class="justify-end p-2 mt-4 text-white rounded-md bg-secondary">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        
        </div>
    </Authenticated>
</template>

<script setup>
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import Authenticated from "@/Layouts/Authenticated.vue";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import VueSelect from "vue-select";
import {computed, ref, toRefs, watch} from "vue";
import {useSwalError, useSwalSuccess} from "@/Composables/alert";

const country = ref({
    id: "",
    label: "",
})
const props = defineProps({
    data: Object,
    transferors: Object,
    countries: Object,
})
const {transferors} = toRefs(props)
const activity = ref([]);
const cedante = ref([]);
const form = useForm({
    type: "",
    activity: "",
    price: null,
    pays: {},
    transferor: []
})

const getActivityFromType = () => {
    activity.value = props.data[form.type];
    form.pays = country.value.id
    
}

const getTransferorFromCountry = computed(() => {
    return transferors.value.filter(function (entry) {
        return entry.pays_id === form.pays.id;
    });
});

const storeActivity = () => {
    form.post(route('activity.store'), {
        onSuccess: (page) => {
            useSwalSuccess("Taux ajouté avec succès!");
            form.reset();
        },
        onError: (errors) => {
            useSwalError("Une erreur s'est produite.");
        }
    });
}

</script>
