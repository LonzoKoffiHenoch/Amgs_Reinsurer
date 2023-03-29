<template>
    <MyModal :show="props.show" @close="setIsOpened(false)" :closeable="true" :max-width="'xl'" :max-height="'h-[60%]'">
        <template #content>
            <div class="mt-4">
                <div class="flex justify-between mb-4">
                    <h3 class="text-2xl font-bold">Ajout de l'utilisateur</h3>
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
                <form @submit.prevent="soumettre()">
                    <ValidationErrors class="mb-4" />

                    <div class="grid gap-6">
                        <div class="space-y-2">
                            <Label for="name" value="Name" />
                            <InputIconWrapper>
                                <template #icon>
                                    <!-- <UserIcon aria-hidden="true" class="w-5 h-5" /> -->
                                </template>
                                <Input withIcon id="name" type="text" placeholder="Name" class="block w-full"
                                    v-model="form.name" required autofocus />
                            </InputIconWrapper>
                        </div>

                        <div class="space-y-2">
                            <Label for="email" value="Email" />
                            <InputIconWrapper>
                                <template #icon>
                                    <!-- <MailIcon aria-hidden="true" class="w-5 h-5" /> -->
                                </template>
                                <Input withIcon id="email" type="email" class="block w-full" placeholder="Email"
                                    v-model="form.email" required />
                            </InputIconWrapper>
                        </div>
                        <div class="space-y-2">
                            <Label for="phone" value="Phone" />
                            <InputIconWrapper>
                                <template #icon>
                                    <!-- <MailIcon aria-hidden="true" class="w-5 h-5" /> -->
                                </template>
                                <Input withIcon id="phone" type="text" class="block w-full"
                                    placeholder="Entrez votre numero" v-model="form.phone" />
                            </InputIconWrapper>
                        </div>

                        <div class="space-y-2">
                            <Label for="password" value="Password" />
                            <InputIconWrapper>
                                <template #icon>
                                    <LockClosedIcon aria-hidden="true" class="w-5 h-5" />
                                </template>
                                <Input withIcon id="password" type="password" class="block w-full"
                                    placeholder="Password" v-model="form.password" required
                                    autocomplete="new-password" />
                            </InputIconWrapper>
                        </div>

                        <div class="space-y-2">
                            <Label for="password_confirmation" value="Confirm Password" />
                            <InputIconWrapper>
                                <template #icon>
                                    <!-- <LockClosedIcon aria-hidden="true" class="w-5 h-5" /> -->
                                </template>
                                <Input withIcon id="password_confirmation" type="password" class="block w-full"
                                    placeholder="Confirm Password" v-model="form.password_confirmation" required
                                    autocomplete="new-password" />
                            </InputIconWrapper>
                        </div>

                        <div>
                            <Button class="justify-center gap-2 w-full" :disabled="form.processing"
                                v-slot="{ iconSizeClasses }" @click.prevent="soumettre">
                                <!-- <UserAddIcon aria-hidden="true" :class="iconSizeClasses" /> -->
                                <span>Ajouter un utilisateur</span>
                            </Button>
                        </div>


                    </div>

                </form>
            </div>
        </template>
    </MyModal>
</template>

<script setup>
import { computed } from 'vue';
import ValidationErrors from "@/Components/ValidationErrors.vue";
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
import Swal from 'sweetalert2';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
})
const props = defineProps(["show"])
const emit = defineEmits(["toggle"]);

function setIsOpened(value) {
    emit("toggle", value);
}
// const errors = computed(() => usePage().props.value.errors)
const hasErrors = computed(() => Object.keys(errors.value).length > 0)
const soumettre = () => {
    form.post(route("user.store"), {
        onSuccess: (page) => {
            //emit("recharge");
            useSwalSuccess("Utilisateur ajouté avec succès!");
            setIsOpened(false);
            form.reset();
        },
        onError: (errors) => {
            console.log(errors);
            useSwalError("Une erreur s'est produite.");
            if (Object.keys(errors).length > 0) {
                setTimeout(function () {
                    const message = `"${errors.name + errors.email + errors.password}"`
                    useSwalError(message);

                }, 1000);
            }

            preserveState: true;
            // scrollTo('name');
        },
    });
};

</script>