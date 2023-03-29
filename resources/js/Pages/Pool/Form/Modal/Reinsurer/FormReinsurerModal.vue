<template>
    <MyModal :closeable="true" :max-width="'5xl'" :show="show" @close="setIsOpened(false)">
        <template #content>
            <div class="fixed inset-0 p-4 overflow-y-auto">
                <div class="flex justify-between">
                    <h3 class="text-2xl font-bold">Validations des taux</h3>
                    <div class="flex gap-8 left">
                        <button
                            class="text-xl w-8 h-8 transition-all hover:bg-primary hover:rounded-[100%] hover:w-8 hover:h-8 p-[0.15rem] hover:p-[0.15rem] hover:text-white"
                            @click="setIsOpened(false)">
                            x
                        </button>
                    </div>
                </div>
                
                
                <form>
                    <hr class="mb-4"/>
                    <div class="">
                        <div v-if="currentStep>0"
                             class="grid grid-cols-[60%_20%_20%] w-full bg-primary text-white p-2 text-xl mb-2 rounded-t-md">
                            <h3 v-if="currentStep===1" class="">batiment</h3>
                            <h3 v-if="currentStep>1" class="">vehicule</h3>
                            <h3>Le taux minimum</h3>
                            <h3>Selectionner le taux</h3>
                        </div>
                        <!-- Composoant dynamique (affichage en fonction de step) -->
                        
                        <component
                            v-bind:is="formSteps[currentStep]"
                            v-bind:activities="activities"
                            v-bind:countries="countries"
                            v-bind:currentStep="currentStep"
                            v-bind:formValues="formValues"
                        ></component>
                    
                    
                    </div>
                    <div class="absolute top-1/2 left-1/2 z-50">
                        <spinner v-if="loader ||loading" class=""/>
                    </div>
                    
                    <div class="flex gap-3">
                        
                        <button
                            v-if="currentStep > 0 "
                            class="justify-end p-2 mt-4 text-white rounded-md bg-secondary"
                            v-on:click="previousStep()"
                        >
                            Revenir
                        </button>
                        
                        <button
                            v-if="currentStep === 0 ||currentStep>=0"
                            class="justify-end p-2 mt-4 text-white rounded-md bg-secondary"
                            v-on:click.prevent="nextStep();emitting()"
                        >
                            Valider
                        </button>
                        
                        <button
                            v-if="currentStep >1 "
                            class="justify-end p-2 mt-4 text-white rounded-md bg-secondary"
                            v-on:click.prevent="show=false"
                        >
                            Valider
                        </button>
                    </div>
                </form>
            </div>
        
        </template>
    </MyModal>
</template>

<script setup>

import MyModal from "@/Components/DialogModal.vue"
import {onMounted, onUpdated, ref, watch} from "vue";
import useActivityRates from "@/Services/API/useActivityRates";
import Spinner from "@/Shared/Spinner.vue";
import BatimentStep from "@/Pages/Pool/Form/Modal/Reinsurer/Steps/batimentStep.vue";
import VehiculeStep from "@/Pages/Pool/Form/Modal/Reinsurer/Steps/vehiculeStep.vue";
import CountryStep from "@/Pages/Pool/Form/Modal/Reinsurer/Steps/CountryStep.vue";


const emit = defineEmits(['toggle'])
const props = defineProps(['formValues', 'show', 'countries'])

const setIsOpened = (value) => {
    emit('toggle', value)
}
const loader = ref(false)
const {getActivitiesFromReinsurer, activities, loading} = useActivityRates()


const currentStep = ref(0);
const formSteps = [CountryStep, BatimentStep, VehiculeStep];
const nextStep = () => {
    currentStep.value++;
};
const previousStep = () => {
    currentStep.value--;
};
const emitting = () => {
    getActivitiesFromReinsurer(props.formValues.country)
}
onUpdated(() => {
    console.log('test')
    
})

watch(props.formValues.country, (newValue, oldValue) => {
    console.log('test');
})
</script>

<style scoped>

</style>