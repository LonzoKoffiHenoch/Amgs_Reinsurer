<script setup>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/Label.vue';
import PrimaryButton from '@/Components/Button.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import {
    useSwalConfirm,
    useSwalSuccess,
    useSwalError,
} from "../../../Composables/alert";
const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});
const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            useSwalSuccess("Mot de passe modifié avec succès!");
            form.reset()
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <section class="m-auto  ">
            <header class="text-center">
                <h2 class="text-lg text-gray-900 dark:text-gray-100 mt-4 font-bold">Modification du Mot de
                    Passe</h2>

                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                    Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester en sécurité.
                </p>
            </header>

            <form @submit.prevent="updatePassword" class="mt-6 space-y-6 w-1/2 m-auto">
                <div>
                    <InputLabel for="current_password" value="Saisissez votre ancien mot de passe" />

                    <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                        type="password" class="mt-1 block w-full" />

                    <InputError :message="form.errors.current_password" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="password" value="Nouveau mot de passe" />

                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="mt-1 block w-full" autocomplete="new-password" />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="password_confirmation" value="Confirmez votre mot de passe" />

                    <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                        class="mt-1 block w-full" autocomplete="new-password" />

                    <InputError :message="form.errors.password_confirmation" class="mt-2" />
                </div>

                <div class="flex items-center gap-4 ">
                    <PrimaryButton :disabled="form.processing">Enregistré</PrimaryButton>

                    <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Enregistre.
                        </p>
                    </Transition>
                </div>
            </form>
        </section>

    </AuthenticatedLayout>
</template>