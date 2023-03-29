<template>
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between ">
        <h2 class="text-3xl font-bold leading-tight">Dashboard</h2>
    </div>
    
    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 ">
        Bienvenue! <span class="font-bold">{{ $page.props.auth.user.name }}</span>
    </div>
    <main>
        <div
            class="mt-4 grid grid-cols-12 gap-4 px-[var(--margin-x)] transition-all duration-[.25s] sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
            
            <div class="col-span-12 lg:col-span-4 sm:col-span-12">
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-5 lg:grid-cols-2">
                    <div class="rounded-lg bg-white p-4 dark:bg-dark-eval-1">
                        <div class="flex justify-between space-x-1">
                            <p
                                class="text-xl font-semibold text-slate-700 dark:text-navy-100"
                            >
                                $67.6k
                            </p>
                            <svg
                                class="h-5 w-5 text-primary dark:text-accent"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Income</p>
                    </div>
                    <div class="rounded-lg bg-white p-4 dark:bg-dark-eval-1">
                        <div class="flex justify-between">
                            <p
                                class="text-xl font-semibold text-slate-700 dark:text-navy-100"
                            >
                                12.6K
                            </p>
                            <svg
                                class="h-5 w-5 text-success"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Completed</p>
                    </div>
                    <div class="rounded-lg bg-white p-4 dark:bg-dark-eval-1">
                        <div class="flex justify-between">
                            <p
                                class="text-xl font-semibold text-slate-700 dark:text-navy-100"
                            >
                                143
                            </p>
                            <svg
                                class="h-5 w-5 text-warning"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Pending</p>
                    </div>
                    <div class="rounded-lg bg-white p-4 dark:bg-dark-eval-1">
                        <div class="flex justify-between">
                            <p
                                class="text-xl font-semibold text-slate-700 dark:text-navy-100"
                            >
                                651
                            </p>
                            <svg
                                class="h-5 w-5 text-info"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                                <path
                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Dispatch</p>
                    </div>
                    <div class="rounded-lg bg-white p-4 dark:bg-dark-eval-1">
                        <div class="flex justify-between space-x-1">
                            <p
                                class="text-xl font-semibold text-slate-700 dark:text-navy-100"
                            >
                                46k
                            </p>
                            <svg
                                class="h-5 w-5 text-secondary"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Products</p>
                    </div>
                    <div class="rounded-lg bg-white p-4 dark:bg-dark-eval-1">
                        <div class="flex justify-between">
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                8.8k
                            </p>
                            <svg
                                class="h-5 w-5 text-error"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Customers</p>
                    </div>
                </div>
            </div>
            <Project/>
        
        </div>
    </main>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";

export default {
    layout: AuthenticatedLayout,
};
</script>

<script setup>
import {
    useSwalSuccess
} from "../Composables/alert";
import {computed} from 'vue'
import {usePage} from "@inertiajs/inertia-vue3";
import Project from "@/Pages/Dashboard/Project.vue";

const errors = computed(() => usePage().props.value.errors);
if (Object.keys(errors.value).length > 0) {
    useSwalSuccess("Vous êtes déja connecté");
}
console.log(Object.keys(errors.value).length > 0);
</script>
