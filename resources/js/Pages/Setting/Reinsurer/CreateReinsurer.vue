<template>
  <div class="">
    <!-- {{ pays }} -->
    <form @submit.prevent="soumettre()">
      <hr class="mb-4" />
      <div class="grid grid-cols-4 gap-6">
        <!-- Raison social -->
        <div class="space-y-2">
          <Label for="nom_reas" value="Entrez la raison social" />
          <InputIconWrapper>
            <template #icon>
              <UserIcon aria-hidden="true" class="w-5 h-5" />
            </template>
            <Input withIcon id="nom_reas" type="text" placeholder="Raison social" class="block w-full"
              v-model="form.raison_social" required autofocus />
          </InputIconWrapper>
        </div>

        <!-- Registre de Commerce -->
        <div class="space-y-2">
          <Label for="registre_de_commerce" value="Saisissez le registre de commerce" />
          <InputIconWrapper>
            <template #icon>
              <UserIcon aria-hidden="true" class="w-5 h-5" />
            </template>
            <Input withIcon id="registre_de_commerce" type="text" class="block w-full" v-model="form.r_commerce"
              required autofocus placeholder="Registre de commerce" />
          </InputIconWrapper>
        </div>


        <!-- branche -->
        <div class="space-y-2">
          <Label for="denomination" value="Entrez la denomination sociale" />
          <InputIconWrapper>
            <template #icon>
              <UserIcon aria-hidden="true" class="w-5 h-5" />
            </template>
            <Input withIcon id="denomination" type="text" placeholder="Denomination sociale" class="block w-full"
              v-model="form.d_social" required autofocus autocomplete="branche" />
          </InputIconWrapper>
        </div>

        <!-- Pays @option:selecting="search"-->
        <div class="space-y-2">
          <Label for="Pays" value="Pays du reassureur" />
          <v-select class="text-[0.9rem]" :options="pays" label="label" v-model="form.pays">
          </v-select>
        </div>

        <!-- demande d'information -->
        <div class="col-start-1">
          <div class="grid gap-4 mt-2 w-auto">
            <!-- Nom du reassureurs offert -->
            <button class="p-1 bg-white mt-3 rounded-md text-secondary hover:bg-primary hover:text-white w-auto"
              @click.prevent="add_bank()">
              Ajouter une banque
            </button>
          </div>
        </div>
      </div>

      <div
        class="grid 3xl:grid-cols-4 xl:grid-cols-3 gap-2 gap-y-6 -m-[0.3rem] sm:grid sm:grid-cols-2 lg:grid lg:grid-cols-4"
        v-for="(bank, index) in form.banks" v-bind:key="index">
        <div class="flex">
          <button @click.prevent="remove()" class="bg-primary p-1 rounded-md mt-2 text-white px-2 hover:bg-black">
            x
          </button>
        </div>
        <div class="space-y-2 col-start-1">
          <Label :for="'raison_social' + [index]" value="Entrez la raison social" />

          <Input :id="'raison_social' + [index]" type="text" placeholder="Entrez la raison social"
            class="block w-full part_accepte 3xl:text-xl text-xs" v-model="form.banks[index].raison_social" required
            autofocus />
        </div>
        <!-- Part Accepté -->
        <div class="space-y-2">
          <Label :for="'rib' + [index]" value="Entrez le rib" />

          <Input :id="'rib' + [index]" type="text" placeholder="Entrez le rib"
            class="block w-full part_accepte 3xl:text-xl text-xs" v-model="form.banks[index].rib" required autofocus />
        </div>
        <!-- commission_reassurance -->
        <div class="space-y-2">
          <Label for="num_compte" value="Numero de compte" />

          <Input :id="'num_compte' + [index]" type="text" placeholder="Entrez le numero de compte"
            class="block w-full part_accepte 3xl:text-xl text-xs" v-model="form.banks[index].num_compte" required />
        </div>

        <!-- Prime reception Affaire -->
        <div class="space-y-2">
          <Label for="code_agence" value="Code agence" />

          <Input :id="'code_agence' + [index]" type="text" placeholder="Entrez le code d'agence"
            class="block w-full contient_monnaie 3xl:text-xl text-xs" v-model="form.banks[index].code_agence" required
            autofocus />
        </div>

        <!-- Date reception Affaire -->
        <div class="space-y-2">
          <Label :for="'code_bank' + [index]" value="Code banque" />
          <Input :id="'code_bank' + [index]" type="text" placeholder="Entrez le code banque"
            class="block w-full contient_monnaie 3xl:text-xl text-xs" v-model="form.banks[index].code_bank" required
            autofocus />
        </div>
        <div class="space-y-2">
          <Label for="swift" value="SWIFT" />

          <Input id="swift" type="text" placeholder="Entrez le swift" class="block w-full 3xl:text-xl text-xs"
            v-model="form.banks[index].swift" required autofocus />
        </div>

        <div class="space-y-2">
          <Label for="iban" value="IBAN" />

          <Input id="iban" type="text" class="block w-full 3xl:text-xl text-xs" placeholder="Entrez l'iban"
            v-model="form.banks[index].iban" required autofocus autocomplete="name" />
        </div>

        <!-- Capitaux à 100% -->
        <div class="space-y-2">
          <Label for="devise" value="Devise" />
          <select name="monnaie" id="monnaie" v-model="form.banks[index].devise"
            class="w-full rounded-md border-gray-600 text-center 3xl:text-xl text-xs">
            <option value="USD" :selected="true">Dollars</option>
            <option value="EUR">Euro</option>
            <option value="XOF">Fcfa</option>
            <option value="GBP">Livres</option>
          </select>
        </div>
        <!-- PPW -->

        <!-- Pays @option:selecting="search"-->
        <div class="space-y-2">
          <Label for="Pays" value="Pays de la banque" />
          <v-select class="text-[1.0rem]" :options="pays" :value="pays.id" label="label"
            v-model="form.banks[index].pays_id">
          </v-select>
        </div>
      </div>
      <div class="flex">
        <Button class="justify-center bg-secondary p-2 mt-3 rounded-md text-white" :disabled="form.processing"
          @click.prevent="soumettre()">
          <span>Enregistrer</span>
        </Button>
      </div>
    </form>
  </div>
</template>
<script>
import vSelect from "vue-select";

import AuthenticatedLayout from "@/Layouts/Authenticated.vue";

export default {
  layout: AuthenticatedLayout,
};
</script>

<script setup>
import MyModal from "@/Components/DialogModal.vue";
import { useSwalSuccess, useSwalError, useSwalConfirm } from "../../../Composables/alert";
import { useForm } from "@inertiajs/inertia-vue3";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import { ref, reactive, onMounted, computed } from "vue";

import { UserIcon, MailIcon, LockClosedIcon, UserAddIcon } from "@heroicons/vue/outline";
const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  pays: {
    type: Object,
  },
});
const show_bank = ref(false);
const form = useForm({
  raison_social: "",
  r_commerce: "",
  pays: "",
  d_social: "",
  banks: [{}],
});

const add_bank = () => {
  form.banks.push({});
};
const remove = () => {
  form.banks.pop();
};
const soumettre = () => {
  // console.log(props.form);
  form.post(route("reas.store"), {
    onSuccess: (page) => {
      useSwalSuccess("Réassureur ajouté avec succès!");
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
