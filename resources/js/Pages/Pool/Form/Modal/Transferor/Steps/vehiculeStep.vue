<template>
    <div class="mt-3">
        <template v-for="(activity,index) in activities">
            <div v-if="activity.type!== 'batiment'" class="grid grid-cols-[60%_20%_20%] gap-2 my-3 px-2">
                
                
                <h3 class="text-xl">{{ activity.activity }}</h3>
                <h3 class="text-xl font-bold">{{ formatAsPercentage(activity.price * 1.5) }}</h3>
                <div class="space-y-2">
                    
                    <Input :id="activity.id" v-model="formValues.validate[index]"
                           autocomplete="decimal"
                           class=" lg:placeholder:text-sm" placeholder="Entrez le taux"
                           required type="text"
                           @focusout="checkPrice(activity.id,index)"/>
                </div>
            
            
            </div>
            <hr v-if="activity.type!== 'batiment'">
        </template>
    </div>
</template>

<script setup>
import {useSwalConfirm} from "@/Composables/alert";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import utils from "@/Services/utils";

const props = defineProps(['activities', 'formValues'])
const checkPrice = (id, index) => {
    props.formValues.activity_rates[index] = props.activities[index].id
    if (props.formValues.validate[index] < props.activities[index].price) {
        useSwalConfirm('Le taux saisi est inferieur au taux normal', 'Oui, continuer.', 'Non, fermer.', () => {
            document.getElementById(id).focus()
        })
    }
}
const {formatAsPercentage} = utils(props.formValues)
</script>

<style scoped>

</style>