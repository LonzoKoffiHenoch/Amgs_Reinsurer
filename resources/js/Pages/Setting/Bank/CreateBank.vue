<template>
    <MyModal :show="props.show" @close="setIsOpened(false)" :closeable="true" :max-width="'xl'" :max-height="'h-[60%]'">
        <template #content>
            <div class="mt-4">
                <div class="flex justify-between mb-4">
                    <h3 class="text-2xl font-bold">Ajout de banque</h3>
                    <div class="flex gap-8 left">
                        <button
                            class="text-xl w-8 h-8 transition-all hover:bg-primary hover:rounded-[100%] hover:w-8 hover:h-8 p-[0.15rem] hover:p-[0.15rem] hover:text-white "
                            @click="setIsOpened(false)">
                            x
                        </button>
                    </div>

                </div>
                <form>
                    <div class="grid justify-between grid-cols-2 gap-2">
                        <div class="space-y-2">
                            <Label for="raison_social" value="Raison social" />
                            <InputIconWrapper>

                                <Input id="raison_social" type="text" placeholder="Entrez la raison social"
                                    class="block w-full" v-model="form.raison_social" required autofocus />
                            </InputIconWrapper>
                        </div>

                        <div class="space-y-2 ">
                            <Label for="rib" value="RIB" />
                            <InputIconWrapper>

                                <Input id="rib" type="text" placeholder="Entrez le RIB" class="block w-full"
                                    v-model="form.rib" required autofocus />
                            </InputIconWrapper>
                        </div>
                        <div class="space-y-2 ">
                            <Label for="num_compte" value="Numero de Compte" />
                            <InputIconWrapper>

                                <Input id="num_compte" type="text" placeholder="Entrez le numero de compte"
                                    class="block w-full" v-model="form.num_compte" required autofocus />
                            </InputIconWrapper>
                        </div>
                        <div class="space-y-2 ">
                            <Label for="code_agence" value="Code agence" />
                            <InputIconWrapper>

                                <Input id="code_agence" type="text" placeholder="Entrez le Code de l'agence"
                                    class="block w-full" v-model="form.code_agence" required autofocus />
                            </InputIconWrapper>
                        </div>
                        <div class="space-y-2 ">
                            <Label for="code_bank" value="Code Banque" />
                            <Input id="code_bank" type="text" placeholder="Entrez le Code banque" class="block w-full"
                                v-model="form.code_bank" required autofocus />
                        </div>

                        <!-- Devise -->
                        <div class="w-full space-y-2">
                            <Label for="monnaie" value="Choisir la monnaie" />
                            <select name="monnaie" id="monnaie" v-model="form.devise"
                                @change="changeMonnaie(form.devise)"
                                class="w-full text-center border-gray-600 rounded-md ">
                                <option value="USD" :selected="true">Dollars</option>
                                <option value="EUR">Euro</option>
                                <option value="XOF">Fcfa</option>
                                <option value="GBP">Livres</option>
                            </select>
                        </div>
                        <!--  -->
                        <!-- pays -->
                        <div class="space-y-2">
                            <Label for="Pays" value="Pays" />
                            <v-select class="text-[0.90rem]" :options="pays" :value="pays.id" label="label"
                                v-model="form.pays_id">
                            </v-select>
                        </div>
                        <!-- {{ form.pays_id }} -->

                        <div class="space-y-2 ">
                            <Label for="swift" value="SWIFT" />
                            <InputIconWrapper>
                                <template #icon>
                                    <!-- <UserIcon aria-hidden="true" class="w-5 h-5" /> -->
                                </template>
                                <Input id="swift" type="text" placeholder="Entrez le swift" class="block w-full"
                                    v-model="form.swift" required autofocus />
                            </InputIconWrapper>
                        </div>
                        <div class="space-y-2 ">
                            <Label for="iban" value="IBAN" />
                            <InputIconWrapper>
                                <template #icon>
                                    <!-- <UserIcon aria-hidden="true" class="w-5 h-5" /> -->
                                </template>
                                <Input id="iban" type="text" placeholder="Entrez l'iban" class="block w-full"
                                    v-model="form.iban" required autofocus />
                            </InputIconWrapper>
                        </div>
                    </div>
                    <Button class="justify-center gap-2 mt-4 text-center" @click.prevent="soumettre">
                        <span>Ajouter</span>
                    </Button>
                </form>
            </div>
        </template>
    </MyModal>
</template>

<script setup>
import { UserIcon, MailIcon, LockClosedIcon, UserAddIcon } from "@heroicons/vue/outline";
import vSelect from "vue-select";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import MyModal from "@/Components/DialogModal.vue";
import Button from "@/Components/Button.vue";
import {
    useSwalConfirm,
    useSwalSuccess,
    useSwalError,
} from "../../../Composables/alert";
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import { ref, onMounted } from "vue";
const form = useForm({
    raison_social: "",
    rib: "",
    num_compte: "",
    code_agence: "",
    code_bank: "",
    devise: "",
    swift: "",
    iban: "",
    pays_id: ""
});
const props = defineProps(["show"])
const emit = defineEmits(["toggle"]);

function setIsOpened(value) {
    emit("toggle", value);
}

const pays = ref([]);
onMounted(() => {
    axios
        .get(route("api.getPays"))
        .then((response) => {
            pays.value = response.data.pays;
        })
        .catch((error) => {
            console.log(error);
        });
});
const soumettre = () => {
    form.post(route("bank.store"), {
        onSuccess: (page) => {
            //emit("recharge");
            useSwalSuccess("banque ajoutée avec succès!");
            setIsOpened(false);
            form.reset();
        },
        onError: (errors) => {
            useSwalError("Une erreur s'est produite.");
            preserveState: true;
        },
    });
};

</script>