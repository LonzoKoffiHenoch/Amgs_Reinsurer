<template>
    <div class="flex flex-col justify-center items-center  my-auto">
        <div
            class="border-2 my-8 rounded-t-xl pb-3 border-gray-300 shadow-xl bg-white dark:bg-dark-eval-1 dark:border-dark-eval-1 w-1/2">
            <h3 class="text-center text-3xl font-bold bg-primary text-white py-3 rounded-t-xl">Enregistrement d'une
                Convention</h3>
            
            <div class="flex px-8 flex-row items-center justify-center gap-12 mt-4">
                <label class="inline-flex items-center space-x-2">
                    <input
                        v-model="radio"
                        checked
                        class="form-radio is-outline h-5 w-5 rounded-md border-bg-primary before:bg-primary checked:border-bg-primary hover:border-bg-primary focus:border-bg-primary dark:border-navy-400 dark:before:bg-navy-200 dark:hover:border-navy-200 dark:focus:border-navy-200"
                        type="radio"
                        value="cedante"
                    />
                    <p>Cédante</p>
                </label>
                <label class="inline-flex items-center space-x-2">
                    <input
                        v-model="radio"
                        class="form-radio is-outline h-5 w-5 rounded-md border-slate-400/70 before:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:before:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                        type="radio"
                        value="reassureur"
                    />
                    <p>Réassureur</p>
                </label>
            </div>
            
            <div class="dark:bg-dark-eval-1 p-8">
                <transition-group enter-active-class="transition-all duration-1000 "
                                  enter-from-class="opacity-0 translate-x-20"
                                  enter-to-class="opacity-2 translate-x-0"
                                  leave-active-class="" name="form">
                    <form v-if="showFormTransferor" class=" bg-white"
                          @submit.prevent="storePool()">
                        
                        
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Type -->
                            
                            <div class="space-y-2">
                                <Label for="taux" value="Entrez le taux"/>
                                <InputIconWrapper>
                                    <template #icon>
                                        <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                    </template>
                                    <Input id="taux" v-model="form.taux" autocomplete="taux" autofocus
                                           class="block w-full lg:placeholder:text-sm" placeholder="Saisissez le taux"
                                           required type="text"
                                           withIcon/>
                                </InputIconWrapper>
                            </div>
                            <div class="space-y-2">
                                <Label for="capacity" value="Entrez la capacité"/>
                                <InputIconWrapper>
                                    <template #icon>
                                        <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                    </template>
                                    <Input id="capacity" v-model="form.total_capacity" autocomplete="capacity" autofocus
                                           class="block w-full lg:placeholder:text-sm"
                                           placeholder="Saisissez la capacité" required type="text"
                                           withIcon/>
                                </InputIconWrapper>
                            </div>
                            
                            <div class="space-y-2 ">
                                <Label for="taux" value="Entrez le taux"/>
                                <select id="activity" v-model="form.activity" class="rounded-md w-full text-center"
                                        name="activity">
                                    <option value="batiment">Batiment</option>
                                    <option value="vehicule">Vehicule</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="date_effet" value="Entrez la d'effet"/>
                                <Input id="date_effet" v-model="form.date_effet" autocomplete="date_effet" autofocus
                                       class="block w-full lg:placeholder:text-sm" placeholder="Nom de la date d'effet"
                                       required type="date"
                                       withIcon/>
                            </div>
                            <div class="space-y-2">
                                <Label for="date_echeance" value="Entrez la date d'echeance"/>
                                <Input id="date_echeance" v-model="form.date_echeance" autocomplete="date_echeance"
                                       autofocus
                                       class="block w-full lg:placeholder:text-sm"
                                       placeholder="Nom de la date d'écheance" required type="date"
                                       withIcon/>
                            </div>
                            <div class="space-y-2 ">
                                <Label for="transferor" value="Cédante"/>
                                <div class="flex flex-col text-xs">
                                    <VueSelect v-model="form.transferor"
                                               :options="props.transferors"
                                               label="raison_social">
                                    </VueSelect>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="flex">
                            <button class="justify-end p-2 mt-4 text-white rounded-md bg-secondary">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                    <form v-if="showFormReas" class=" bg-white"
                          @submit.prevent="storePoolReas()">
                        
                        
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Type -->
                            
                            <div class="space-y-2">
                                <Label for="taux" value="Entrez le taux"/>
                                <InputIconWrapper>
                                    <template #icon>
                                        <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                    </template>
                                    <Input id="taux" v-model="formReas.taux" autocomplete="taux" autofocus
                                           class="block w-full lg:placeholder:text-sm" placeholder="Saisissez le taux"
                                           required type="text"
                                           withIcon/>
                                </InputIconWrapper>
                            </div>
                            <div class="space-y-2">
                                <Label for="capacity" value="Entrez la capacité"/>
                                <InputIconWrapper>
                                    <template #icon>
                                        <UserIcon aria-hidden="true" class="w-5 h-5"/>
                                    </template>
                                    <Input id="capacity" v-model="formReas.total_capacity" autocomplete="capacity"
                                           autofocus
                                           class="block w-full lg:placeholder:text-sm"
                                           placeholder="Saisissez la capacité" required type="text"
                                           withIcon/>
                                </InputIconWrapper>
                            </div>
                            
                            <div class="space-y-2 ">
                                <Label for="taux" value="Entrez le taux"/>
                                <select id="activity" v-model="formReas.activity" class="rounded-md w-full text-center"
                                        name="activity">
                                    <option value="batiment">Batiment</option>
                                    <option value="vehicule">Vehicule</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <Label for="date_effet" value="Entrez la d'effet"/>
                                <Input id="date_effet" v-model="formReas.date_effet" autocomplete="date_effet" autofocus
                                       class="block w-full lg:placeholder:text-sm" placeholder="Nom de la date d'effet"
                                       required type="date"
                                       withIcon/>
                            </div>
                            <div class="space-y-2">
                                <Label for="date_echeance" value="Entrez la date d'echeance"/>
                                <Input id="date_echeance" v-model="formReas.date_echeance" autocomplete="date_echeance"
                                       autofocus
                                       class="block w-full lg:placeholder:text-sm"
                                       placeholder="Nom de la date d'écheance" required type="date"
                                       withIcon/>
                            </div>
                            <div class="space-y-2 mt-1">
                                <button class="bg-primary text-white p-2 rounded-md mt-4"
                                        @click.prevent="addReinsurer()">
                                    Ajouter un
                                    reassureur
                                </button>
                            </div>
                        
                        </div>
                        
                        <hr class="mt-3"/>
                        <transition-group enter-active-class="transition-all duration-1000 "
                                          enter-from-class="opacity-0 translate-x-20"
                                          enter-to-class="opacity-2 translate-x-0"
                                          leave-active-class="transition-all duration-1000"
                                          leave-from-class="opacity-1 translate-x-0"
                                          leave-to-class="opacity-0 translate-x-0"
                        >
                            <div v-for="(reas,index) in formReas.reinsurers" v-if="formReas.reinsurers" class="mt-3">
                                
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <h2>Reinsurer {{ index + 1 }}:</h2>
                                        <span
                                            class="bg-primary rounded-md px-[0.4rem] text-white hover:bg-secondary cursor-pointer"
                                            @click.prevent="RemoveReinsurer()">x</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2 ">
                                            <Label for="Réassureur" value="Réassureur"/>
                                            <div class="flex flex-col text-sm">
                                                <VueSelect v-model="formReas.reinsurers[index].reinsurer"
                                                           :options="props.reinsurers"
                                                           label="raison_social"
                                                           value="id"
                                                >
                                                </VueSelect>
                                            </div>
                                        </div>
                                        <div>
                                            <Label for="date_echeance" value="Entrez la part"/>
                                            <Input id="date_echeance" v-model="formReas.reinsurers[index].part"
                                                   autocomplete="date_echeance"
                                                   autofocus
                                                   class="block w-full mt-1" placeholder="Entrez la part"
                                                   required
                                                   type="text"
                                                   withIcon/>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="mt-4">
                            </div>
                        </transition-group>
                        
                        <div class="flex ">
                            <button class="justify-end p-2 mt-4 text-white rounded-md bg-secondary"
                                    @click.prevent="storePoolReinsurer()">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </transition-group>
            
            </div>
        </div>
    </div>

