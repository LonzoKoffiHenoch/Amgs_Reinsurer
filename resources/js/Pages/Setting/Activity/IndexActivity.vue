<template>
    <Authenticated>
        
        <div class="absolute top-1/2 left-1/2 z-50">
            <spinner v-if="loader" class=""></spinner>
        </div>
        <div>
            <Button :href="route('activity.create')" class="justify-center gap-2 mt-8 text-center bg-primary">
                <span>Ajouter une Activité</span>
            </Button>
            
            <ShowEditActivity v-if="show" :activity="activityAtShowing" :show="show"
                              @toggle="(value) => (show = value)"/>
            <div class="mt-4">
                <div class="flex flex-col">
                    <div class="w-full">
                        <div class="border-b border-gray-200 shadow">
                            <table id="dataTable" class="w-full divide-gray-300 table-fixed">
                                <thead class="bg-primary">
                                <tr>
                                    <th class="px-6 py-2 text-xs text-white">Raison Social</th>
                                    <th class="px-6 py-2 text-xs text-white">Registre de Commerce</th>
                                    <th class="px-6 py-2 text-xs text-white">Pays</th>
                                    <th class="px-6 py-2 text-xs text-white">Actions</th>
                                </tr>
                                </thead>
                                
                                <tbody class="bg-white divide-y divide-gray-300">
                                <template v-for="(activity, indexes) in activityByTransferor" :key="indexes">
                                    <tr class="text-center whitespace-nowrap text-[10px]">
                                        
                                        <td class="px-6 py-4 flex items-center gap-4 justify-center px-6 py-8 text-xl">
                                            <div class="justify-items-start">
                                                <button v-if="
                                                showActivity[indexes] === false &&
                                                activity.activityrates.length >= 1
                                            " class="text-xl transition-all ease-out delay-300"
                                                        @click.prevent="toggleAccordion(indexes)">
                                                    +
                                                </button>
                                                <button v-if="showActivity[indexes] === true"
                                                        class="text-xl transition-all ease-out delay-300"
                                                        @click.prevent="toggleAccordion(indexes)">
                                                    -
                                                </button>
                                            </div>
                                            <div class="text-xl font-bold text-gray-900 text-center">{{
                                                    activity.raison_social
                                                }}
                                            </div>
                                        </td>
                                        <!-- RIB -->
                                        <td class="px-6 py-4">
                                            <div class="text-xs font-bold text-gray-900">{{ activity.rib }}</div>
                                        </td>
                                        
                                        <!-- RIB -->
                                        <td class="px-6 py-4">
                                            <div class="text-xs font-bold text-gray-900">{{ activity.pays.label }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a class="inline-block text-center"
                                               @click.prevent="EditBankShow(activity.id)">
                                                <svg class="w-6 h-6 text-blue-400" fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"/>
                                                </svg>
                                            </a>
                                            
                                            <a class="inline-block text-center" href="#"
                                               @click.prevent="deleteConfirmation(activity)">
                                                <svg class="w-6 h-6 text-red-400" fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    <!--    Show Activity-->
                                    <tr v-if="showActivity[indexes] === true"
                                        class=" text-xl text-center text-white transition-all ease-out delay-300 bg-gray-200 ">
                                        <td class="px-10 left-0 top-0 w-full" colspan="2">
                                            <table class="sticky  w-full">
                                                <thead class="-mt-1 text-left bg-secondary sticky">
                                                <tr>
                                                    <th class="px-6 py-2 text-xs text-white">N°</th>
                                                    <th class="px-6 py-2">Type</th>
                                                    <th class="px-6 py-2 w-[240px]">Activité</th>
                                                    <th class="px-6 py-2">Pays</th>
                                                    <th class="px-6 py-2">Price</th>
                                                    <th class="px-6 py-2">Actions</th>
                                                
                                                
                                                </tr>
                                                </thead>
                                                
                                                <tr v-for="(act, index) in activity.activityrates"
                                                    :key="index" class="text-left transition-all ease-out delay-300">
                                                    
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm font-bold text-black">
                                                            {{ index + 1 }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-gray-900">
                                                            {{ act.type }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-gray-900">
                                                            {{
                                                                act.activity
                                                            }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-gray-900">
                                                            {{
                                                                activity.pays.label
                                                            }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-gray-900">
                                                            {{
                                                                act.price
                                                            }}
                                                        </div>
                                                    </td>
                                                    
                                                    <td class="px-6 py-4">
                                                        <a class="inline-block text-center" href=""
                                                           @click.prevent="showEditActivity(act)">
                                                            <svg class="w-6 h-6 text-blue-400" fill="none"
                                                                 stroke="currentColor"
                                                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"/>
                                                            </svg>
                                                        </a>
                                                        
                                                        <a class="inline-block text-center" href="#"
                                                           @click.prevent="deleteConfirmation(activity)">
                                                            <svg class="w-6 h-6 text-red-400" fill="none"
                                                                 stroke="currentColor"
                                                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"/>
                                                            </svg>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Authenticated>
</template>

<script setup>
import Authenticated from "@/Layouts/Authenticated.vue";
import Button from "@/Components/Button.vue";
import {onMounted, ref} from "vue";
import ShowEditActivity from "@/Pages/Setting/Activity/ShowEditActivity.vue";
import Spinner from "@/Shared/Spinner.vue";

const props = defineProps({
    activityByTransferor: Object,
})
const loader = ref(false)
const showActivity = ref([])
const show = ref(false);
const activityAtShowing = ref([]);
const toggleAccordion = (index) => {
    showActivity.value[index] = !showActivity.value[index];
};
const refreshActivity = () => {
    console.log(props.activityByTransferor)
    for (let index = 0; index < Object.keys(props.activityByTransferor).length; index++) {
        showActivity.value.push(false);
    }
};
const showEditActivity = (act) => {
    loader.value = true
    axios
        .get(route("activity.edit", {activity: act.id}))
        .then((response) => {
            console.log(response.data.activity)
            
            activityAtShowing.value = response.data.activity;
            show.value = true
            loader.value = false
        })
        .catch((error) => {
            console.log(error);
        });
}
onMounted(() => {
    refreshActivity()
})
</script>

<style scoped>

</style>