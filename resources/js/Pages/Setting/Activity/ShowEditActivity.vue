<template>
    <MyModal :closeable="true" :max-height="'h-[60%]'" :max-width="'4xl'" :show="props.show"
             @close="setIsOpened(false)">
        <template #content>
            <div class="fixed inset-0 p-4 overflow-y-auto">
                <div class="flex justify-between">
                    <h3 class="text-2xl font-bold">Enregistrer une affaire</h3>
                    <div class="flex gap-8 left">
                        <button
                            class="text-xl w-8 h-8 transition-all hover:bg-primary hover:rounded-[100%] hover:w-8 hover:h-8 p-[0.15rem] hover:p-[0.15rem] hover:text-white"
                            @click="setIsOpened(false)">
                            x
                        </button>
                    </div>
                </div>
                <form @submit.prevent="storeActivity()">
                    <hr class="mb-4"/>
                    
                    <h3 class="text-center text-2xl font-bold">{{ props.activity.activity }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Type -->
                        <div class="w-full space-y-2">
                            <Label for="Type" value="Choisir le type d'activité"/>
                            <select id="monnaie" v-model="form.type"
                                    class="w-full text-center border-gray-600 rounded-md"
                                    name="activity"
                            >
                                <option :selected="true" value="vehicule">Véhicule</option>
                                <option value="batiment">Batiment</option>
                            </select>
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
                    
                    </div>
                    <div class="flex">
                        <button class="justify-end p-2 mt-4 text-white rounded-md bg-secondary"
                        >
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </template>
    </MyModal>
</template>

<script setup>
import MyModal from "@/Components/DialogModal.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import VueSelect from "vue-select";
import {useForm} from "@inertiajs/inertia-vue3";
import {onMounted, ref} from "vue";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";

const props = defineProps({
    activity: Object,
    show: {type: Boolean, default: false,},
    closeable: {type: Boolean, default: true,},
})
const activity = ref([]);
const form = useForm({
    activity: props.activity.activity,
    type: props.activity.type,
    price: props.activity.price,
})
const emit = defineEmits(["toggle", "closer"]);


function setIsOpened(value) {
    emit("toggle", value);
}

function setIsCloser(value) {
    emit("closer", value);
}

onMounted(() => {
    console.log(props.activity)
})
</script>
