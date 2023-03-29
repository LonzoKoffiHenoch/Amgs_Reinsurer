<template>
    <GuestLayout title="Forgot Password">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Mot de passe oublié? Aucun problème. Indiquez-nous simplement votre
            adresse e-mail et nous vous enverrons par e-mail un lien de
            réinitialisation de mot de passe qui vous permettra d'en choisir un
            nouveau.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="grid gap-6">
                <div class="space-y-2">
                    <Label for="email" value="Email" />
                    <InputIconWrapper>
                        <template #icon>
                            <MailIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="email" type="email" class="block w-full" placeholder="Email"
                            v-model="form.email" required autofocus autocomplete="username" />
                    </InputIconWrapper>
                </div>

                <div>
                    <Button class="justify-center gap-2 w-full" :disabled="form.processing"
                        v-slot="{ iconSizeClasses }">
                        <PaperAirplaneIcon aria-hidden="true" :class="iconSizeClasses" />
                        <span>Lien de réinitialisation du mot de passe </span>
                    </Button>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { MailIcon, PaperAirplaneIcon } from "@heroicons/vue/outline";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import Button from "@/Components/Button.vue";
import GuestLayout from "@/Layouts/Guest.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import { useSwalError, useSwalSuccess } from "@/Composables/alert";

defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"),
        {
            onSuccess: () => {
                useSwalSuccess(
                    "Email de reinitialisation envoyé avec succès."
                );
                form.reset();
            },
            onError: () => {
                useSwalError(
                    "Une erreur s'est produite, veuillez réessayer plus tard."
                );
            },
        });
};
</script>
