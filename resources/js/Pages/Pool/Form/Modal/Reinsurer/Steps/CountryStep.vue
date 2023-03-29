<template>
    
    <form>
        <div class="grid grid-cols-3 gap-4">
            <div class="space-y-2 ">
                <Label for="transferor" value="Cédante"/>
                <div class="flex flex-col text-xs">
                    <VueSelect v-model="formValues.country"
                               :options="countries"
                               label="label"
                               multiple>
                    </VueSelect>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import VueSelect from "vue-select";
import {watch} from "vue";

const props = defineProps(['countries', 'formValues'])

</script>

<style scoped>

</style>