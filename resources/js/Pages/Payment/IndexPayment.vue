<template>
    <div class="absolute top-1/2 left-1/2">
        <spinner v-if="loader" class=""></spinner>
    </div>
    <div>
        <!-- changer le nom de la fonction getSavePay() -->
        <Button
            v-if="$page.props.auth.permissions.includes('finance:show')"
            class="justify-center gap-2 mt-4 text-center"
            @click.prevent="getTransferorNotPay()"
        >
            <span>Enregistrer paiement</span>
        </Button>
        <Button
            v-if="$page.props.auth.permissions.includes('finance:edit')"
            class="justify-center gap-2 mt-4 ml-4 text-center"
            @click.prevent="getReinsurerNotPay(), showing()"
        >
            <span>Enregistrer reversement</span>
        </Button>
        <!-- Tableau des cedantes qui on au moins une ou plusieurs affaire non payé -->
        <div v-if="show">
            <table-transferor :cedante="cedante" :showreas="showreas" @recharge="recharge()"/>
            <v-pagination
                v-model="currentPage"
                :pages="pageCountTransferor"
                :range-size="1"
                active-color="#be1d2e"
                @update:modelValue="getSavePay()"
            />
        </div>
        
        <div v-if="showre">
            <table-reinsurer :reas="reas" :showreas="showced" @recharge="recharge"/>
            <v-pagination
                v-model="currentPageReinsurer"
                :pages="pageCountReinsurer"
                :range-size="1"
                active-color="#be1d2e"
                @update:modelValue="getReinsurerNotPay()"
            />
        </div>
    </div>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";

export default {
    layout: AuthenticatedLayout,
};
</script>
<script setup>
import {reactive, ref} from "vue";
import Button from "@/Components/Button.vue";
import TableTransferor from "./TableTransferor.vue";
import TableReinsurer from "./TableReinsurer.vue";
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import Spinner from "@/Shared/Spinner.vue";

const showreas = reactive([]);
const showced = reactive([]);
const show = ref(false);
const showre = ref(false);
const cedante = ref([]);
const reas = ref({});
const currentPage = ref(1);
const currentPageReinsurer = ref(1);
const pageCountTransferor = ref(null);
const pageCountReinsurer = ref(null);
const loader = ref(false)
const props = defineProps({
    cedente: Object,
});
const showing = () => {
    show.value = false;
    showre.value = !showre.value;
};
const shower = () => {
    showre.value = false;
    show.value = !show.value;
};

const getSavePay = async () => {
    loader.value = true
    await axios
        .get(route("api.reas", {page: currentPage.value}))
        .then((response) => {
            loader.value = false
            cedante.value = [];
            pageCountTransferor.value = null;
            cedante.value.push(...response.data.data);
            pageCountTransferor.value = response.data.meta.total / 5;
            
            for (let index = 0; index < cedante.value.length; index++) {
                showreas.push(false);
            }
        })
        .catch((error) => {
            console.log(error);
        });
};
const getTransferorNotPay = () => {
    if (show.value === false) {
        getSavePay();
        shower();
    } else {
        shower();
        cedante.value = [];
    }
};
const recharge = () => {
    if (show.value === true) {
        getSavePay();
    }
    if (showre.value === true) {
        getReinsurerNotPay();
    }
};

const getReinsurerNotPay = () => {
    loader.value = true
    axios
        .get(route("api.reasbus"))
        .then((response) => {
            loader.value = false
            reas.value = response.data.reas;
            for (let index = 0; index < reas.value.length; index++) {
                showced.push(false);
            }
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>
<style>
.Page-active {
    color: white !important;
}

.Pagination {
    width: auto !important;
}
</style>
