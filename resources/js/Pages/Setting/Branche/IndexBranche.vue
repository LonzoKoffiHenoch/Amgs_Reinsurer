<template>
    <div>
        <div>
            <div class="">
                <Button class="justify-center gap-2 text-center mt-4" @click.prevent="show = true">
                    <span>Ajouter une branche</span>
                </Button>
                <Createbranche @toggle="(value) => (show = value)" :show="show" />
                <Editbranche @toggle="(value) => (showEdit = value)" :show="showEdit" :branche="banque" />
            </div>
        </div>

        <div class="mt-4">
            <div class="flex flex-col">
                <div class="w-full">
                    <div class="border-b border-gray-200 shadow">
                        <table class="divide-gray-300 table-fixed w-[70%]" id="dataTable">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="px-6 py-2 text-lg text-white text-left">
                                        Label
                                    </th>


                                    <th class="px-6 py-2 text-lg text-white text-right">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                <template v-for="(branche, indexes) in branches.data" :key="indexes">
                                    <tr class="text-center whitespace-nowrap text-[10px] ">
                                        <!-- Raison _ Social -->
                                        <td class="px-6 py-4">
                                            <div class=" text-gray-900 font-bold text-xs text-left ">{{ branche.label }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <a @click.prevent="EditbrancheShow(branche.id)"
                                                class="inline-block text-center cursor">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400 "
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <a href="#" class="inline-block text-center"
                                                @click.prevent="deleteConfirmation(branche)">
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

                        <!-- Paginate -->
                        <Paginate :links="props.branches.links" :prev="props.branches.prev_page_url"
                            :next="props.branches.next_page_url" />
                    </div>
                </div>
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
import Paginate from "../../../Shared/Paginate.vue"

import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import Button from "@/Components/Button.vue";
import Createbranche from "./Createbranche.vue";
import Editbranche from "./Editbranche.vue";

import { ref } from "vue";
import {
    useSwalConfirm,
    useSwalSuccess,
    useSwalError,
} from "../../../Composables/alert";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps(["branches"]);
const show = ref(false);
const showEdit = ref(false);
const banque = ref([]);

const EditbrancheShow = (id) => {
    axios
        .get(route("branche.edit", {
            "branche": id
        }))
        .then((response) => {
            // console.log(response.data);
            banque.value = response.data.branche;
            showEdit.value = true;
            // console.log(banque);

        })
        .catch((error) => {
            console.log(error);
        });

}

const deletebranche = (id) => {
    Inertia.delete(route("branche.delete", { branche: id }), {
        onSuccess: (response) => {
            useSwalSuccess("la branche a été supprimée avec succès!");
            // preserveState:true
        },
        onError: (error) => {
            useSwalError(error.message ?? "Une erreur a été rencontrée");
        },
    });
};
const deleteConfirmation = (branche) => {
    // console.log(affaire);
    const message = `Vous êtes sur le point de supprimer la branche "${branche.label}", voulez-vous continuer?`;
    useSwalConfirm(message, () => {
        deletebranche(branche.id);
    });
};
</script>