<template>
    
    
    <CreateBusinesseModal :cedante="props.transferors" :pays="props.pays" :reinsurer="props.reinsurer"
                          :show-businesse-modal="show" @showreins="showReinsurerMoadl()" @toggle="closeModal()">
        <template #button>
        
        </template>
    </CreateBusinesseModal>


</template>
<script></script>
<script setup>
import VueSelect from "vue-select";
import MyModal from "@/Components/DialogModal.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import {computed, onMounted, ref} from "vue";
import {UserIcon} from "@heroicons/vue/outline";
import usingForm from "@/Composables/form.js";
import utils from "@/Services/utils";
import useBranche from "@/Services/API/useBranche";
import useBusiness from "@/Services/useBusiness";
import CreateBusinesseModal from "@/Pages/Business/Modals/CreateBusinesseModal.vue";

const props = defineProps(['show', 'reinsurer', 'pays', 'transferors']);

const country = ref([]);

const emit = defineEmits(["toggle", "closer", "showreins"]);

const showReinsurerMoadl = () => {
    showrein.value = true
}

function setIsOpened(value) {
    emit("toggle", value);
}

const closeModal = () => {
    emit('toggle', false)
}

function setIsCloser(value) {
    emit("closer", value);
}

const {branche, getBranche} = useBranche();

onMounted(() => {
    country.value = JSON.parse(props.pays);
    getBranche();
});

/*const {calcul, changeCurrency, checkPercentage, checkPart, destroyCurrency, calculationPremium} = utils(form);*/
/*const getCurrency = (type) => {
    changeCurrency(type)
};
const checkingPercentage = (values, type, model) => {
    checkPercentage(values, type, model);
};
const checkingParts = (type) => {
    checkPart(type);
};
const deleteCurrency = (value, type) => {
    destroyCurrency(value, type);
};
const calculer = (index) => {
    calculationPremium(index);
};*/

const getTransferorFromCountry = computed(() => {
    return JSON.parse(props.cedante).filter(function (entry) {
        console.log(entry);
        return entry.pays_id === form.pays_assure.id;
    });
});
const changing = () => {
    if (document.getElementsByClassName("vs__selected")[1]) {
        form.transferors_id = "";
    }
};

const {createBusiness} = useBusiness();
const storeBusiness = () => {
    createBusiness(form);
    setIsOpened(false);
};
</script>
