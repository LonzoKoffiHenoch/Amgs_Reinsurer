<template>
    <div class="flex flex-col justify-center items-center  my-auto">
        <div
            class="border-2 my-8 rounded-t-xl pb-3 border-gray-300 shadow-xl bg-white dark:bg-dark-eval-1 dark:border-dark-eval-1 w-1/2">
            <h3 class="text-center text-3xl font-bold bg-primary text-white py-3 rounded-t-xl">Enregistrement d'une
                Convention</h3>
            
            <div class="flex px-8 flex-row items-center justify-center gap-12 mt-4">
                <label class="inline-flex items-center space-x-2">
                    <input v-model="radio" checked
                           class="form-radio is-outline h-5 w-5 rounded-md border-bg-primary before:bg-primary checked:border-bg-primary hover:border-bg-primary focus:border-bg-primary dark:border-navy-400 dark:before:bg-navy-200 dark:hover:border-navy-200 dark:focus:border-navy-200"
                           type="radio" value="cedante"/>
                    <p>Cédante</p>
                </label>
                <label class="inline-flex items-center space-x-2">
                    <input v-model="radio"
                           class="form-radio is-outline h-5 w-5 rounded-md border-slate-400/70 before:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:before:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                           type="radio" value="reassureur"/>
                    <p>Réassureur</p>
                </label>
            </div>
            
            <div class="dark:bg-dark-eval-1 p-8">
                <transition-group enter-active-class="transition-all duration-1000 "
                                  enter-from-class="opacity-0 translate-x-20"
                                  enter-to-class="opacity-2 translate-x-0"
                                  leave-active-class="" name="form">
                    <CreatePoolTransferor v-if="showFormTransferor" :countries="countries"
                                          :formValues="form" :transferors="transferors"/>
                    
                    
                    <CreatePoolReinsurer v-if="showFormReas" :countries="countries" :formReinsurer="formReas"
                                         :reinsurers="props.reinsurers"/>
                    
                    <div class="flex">
                        <button class="justify-end p-2 mt-4 text-white rounded-md bg-secondary"
                                @click.prevent="sendForm()">
                            Enregistrer
                        </button>
                    </div>
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
import {useForm} from "@inertiajs/inertia-vue3";
import {ref, watch} from "vue";
import {useSwalError, useSwalSuccess} from "@/Composables/alert";
import CreatePoolTransferor from "@/Pages/Pool/Form/CreatePoolTransferor.vue";
import CreatePoolReinsurer from "@/Pages/Pool/Form/CreatePoolReinsurer.vue";

const props = defineProps({
    reinsurers: Object,
    transferors: Object,
    countries: Object,
})
const country = ref({
    id: "",
    label: "",
})

const radio = ref("cedante");
const showFormTransferor = ref(true);
const showFormReas = ref(false);
const activity = ref([]);
const cedante = ref([]);
const form = useForm({
    country: {},
    date_effet: null,
    date_echeance: null,
    transferor: "",
    validate: [],
    activity_rates: [],
})

const formReas = useForm({
    type: "",
    activity: "",
    taux: null,
    date_effet: null,
    date_echeance: null,
    reinsurers: [{
        capial: '',
    }
    ],
    country: [],
    activity_rates: [],
    validate: [
        [],
    ],
})

watch(radio, (newValue, oldValue) => {
    if (radio.value === 'reassureur') {
        showFormTransferor.value = false
        showFormReas.value = true
    } else {
        showFormTransferor.value = true
        showFormReas.value = false
    }
})
const sendForm = () => {
    if (radio.value === 'cedante') storePool()
    if (radio.value === 'reassureur') storePoolReinsurer()
}
const storePool = () => {
    form.post(route('pool.store'), {
        onSuccess: (page) => {
            useSwalSuccess("La convention a été ajouté avec succès!");
            form.reset();
            showFormTransferor.value = true
            showFormReas.value = false
            radio.value === 'cedante'
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
            form.reset();
            radio.value === 'cedante'
            showFormTransferor.value = true
            showFormReas.value = false
            
        },
        
        onError: (errors) => {
            useSwalError("Une erreur s'est produite.");
        }
    });
}

</script>
