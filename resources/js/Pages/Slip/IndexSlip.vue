<template>
    <div>
        <div class="flex justify-between gap-4">
            <div class="mt-5">
                <Button v-if="$page.props.auth.permissions.includes('businesse:upload')" :href="route('slip.create')"
                        class="focus:ring-primary">
                    <span class="text-white">Upload des borderaux</span>
                </Button>
            </div>
        
        
        </div>
        <div class="mt-4">
            <div class="flex flex-col">
                <div class="relative h-screen overflow-x-auto border-b border-gray-200 shadow">
                    <table id="dataTable"
                           class="relative w-1/2 divide-gray-300 dark:bg-dark-eval-1">
                        <thead class="sticky top-0 z-20 bg-primary ">
                        <tr>
                            
                            <th class="sticky left-0 px-6 py-2 text-xs text-white bg-primary text-start">Label du
                                Borderaux
                            </th>
                            
                            <th class="sticky left-0 px-6 py-2 text-xs text-white bg-primary text-start">
                                Action
                            </th>
                        
                        
                        </tr>
                        </thead>
                        <tbody class="w-full bg-white divide-y divide-gray-300 dark:bg-dark-eval-1"
                               style="width: 50vh;">
                        <template v-for="(slip, indexes) in slips" :key="indexes">
                            <tr
                                class="text-center whitespace-nowrap text-[10px]  dark:text-white dark:bg-dark-eval-1">
                                
                                
                                <td class="sticky left-0 z-10 flex-col px-6 py-8 text-start w-1/2">
                                    <div class="mt-1 text-xs font-bold text-center text-gray-900 dark:text-white">
                                        <a :href="route('slip.showtable',{borderau:slip.id})">{{ slip.label }}</a>
                                    </div>
                                </td>
                                
                                <td class="sticky left-0 z-10 flex items-center px-6 py-8 text-start">
                                    <div class="">
                                    
                                    </div>
                                    <div class="mt-1 text-xs font-bold text-center text-gray-900 dark:text-white">
                                        <a :href="route('slip.showtable',{borderau:slip.id})"></a>
                                    </div>
                                </td>
                            
                            
                            </tr>
                        
                        
                        </template>
                        </tbody>
                    </table>
                    
                    <!-- Paginate -->
                    <!-- <Paginate :links="props.affaires.links" :prev="props.affaires.prev_page_url"
                        :next="props.affaires.next_page_url" class="sticky left-0" /> -->
                
                </div>
                <!-- </div> -->
            </div>
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
import warningIcons from "@/Components/Icons/warningIcons.vue";
import Button from "@/Components/Button.vue";
import {onMounted, onUpdated, ref} from "vue";
import useSlips from "@/Services/useSlips";

// Declarations des variables
const showBusinessesInSlip = ref([]);

const tableFormat = () => {
    dataTable = new DataTable("#dataTable");
}
const search = _.throttle(function () {
    Inertia.get(route("business.index", {search: searchBusinesse.value, per_page: per_page.value}), {}, {
        replace: true,
        preserveState: true
    })
}, 300)

//chargement des affaires
const {slips, getSlips, destroySlip} = useSlips()
onMounted(() => {
    getSlips();
});
const deleteSlip = (affaire) => {
    destroySlip(affaire, showreas)
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
