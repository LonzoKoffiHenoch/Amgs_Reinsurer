<template>
    <div>
        <Button class="justify-center gap-2 text-center mt-4" @click.prevent="show = true">
            <span>Ajouter un utilisateur</span>
        </Button>
        <CreateUser @toggle="(value) => (show = value)" :show="show" />
        <EditUser @toggle="(value) => (showEdit = value)" :show="showEdit" :user="banque" />

        <div class="mt-4">
            <div class="flex flex-col">
                <div class="w-full">
                    <div class="border-b border-gray-200 shadow">
                        <table class="divide-gray-300 table-fixed w-full" id="dataTable">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="px-6 py-2 text-xs text-white">Utilisateurs</th>
                                    <th class="px-6 py-2 text-xs text-white">Email</th>
                                    <th class="px-6 py-2 text-xs text-white">Role</th>
                                    <th class="px-6 py-2 text-xs text-white">Permissions</th>
                                    <th class="px-6 py-2 text-xs text-white">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                <template v-for="(user, indexes) in users" :key="indexes">
                                    <tr class="text-center whitespace-nowrap text-[10px]">
                                        <!-- Raison _ Social -->
                                        <td class="px-6 py-4">
                                            <div class="text-gray-900 font-bold text-xs">{{ user.name }}</div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="text-gray-900 font-bold text-xs">{{ user.email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-900 font-bold text-xs">{{ user.role }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-900 font-bold text-xs">{{ user.permission }}</div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <a @click.prevent="EdituserShow(user.id)"
                                                class="inline-block text-center cursor">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <a href="#" class="inline-block text-center"
                                                @click.prevent="deleteConfirmation(user)">
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
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import Button from "@/Components/Button.vue";
import CreateUser from "./CreateUser.vue";
import EditUser from "./EditUser.vue";
import { ref } from "vue";
import { useSwalConfirm, useSwalSuccess, useSwalError } from "../../../Composables/alert";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps(["users"]);
const show = ref(false);
const showEdit = ref(false);
const banque = ref([]);
const EdituserShow = (id) => {
    axios
        .get(route("user.edit", { user: id, }))
        .then((response) => {
            banque.value = response.data.user;
            showEdit.value = true;
        })
        .catch((error) => { console.log(error); });
};
const deleteuser = (id) => {
    Inertia.delete(route("user.delete", { user: id }), {
        onSuccess: (response) => { useSwalSuccess("le pays a été supprimé avec succès!"); },
        onError: (error) => { useSwalError(error.message ?? "Une erreur a été rencontrée"); },
    });
};
const deleteConfirmation = (user) => {
    const message = `Vous êtes sur le point de supprimer le pays "${user.name}", voulez-vous continuer?`;
    useSwalConfirm(message, () => { deleteuser(user.id); });
};
</script>
