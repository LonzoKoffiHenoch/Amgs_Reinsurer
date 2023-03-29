<template>
    <nav
        :class="[
            'sticky top-0 z-10 px-6 py-4 bg-white flex items-center justify-between transition-transform duration-500 dark:bg-dark-eval-1',
            {
                '-translate-y-full': scrolling.down,
                'translate-y-0': scrolling.up,
            },
        ]"
        aria-label="secondary"
    >
        <div class="flex items-center gap-2">
            <Button
                v-slot="{ iconSizeClasses }"
                class="md:hidden"
                iconOnly
                srText="Toggle dark mode"
                type="button"
                variant="secondary"
                @click="toggleDarkMode"
            >
                <MoonIcon
                    v-show="!isDark"
                    :class="iconSizeClasses"
                    aria-hidden="true"
                />
                <SunIcon
                    v-show="isDark"
                    :class="iconSizeClasses"
                    aria-hidden="true"
                />
            </Button>
        </div>
        <div class="flex items-center gap-2">
            <Button
                v-slot="{ iconSizeClasses }"
                class="hidden md:inline-flex"
                iconOnly
                srText="Toggle dark mode"
                type="button"
                variant="secondary"
                @click="toggleDarkMode"
            >
                <MoonIcon
                    v-show="!isDark"
                    :class="iconSizeClasses"
                    aria-hidden="true"
                />
                <SunIcon
                    v-show="isDark"
                    :class="iconSizeClasses"
                    aria-hidden="true"
                />
            </Button>
            
            <Button
                v-slot="{ iconSizeClasses }"
                class="hidden md:inline-flex"
                iconOnly
                srText="Toggle dark mode"
                type="button"
                variant="secondary"
                @click="toggleFullScreen"
            >
                <ArrowsExpandIcon
                    v-show="!isFullscreen"
                    :class="iconSizeClasses"
                    aria-hidden="true"
                />
                <ArrowsInnerIcon
                    v-show="isFullscreen"
                    :class="iconSizeClasses"
                    aria-hidden="true"
                />
            </Button>
            
            <!-- Dropdwon -->
            <Dropdown align="right" width="48">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button
                            class="
                                inline-flex
                                items-center
                                px-3
                                py-2
                                text-sm
                                font-medium
                                leading-4
                                text-gray-500
                                z-50
                                transition
                                duration-150
                                ease-in-out
                                bg-white
                                border border-transparent
                                rounded-md
                                hover:text-gray-700
                                focus:outline-none
                                focus:ring
                                focus:ring-primary
                                focus:ring-offset-1
                                focus:ring-offset-white
                                dark:focus:ring-offset-dark-eval-1
                                dark:bg-dark-eval-1
                                dark:text-gray-400
                                dark:hover:text-gray-200
                            "
                            type="button"
                        >
                            {{ $page.props.auth.user.name }}

                            <svg
                                class="ml-2 -mr-0.5 h-4 w-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    clip-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    fill-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </span>
                </template>
                <template #content>
                    <DropdownLink :href="route('password.request')" as="button">
                        Changer de mot de passe
                    </DropdownLink>
                    <DropdownLink
                        :href="route('logout')"
                        as="button"
                        method="post"
                    >
                        Deconnecter
                    </DropdownLink>
                </template>
            </Dropdown>
        </div>
    </nav>
    
    <!-- Mobile bottom bar -->
    <div
        :class="[
            'fixed inset-x-0 bottom-0 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white md:hidden dark:bg-dark-eval-1',
            {
                'translate-y-full': scrolling.down,
                'translate-y-0': scrolling.up,
            },
        ]"
    >
        <Button
            v-slot="{ iconSizeClasses }"
            iconOnly
            srText="Search"
            type="button"
            variant="secondary"
        >
            <SearchIcon :class="iconSizeClasses" aria-hidden="true"/>
        </Button>
        
        <Link :href="route('dashboard')">
            <ApplicationLogo class="w-10 h-10"/>
            <span class="sr-only">K UI</span>
        </Link>
        
        <Button
            v-slot="{ iconSizeClasses }"
            class="md:hidden"
            iconOnly
            srText="Search"
            type="button"
            variant="secondary"
            @click="sidebarState.isOpen = !sidebarState.isOpen"
        >
            <MenuIcon
                v-show="!sidebarState.isOpen"
                :class="iconSizeClasses"
                aria-hidden="true"
            />
            <XIcon
                v-show="sidebarState.isOpen"
                :class="iconSizeClasses"
                aria-hidden="true"
            />
        </Button>
    </div>
</template>

<script setup>
import {onMounted, onUnmounted} from "vue";
import {Link} from "@inertiajs/inertia-vue3";
import {useFullscreen} from "@vueuse/core";
import {ArrowsExpandIcon, MenuIcon, MoonIcon, SearchIcon, SunIcon, XIcon,} from "@heroicons/vue/outline";
import {handleScroll, isDark, scrolling, sidebarState, toggleDarkMode,} from "@/Composables";
import Button from "@/Components/Button.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import {ArrowsInnerIcon} from "@/Components/Icons/outline";

const {isFullscreen, toggle: toggleFullScreen} = useFullscreen();

onMounted(() => {
    document.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    document.removeEventListener("scroll", handleScroll);
});
</script>
