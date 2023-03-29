<template>
    <div>
        <div class="flex gap-4 justify-between">

            <!-- <LoginIcon aria-hidden="true" :class="iconSizeClasses" /> -->
            <Button class="justify-center gap-2 text-center mt-4" :href="route('reas.create')">
                <span>Créer un reassureur</span>
            </Button>

            <div class="mt-4">
                <form>
                    <label for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300"></label>
                    <div class="relative">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" id="default-search"
                            class="block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Recherche" required>
                        <button type="submit"
                            class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary dark:hover:bg-secondary dark:focus:ring-blue-800">v</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="mt-2 3xl:mt-4">
            <div class="flex flex-col">
                <div class="w-full">
                    <div class="border-b border-gray-200 shadow">
                        <table class="divide-gray-300 w-full" id="dataTable">
                            <thead class="bg-primary">
                                <tr class="text-left">
                                    <th class="text-[0.1rem] w-[20px] ml-2"></th>
                                    <th class="px-6 py-2 text-xs text-white">
                                        Raison sociale
                                    </th>
                                    <th class="px-6 py-2 text-xs text-white">
                                        Pays
                                    </th>

                                    <th class="px-6 py-2 text-xs text-white">
                                        Registre de commerce
                                    </th>
                                    <th class="px-6 py-2 text-xs text-white">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                <template v-for="(reinsurer, indexes) in reas.data" :key="indexes">
                                    <tr class="whitespace-nowrap text-left">
                                        <td class="pl-3">
                                            <!-- <button
                                                v-if="
                                                    showreas[indexes] ==
                                                        false &&
                                                    reinsurer.businesses.length >= 1
                                                "
                                                class="
                                                    m-2
                                                    text-xl
                                                    transition-all
                                                    ease-out
                                                    delay-300
                                                "
                                                @click.prevent="
                                                    toggleAccordion(indexes)
                                                "
                                            >
                                                +
                                            </button> -->
                                            <!-- <button
                                                v-if="showreas[indexes] == true"
                                                class="
                                                    m-2
                                                    text-xl
                                                    transition-all
                                                    ease-out
                                                    delay-300
                                                "
                                                @click.prevent="
                                                    toggleAccordion(indexes)
                                                "
                                            >
                                                -
                                            </button>
                                            <input
                                                type="checkbox"
                                                name=""
                                                id=""
                                            /> -->
                                        </td>
                                        <td class="px-6 py-4 text-left">
                                            <div class="text-sm text-gray-900">
                                                {{ reinsurer.raison_social }}
                                            </div>
                                        </td>
                                        <td class="
                                                px-6
                                                py-4
                                                text-sm text-gray-500 text-left
                                            ">
                                            <div class="text-sm text-gray-500">
                                                {{ reinsurer.pays }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-left">
                                            <div class="text-sm text-gray-500">
                                                {{ reinsurer.r_commerce }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a :href="
                                                route('reas.edit', {
                                                    reinsurer: reinsurer.id,
                                                })
                                            " class="inline-block text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="
                                                        w-6
                                                        h-6
                                                        text-blue-400
                                                    " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <a @click.prevent="deleteConfirmation(reinsurer)"
                                                class="inline-block text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>

                                </template>
                            </tbody>
                        </table>
                        <!-- pagniation -->
                        <Paginate :links="props.reas.links" :prev="props.reas.prev_page_url"
                            :next="props.reas.next_page_url" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import vSelect from "vue-select";
import Paginate from "../../../Shared/Paginate.vue"
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";

export default {
    layout: AuthenticatedLayout,
};
</script>
<script setup>
import { onMounted, ref, computed, reactive } from "vue";
import Button from "@/Components/Button.vue";
import {
    useSwalConfirm,
    useSwalSuccess,
    useSwalError,
} from "../../../Composables/alert";
import { Inertia } from "@inertiajs/inertia";

const showreas = reactive([]);
const show = ref(false);
const showre = ref(false);
const toggleAccordion = (index) => {
    showreas[index] = !showreas[index];
    // console.log(showreas);
};

const props = defineProps({
    reas: Object,
});
const reinsureri = ref([]);
onMounted(() => {
    for (let index = 0; index < props.reas.length; index++) {
        showreas.push(false);
    }
});
const deleteReinsurer = (id) => {
    Inertia.delete(route("reas.delete", { reinsurer: id }), {
        onSuccess: (response) => {
            useSwalSuccess("le reassureur a été supprimée avec succès!");
        },
        onError: (error) => {
            useSwalError(error.message ?? "Une erreur a été rencontrée");
        },
    });
};
const deleteConfirmation = (reinsurer) => {
    // console.log(affaire);
    const message = `Vous êtes sur le point de supprimer la branche "${reinsurer.raison_social}", voulez-vous continuer?`;
    useSwalConfirm(message, () => {
        deleteReinsurer(reinsurer.id);
    });
};
</script>