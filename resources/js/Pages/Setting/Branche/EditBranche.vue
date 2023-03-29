<template>
    <MyModal :show="props.show" @close="setIsOpened(false)" :closeable="true" :max-width="'xl'" :max-height="'h-[60%]'">
        <template #content>
            <div class="mt-4">
                <div class="flex justify-between mb-4">
                    <h3 class="text-2xl font-bold">
                        Modification de la branche <br><span class="text-sm text-gray-500">{{ branche.label }}</span>
                    </h3>
                    <div class="left flex gap-8">
                        <button
                            class="text-xl w-8 h-8 transition-all hover:bg-primary hover:rounded-[100%] hover:w-8 hover:h-8 p-[0.15rem] hover:p-[0.15rem] hover:text-white"
                            @click="setIsOpened(false)">
                            x
                        </button>
                    </div>

                </div>
                <form>
                    <div class="space-y-2">
                        <Label for="raison_social" value="Entrez la branche" />
                        <InputIconWrapper>
                            <template #icon>
                                <!-- <UserIcon aria-hidden="true" class="w-5 h-5" /> -->
                            </template>
                            <Input withIcon id="raison_social" type="text" placeholder="Saisissez la branche"
                                class="block w-full" v-model="form.label" required autofocus />
                        </InputIconWrapper>
                    </div>

                    <Button class="justify-center gap-2 text-center mt-4" @click.prevent="soumettre(props.branche.id)">
                        <span>Ajouter</span>
                    </Button>
                </form>
            </div>
        </template>
    </MyModal>
</template>

<script setup>
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
import { useForm } from "@inertiajs/inertia-vue3";
import { onBeforeUpdate } from "vue";

const props = defineProps(["show", "branche"])
const emit = defineEmits(["toggle"]);
const form = useForm({
    label: props.branche.label,
});
// console.log(props.branche);
function setIsOpened(value) {
    emit("toggle", value);
}
onBeforeUpdate(() => {
    form.label = props.branche.label;

});
const soumettre = (id) => {
    form.post(route("branche.update", {
        branche: id
    }), {
        onSuccess: (page) => {
            useSwalSuccess("banque modifié avec succès!");
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