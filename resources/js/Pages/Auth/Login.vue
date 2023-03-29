<template>
    <div class="flex flex-row">
        <div class="flex flex-grow flex-shrink-0 justify-between">
            <div class="image w-1/2 p-0 m-0 object-cover">
                <img src="public/images/Broker.png" alt="" class="self-center m-auto object-cover" />
            </div>
            <div class="w-1/2">
                <GuestLayout title="Log in">
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit">
                        <div class="grid gap-6">
                            <div class="space-y-2">
                                <Label for="username" value="Nom d'utlisateur" />
                                <InputIconWrapper>
                                    <template #icon>
                                        <MailIcon aria-hidden="true" class="w-5 h-5" />
                                    </template>
                                    <Input withIcon id="username" type="text" class="block w-full normal-case"
                                        placeholder="Entrez votre nom d'utlisateur" v-model="form.username" required
                                        autofocus autocomplete="username" />
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
                                        autocomplete="current-password" />
                                </InputIconWrapper>
                            </div>

                            <div class="flex items-center justify-between">
                                <label class="flex items-center">
                                    <Checkbox name="remember" v-model:checked="form.remember" />
                                    <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                                </label>

                                <Link v-if="canResetPassword" :href="route('password.request')" class="
                                        text-sm text-blue-500
                                        hover:underline
                                    ">
                                Mot de passe oublié?
                                </Link>
                            </div>

                            <div>
                                <Button class="justify-center gap-2 w-full" :disabled="form.processing"
                                    v-slot="{ iconSizeClasses }">
                                    <LoginIcon aria-hidden="true" :class="iconSizeClasses" />
                                    <span>Log in</span>
                                </Button>
                            </div>
                        </div>
                    </form>
                </GuestLayout>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { MailIcon, LockClosedIcon, LoginIcon } from "@heroicons/vue/outline";
import InputIconWrapper from "@/Components/InputIconWrapper.vue";
import Button from "@/Components/Button.vue";
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/Guest.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import ValidationErrors from "@/Components/ValidationErrors.vue";
import { useSwalError } from "@/Composables/alert";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    username: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onError: () => {
            useSwalError(
                "Une erreur s'est produite, veuillez réessayer plus tard."
            );
        },
    });
};
</script>
