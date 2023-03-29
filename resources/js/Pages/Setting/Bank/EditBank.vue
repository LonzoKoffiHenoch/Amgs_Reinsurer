<template>
    <MyModal :closeable="true" :max-height="'h-[60%]'" :max-width="'xl'" :show="props.show" @close="setIsOpened(false)">
        <template #content>
            <div class="mt-4">
                <div class="flex justify-between mb-4">
                    <h3 class="text-2xl font-bold">Ajout de banque</h3>
                    <div class="left flex gap-8">
                        <button
                            class="text-xl w-8 h-8 transition-all hover:bg-primary hover:rounded-[100%] hover:w-8 hover:h-8 p-[0.15rem] hover:p-[0.15rem] hover:text-white "
                            @click="setIsOpened(false)">
                            x
                        </button>
                    </div>
                
                </div>
                <form>
                    <div class="space-y-2">
                        <Label for="raison_social" value="Raison social"/>
                        <InputIconWrapper>
                            <template #icon>
                                <!-- <UserIcon aria-hidden="true" class="w-5 h-5" /> -->
                            </template>
                            <Input id="raison_social" v-model="form.raison_social" autofocus class="block w-full"
                                   placeholder="Entrez la raison social" required type="text" withIcon/>
                        </InputIconWrapper>
                    </div>
                    
                    <div class="space-y-2 mt-4">
                        <Label for="rib" value="RIB"/>
                        <InputIconWrapper>
                            <template #icon>
                                <!-- <UserIcon aria-hidden="true" class="w-5 h-5" /> -->
                            </template>
                            <Input id="rib" v-model="form.rib" autofocus class="block w-full" placeholder="Entrez le RIB"
                                   required type="text" withIcon/>
                        </InputIconWrapper>
                    </div>
                    <Button class="justify-center gap-2 text-center mt-4" @click.prevent="soumettre(props.bank.id)">
                        <!-- <LoginIcon aria-hidden="true" :class="iconSizeClasses" /> -->
                        <span>Ajouter</span>
                    </Button>
                </form>
            </div>
        </template>
    </MyModal>
</template>

<script setup>
import {UserIcon, MailIcon, LockClosedIcon, UserAddIcon} from "@heroicons/vue/outline";
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
import {useForm} from "@inertiajs/inertia-vue3";
import {onBeforeUpdate} from "vue";

const props = defineProps(["show", "bank"])
const emit = defineEmits(["toggle"]);
const form = useForm({
    raison_social: props.bank.raison_social,
    rib: props.bank.rib
});

// console.log(props.bank);
function setIsOpened(value) {
    emit("toggle", value);
}

onBeforeUpdate(() => {
    form.raison_social = props.bank.raison_social;
    form.rib = props.bank.rib;
    
});
const soumettre = (id) => {
    form.post(route("setting.updatebank", {
        bank: id
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