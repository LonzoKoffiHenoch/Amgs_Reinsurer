<template>
    <div class="absolute top-1/2 left-1/2 z-50">
        <spinner v-if="loader || loading" class=""></spinner>
    </div>
    <div>
        
        <div class="flex justify-between gap-4">
            <div class="">
                <Button v-if="$page.props.auth.permissions.includes('businesse:create')"
                        class="justify-center gap-2 mt-4 text-center" @click.prevent="show = true">
                    <span>Enregistrer une affaire</span>
                </Button>
                
                <Button v-if="$page.props.auth.permissions.includes('businesse:create')"
                        class="justify-center gap-2 mt-4 ml-4 text-center" @click.prevent="shower = true">
                    <span>Créer une affaire</span>
                </Button>
                
                <Button v-if="$page.props.auth.permissions.includes('businesse:upload')"
                        :href="route('business.upload')" class="ml-4 focus:ring-primary">
                    <span class="text-white">Upload des affaires</span>
                </Button>
            
            
            </div>
            
            <div class="self-end space-x-3">
                <select v-model="per_page" class="text-sm form-control rounded-xl dark:bg-dark-eval-1" @change="search">
                    <option disabled selected>par page</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <input v-model="searchBusinesse"
                       class="self-end my-2 mb-0 text-sm rounded-xl focus:border-gray-400 focus:ring focus:ring-primary focus:ring-offset-2 focus:ring-offset-white dark:text-white dark:border-gray-400 dark:bg-gray-500 placeholder:text-gray-500 dark:placeholder:text-gray-100"
                       placeholder="Rechercher une affaire"
                       type="text"
                       @keyup="search"/>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex flex-col">
                <div class="relative h-screen overflow-x-auto border-b border-gray-200 shadow ">
                    <table id="dataTable" class="relative w-full divide-gray-300 dark:bg-dark-eval-1">
                        <thead class="sticky top-0 z-20 bg-primary">
                        <tr>
                            <th class="text-[0.1rem] w-[20px] sticky left-0 bg-primary"></th>
                            <th class="sticky left-0 px-6 py-2 text-xs text-white bg-primary text-start">Assuré</th>
                            <th class="px-6 py-2 text-xs text-white whitespace-nowrap">Date de reception</th>
                            <th class="px-6 py-2 text-xs text-white">Cédante</th>
                            <th class="px-6 py-2 text-xs text-white">Date d'effet</th>
                            <th class="px-6 py-2 text-xs text-white">Date d'écheance</th>
                            <th class="px-6 py-2 text-xs text-white">Monnaie</th>
                            <th class="px-6 py-2 text-xs text-white">Prime à 100%</th>
                            <th class="px-6 py-2 text-xs text-white">Part offerte</th>
                            <th class="px-6 py-2 text-xs text-white">Prime de réassurance</th>
                            <th class="px-6 py-2 text-xs text-white">Commission cédante</th>
                            <th class="px-6 py-2 text-xs text-white">Prime cédée</th>
                            <th class="px-6 py-2 text-xs text-white">Prime à recevoir</th>
                            <th class="px-6 py-2 text-xs text-white">Prime à reverser</th>
                            <th v-if="$page.props.auth.permissions.includes('businesse:edit')"
                                class="px-6 py-2 text-xs text-white">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="w-full bg-white divide-y divide-gray-300 dark:bg-dark-eval-1" style="width: 50vh">
                        <businesses-table :affaires="affaires.data" :showreas="showreas"
                                          @refreshing="refreshBusiness"/>
                        
                        </tbody>
                    </table>
                    
                    <!-- Paginate -->
                    <Paginate :links="props.affaires.links" :next="props.affaires.next_page_url"
                              :prev="props.affaires.prev_page_url" class="sticky left-0"/>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
    <Create :pays="props.pays" :reinsurer="reinsurer" :show="show"
            :transferors="props.cedante" @toggle="(value) => (show = value)"/>
    <Creating :cedante="cedante" :closeable="true" :pays="props.pays"
              :reinsurer="reinsurer" :show="shower" @toggler="closeModal()"/>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";

export default {layout: AuthenticatedLayout,};
</script>
<script setup>
import Create from "./CreateBusiness.vue";
import Creating from "./CreateNewBusiness.vue";
import Button from "@/Components/Button.vue";
import {ref, onMounted, reactive, onUpdated} from "vue";
import useBusiness from "@/Services/useBusiness";
import {Inertia} from "@inertiajs/inertia";
import Paginate from "@/Shared/Paginate.vue";
import Spinner from "@/Shared/Spinner.vue";
import BusinessesTable from "@/Pages/Business/DataTable/BusinessesTable.vue";

const props = defineProps({
    affaires: Object, reinsurer: Array,
    pays: Object, cedante: Object,
    filtres: Object,
});

// Declarations des variables
const searchBusinesse = ref(props.filtres.search ?? "");
const per_page = ref(props.filtres.per_page ?? 5);
const showreas = reactive([]);
const prime = reactive([]);
const show = ref(false);
const shower = ref(false);
const showre = ref(false);
const loader = ref(false)

const closeModal = () => {
    console.log(test)
    show.value = false
}
const tableFormat = () => {
    let dataTable;
    dataTable = new DataTable("#dataTable");
};
const search = _.throttle(function () {
    loader.value = true
    Inertia.get(route("business.index", {search: searchBusinesse.value, per_page: per_page.value,}), {}, {
            replace: true,
            preserveState: true,
            onSuccess: (response) => {
                console.log(response)
                loader.value = false
            }
        }
    );
}, 300);

//chargement des affaires
const {business, destroyBusiness, loading} = useBusiness();

const refreshBusiness = () => {
    business.value = props.affaires.data;
    for (let index = 0; index < business.value.length; index++) {
        showreas.push(false);
        prime.push(index);
    }
};
onMounted(() => {
    refreshBusiness();
});
onUpdated(() => {
    refreshBusiness();
});

const deleteBusiness = (affaire) => {
    destroyBusiness(affaire, showreas);
};
</script>

<style scoped>
.recent-order table {
    transition: all 300ms ease;
}

table tbody td {
    height: 2.8rem;
    border-bottom: 1px solid var(--color-light);
}

a {
    color: var(--color-primary);
}
</style>
