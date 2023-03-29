<template>
    <div class="mt-3">
        <template v-for="(activity,index) in activities">
            <div v-if="activity.type!== 'vehicule'" class="grid grid-cols-[60%_20%_20%] w-full gap-2  px-2 my-2">
                <h3 class="text-xl">{{ activity.activity }}</h3>
                <h3 class="text-xl font-bold tex-center">{{ formatAsPercentage(activity.price * 1.5) }}</h3>
                
                <div class="">
                    <!--                    <Label for="date_effet" value="Entrez le taux"/>-->
                    <Input :id="activity.id" v-model="formValues.validate[index]"
                           autocomplete="date_effet"
                           class=" lg:placeholder:text-sm "
                           placeholder="Entrez le taux" required
                           type="text"
                    
                           @focusout="checkPrice(activity.id,index)"/>
                </div>
            
            
            </div>
            <hr>
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
    if (props.formValues.validate[index] < (props.activities[index].price * 1.5)) {
        useSwalConfirm('Le taux saisi est inferieur au taux normal', 'Oui, continuer.', 'Non, fermer.', (confirmDialogReturn, cancelCallback) => {
                document.getElementById(id).focus()
            }
        )
    }
}
const {formatAsPercentage} = utils(props.formValues)
</script>

<style scoped>

</style>