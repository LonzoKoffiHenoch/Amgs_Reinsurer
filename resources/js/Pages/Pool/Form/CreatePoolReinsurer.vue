<template>
    <form class=" bg-white">
        <div class="grid grid-cols-3 gap-4">
            <!-- Type -->
            
            
            <div class="space-y-2">
                <Label for="date_effet" value="Entrez la d'effet"/>
                <Input id="date_effet" v-model="props.formReinsurer.date_effet" autocomplete="date_effet" autofocus
                       class="block w-full lg:placeholder:text-sm" placeholder="Nom de la date d'effet"
                       required type="date"
                       withIcon/>
            </div>
            <div class="space-y-2">
                <Label for="date_echeance" value="Entrez la date d'echeance"/>
                <Input id="date_echeance" v-model="props.formReinsurer.date_echeance" autocomplete="date_echeance"
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
                          enter-from-class="opacity-0 translate-x-30"
                          enter-to-class="opacity-2 translate-x-0"
                          leave-active-class="transition-all duration-1000"
                          leave-from-class="opacity-1 translate-x-0"
                          leave-to-class="opacity-0 translate-x-0"
        >
            <div v-for="(reas,index) in formReinsurer.reinsurers"
                 class="mt-3">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        
                        <span
                            class="bg-primary rounded-md px-[0.4rem] text-white hover:bg-secondary cursor-pointer"
                            @click.prevent="RemoveReinsurer()">x</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2 ">
                            <Label for="Réassureur" value="Réassureur"/>
                            <div class="flex flex-col text-sm">
                                <VueSelect v-model="formReinsurer.reinsurers[index].reinsurer"
                                           :options="props.reinsurers"
                                           label="raison_social"
                                           value="id"
                                >
                                </VueSelect>
                            </div>
                        </div>
                        <div>
                            <Label for="date_echeance" value="Entrez le capital"/>
                            <Input id="date_echeance" v-model="formReinsurer.reinsurers[index].part"
                                   autocomplete="date_echeance"
                                   autofocus
                                   class="block w-full mt-1" placeholder="Entrez le capital"
                                   required
                                   type="text"
                                   withIcon/>
                        </div>
                    </div>
                </div>
                <hr class="mt-4">
            </div>
        
        
        </transition-group>
        <div class="flex">
            <button class="w-full justify-end p-2 mt-4 text-white rounded-md bg-primary"
                    @click.prevent="validateTaux()">
                Valider les taux
            </button>
        </div>
        <FormReinsurerModal :countries="countries" :formValues="formReinsurer" :show="showModalFormTransferorModal"
                            @toggle="(value)=>showModalFormTransferorModal=value"/>
    
    </form>


</template>

<script setup>
import VueSelect from "vue-select";
import Label from "@/Components/Label.vue";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import Input from "@/Components/Input.vue";
import {useSwalError} from "@/Composables/alert";
import FormReinsurerModal from "@/Pages/Pool/Form/Modal/Reinsurer/FormReinsurerModal.vue";
import {ref} from "vue";

const props = defineProps(['formReinsurer', 'reinsurers', "countries"])
const showModalFormTransferorModal = ref(false)
const addReinsurer = () => {
    props.formReinsurer.reinsurers.push({})
}
const RemoveReinsurer = () => {
    props.formReinsurer.reinsurers.pop()
}

const validateTaux = () => {
    showModalFormTransferorModal.value = true
}
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
</script>

<style scoped>

</style>