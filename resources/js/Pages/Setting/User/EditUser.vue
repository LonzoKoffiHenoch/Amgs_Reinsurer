<template>
    <MyModal :show="props.show" @close="setIsOpened(false)" :closeable="true" :max-width="'xl'" :max-height="'h-[60%]'">
        <template #content>
            <div class="mt-4">
                <div class="flex justify-between mb-4">
                    <h3 class="text-2xl font-bold">Modification du Pays <br> <span class="text-sm text-gray-500">{{
                            user.label
                    }}</span></h3>
                    <div class="left flex gap-8">
                        <button class="
                                        text-xl
                                        w-8
                                        h-8
                                        transition-all
                                        hover:bg-primary
                                        hover:rounded-[100%]
                                        hover:w-8
                                        hover:h-8
                                        p-[0.15rem]
                                        hover:p-[0.15rem] hover:text-white
                                    " @click="setIsOpened(false)">
                            x
                        </button>
                    </div>

                </div>
                <form @submit.prevent="soumettre(user.id)">
                    <!-- {{ user }} -->
                    <div class="grid gap-6">
                        <div class="space-y-2">
                            <Label for="name" value="Name" />
                            <InputIconWrapper>
                                <template #icon>
                                    <!-- <UserIcon aria-hidden="true" class="w-5 h-5" /> -->
                                </template>
                                <Input withIcon id="name" type="text" placeholder="Name" class="block w-full"
                                    v-model="form.name" required autofocus autocomplete="name" />
                            </InputIconWrapper>
                        </div>

                        <div class="space-y-2">
                            <Label for="email" value="Email" />
                            <InputIconWrapper>
                                <template #icon>
                                    <!-- <MailIcon aria-hidden="true" class="w-5 h-5" /> -->
                                </template>
                                <Input withIcon id="email" type="email" class="block w-full" placeholder="Email"
                                    v-model="form.email" required autocomplete="username" />
                            </InputIconWrapper>
                        </div>
                        <div class="space-y-2">
                            <Label for="telephone" value="Telephone" />
                            <InputIconWrapper>
                                <template #icon>
                                    <!-- <MailIcon aria-hidden="true" class="w-5 h-5" /> -->
                                </template>
                                <Input withIcon id="telephone" type="text" class="block w-full"
                                    placeholder="Numero de telephone" v-model="form.phone" required
                                    autocomplete="username" />
                            </InputIconWrapper>
                        </div>



                        <div>
                            <Button class="justify-center gap-2 w-full" :disabled="form.processing"
                                v-slot="{ iconSizeClasses }" @click.prevent="soumettre(user.id)">
                                <!-- <UserAddIcon aria-hidden="true" :class="iconSizeClasses" /> -->
                                <span>Modifié</span>
                            </Button>
                        </div>


                    </div>

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

const props = defineProps(["show", "user"])
const emit = defineEmits(["toggle"]);
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone,
    terms: false,
})
// console.log(props.user);
function setIsOpened(value) {
    emit("toggle", value);
}
onBeforeUpdate(() => {
    form.name = props.user.name;
    form.email = props.user.email;
    form.phone = props.user.phone;
    form.terms = false;

});
const soumettre = (id) => {
    form.post(route("user.update", {
        user: id
    }), {
        onSuccess: (page) => {
            useSwalSuccess("utilisateur modifié avec succès!");
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