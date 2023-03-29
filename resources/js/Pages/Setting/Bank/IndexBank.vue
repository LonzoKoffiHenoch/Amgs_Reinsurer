<template>
	<div>
		<Button class="justify-center gap-2 mt-4 text-center" @click.prevent="show = true">
			<span>Ajouter une banque</span>
		</Button>
		<CreateBank @toggle="(value) => (show = value)" :show="show" />
		<EditBank @toggle="(value) => (showEdit = value)" :show="showEdit" :bank="banque" />

		<div class="mt-4">
			<div class="flex flex-col">
				<div class="w-full">
					<div class="border-b border-gray-200 shadow">
						<table class="w-full divide-gray-300 table-fixed" id="dataTable">
							<thead class="bg-primary">
								<tr>
									<th class="px-6 py-2 text-xs text-white">Raison social</th>
									<th class="px-6 py-2 text-xs text-white">RIB</th>
									<th class="px-6 py-2 text-xs text-white">Iban</th>
									<th class="px-6 py-2 text-xs text-white">Actions</th>
								</tr>
							</thead>
							<!-- {{ banks }} -->
							<tbody class="bg-white divide-y divide-gray-300">
								<template v-for="(bank, indexes) in banks" :key="indexes">
									<tr class="text-center whitespace-nowrap text-[10px]">
										<!-- Raison _ Social -->
										<td class="px-6 py-4">
											<div class="text-xs font-bold text-gray-900">{{ bank.raison_social }}</div>
										</td>
										<!-- RIB -->
										<td class="px-6 py-4">
											<div class="text-xs font-bold text-gray-900">{{ bank.rib }}</div>
										</td>

										<!-- RIB -->
										<td class="px-6 py-4">
											<div class="text-xs font-bold text-gray-900">{{ bank.iban }}</div>
										</td>
										<td class="px-6 py-4">
											<a @click.prevent="EditBankShow(bank.id)" class="inline-block text-center">
												<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none"
													viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
														d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
												</svg>
											</a>

											<a href="#" class="inline-block text-center" @click.prevent="deleteConfirmation(bank)">
												<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none"
													viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
import CreateBank from "./CreateBank.vue";
import EditBank from "./EditBank.vue";

import { ref } from "vue";
import { useSwalConfirm, useSwalSuccess, useSwalError } from "../../../Composables/alert";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps(["banks"]);
const show = ref(false);
const showEdit = ref(false);
const banque = ref([]);

const EditBankShow = (id) => {
	axios
		.get(
			route("api.getBank", {
				bank: id,
			})
		)
		.then((response) => {
			// console.log(response.data);
			banque.value = response.data.bank;
			showEdit.value = true;
			// console.log(banque);
		})
		.catch((error) => {
			console.log(error);
		});
};

const deleteBank = (id) => {
	Inertia.delete(route("bank.delete", { bank: id }), {
		onSuccess: (response) => {
			useSwalSuccess("la banque a été supprimée avec succès!");
		},
		onError: (error) => {
			useSwalError(error.message ?? "Une erreur a été rencontrée");
		},
	});
};
const deleteConfirmation = (bank) => {
	// console.log(affaire);
	const message = `Vous êtes sur le point de supprimer la banque "${bank.raison_social}", voulez-vous continuer?`;
	useSwalConfirm(message, () => {
		deleteBank(bank.id);
	});
};
</script>