</template>
<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";

export default {layout: AuthenticatedLayout,};
</script>
<script setup>
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";

import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import VueSelect from "vue-select";
import {computed, reactive, ref, watch} from "vue";
import {useSwalError, useSwalSuccess} from "@/Composables/alert";
import BadgeAccountIcon from "vue-material-design-icons/BadgeAccount.vue";

const props = defineProps({
    reinsurers: Object,
    transferors: Object,
    countries: Object,
})
const country = ref({
    id: "",
    label: "",
})

const radio = ref("");
const showFormTransferor = ref(true);
const showFormReas = ref(false);
const activity = ref([]);
const cedante = ref([]);
const form = useForm({
    taux: "",
    total_capacity: "",
    activity: "",
    date_effet: null,
    date_echeance: null,
    transferor: ""
})

const formReas = useForm({
    type: "",
    activity: "",
    taux: null,
    date_effet: null,
    date_echeance: null,
    reinsurers: [{
        part: '',
        
    }
    ]
})

/*
const getActivityFromType = () => {
    activity.value = props.data[form.type];
    form.pays = country.value.id
    
}

const getTransferorFromCountry = computed(() => {
    return props.transferors.filter(function (entry) {
        return entry.pays_id === form.pays.id;
    });
});
*/
const addReinsurer = () => {
    formReas.reinsurers.push({})
}
const RemoveReinsurer = () => {
    formReas.reinsurers.pop()
}
watch(radio, (newValue, oldValue) => {
    if (radio.value === 'reassureur') {
        showFormTransferor.value = false
        showFormReas.value = true
    } else {
        showFormTransferor.value = true
        showFormReas.value = false
    }
})

const storePool = () => {
    form.post(route('pool.store'), {
        onSuccess: (page) => {
            useSwalSuccess("La convention a été ajouté avec succès!");
            form.reset();
        },
        onError: (errors) => {
            useSwalError("Une erreur s'est produite.");
        }
    });
}

const storePoolReinsurer = () => {
    formReas.post(route('pool.storereas'), {
        onSuccess: (page) => {
            useSwalSuccess("La convention a été ajouté avec succès!");
            formReas.reset();
        },
        onError: (errors) => {
            useSwalError("Une erreur s'est produite.");
        }
    });
}

</script>
