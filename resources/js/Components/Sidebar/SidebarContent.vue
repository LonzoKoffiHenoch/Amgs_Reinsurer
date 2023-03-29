<template>
    <PerfectScrollbar aria-label="main" class="relative flex flex-col flex-1 max-h-full gap-4 px-3" tagname="nav">
        <SidebarLink :active="route().current('dashboard')" :href="route('dashboard')" title="Accueil">
            <template #icon>
                <HomeAnalyticsIcon aria-hidden="true" class="flex-shrink-0 w-6 h-6"/>
            </template>
        </SidebarLink>
        <SidebarCollapsible :active="route().current('business*')" title="Affaires">
            <template #icon>
                <FolderFileIcon aria-hidden="true" class="flex-shrink-0 w-6 h-6"/>
            </template>
            <SidebarCollapsibleItem :active="route().current('business.index')" :href="route('business.index')"
                                    title="Liste des affaires"/>
            
            <SidebarCollapsibleItem :active="route().current('business.upload')" :href="route('business.upload')"
                                    title="Upload des affaires"/>
        </SidebarCollapsible>
        
        <SidebarLink :active="route().current('slip.*')" :href="route('slip.index')" title="Borderaux">
            <template #icon>
                <MonitorDashboardIcon aria-hidden="true" class="flex-shrink-0 w-6 h-6"/>
            </template>
        </SidebarLink>
        <!-- <SidebarCollapsible
            title="Finances"
            :active="route().current('transferor.*')"
        >
            <SidebarCollapsibleItem
                :href="route('transferor.index')"
                title="Liste des cedentes"
                :active="route().current('transferor.index')"
            />
            <SidebarCollapsibleItem
                :href="route('transferor.reas')"
                title="Liste des Reassureurs"
                :active="route().current('transferor.reas')"
            />
            <SidebarCollapsibleItem
                :href="route('transferor.paiement')"
                title="Paiements effectués"
                :active="route().current('transferor.paiement')"
            />
        </SidebarCollapsible> -->
        <SidebarCollapsible :active="route().current('pool*')" title="Convention">
            <template #icon>
                <FolderFileIcon aria-hidden="true" class="flex-shrink-0 w-6 h-6"/>
            </template>
            <SidebarCollapsibleItem :active="route().current('pool.index')" :href="route('pool.index')"
                                    title="Convention"/>
            
            <SidebarCollapsibleItem :active="route().current('pool.create')" :href="route('pool.create')"
                                    title="Créer une convention"/>
        </SidebarCollapsible>
        
        <SidebarLink v-if="$page.props.auth.permissions.includes('finance:show')"
                     :active="route().current('finance.index')" :href="route('finance.index')"
                     title="Finances">
            <template #icon>
                <FinanceIcon aria-hidden="true" class="flex-shrink-0 w-6 h-6"/>
            </template>
        </SidebarLink>
        
        
        <!-- {{ route().current('business.*') }} -->
        <SidebarCollapsible v-if="$page.props.auth.permissions.includes('setting:show')"
                            :active="route().current('setting*')"
                            title="Paramètres">
            <template #icon>
                <WindowShutterSettingsIcon aria-hidden="true" class="flex-shrink-0 w-6 h-6"/>
            </template>
            <SidebarCollapsibleItem :active="route().current('setting.activity')" :href="route('activity.index')"
                                    title="Activité"/>
            <SidebarCollapsibleItem :active="route().current('setting.bank')" :href="route('setting.bank')"
                                    title="Banque"/>
            <SidebarCollapsibleItem :active="route().current('setting.branche')" :href="route('setting.branche')"
                                    title="Branche"/>
            <!-- <SidebarCollapsibleItem
                :href="route('setting.transferor')"
                title="Cedante"
                :active="route().current('setting.transferor')"
            /> -->
            <!-- <SidebarCollapsibleItem
                :href="route('setting.country')"
                title="Pays"
                :active="route().current('setting.country')"
            /> -->
            <!-- <SidebarCollapsibleItem
                :href="route('setting.permission')"
                title="Permissions"
                :active="route().current('setting.permission')"
            /> -->
            <SidebarCollapsibleItem :active="route().current('setting.reinsurer')" :href="route('setting.reinsurer')"
                                    title="Reassureur"/>
            
            <SidebarCollapsibleItem :active="route().current('setting.password')" :href="route('setting.password')"
                                    title="Mot de passe"/>
            <SidebarCollapsibleItem :active="route().current('setting.role')" :href="route('setting.role')"
                                    title="Roles"/>
            <SidebarCollapsibleItem :active="route().current('setting.user')" :href="route('setting.user')"
                                    title="Utilisateurs"/>
        </SidebarCollapsible>
        <!-- <SidebarLink
            title="Affaires"
            :href="route('business.index')"
            :active="route().current('business.index')"
        >
            <template #icon>
                <TemplateIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
        </SidebarLink> -->
        
        <!-- <SidebarCollapsible
            title="Components"
            :active="route().current('components.*')"
        >
            <template #icon>
                <TemplateIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>

            <SidebarCollapsibleItem
                :href="route('components.buttons')"
                title="Buttons"
                :active="route().current('components.buttons')"
            />
        </SidebarCollapsible> -->
        
        <!-- Examples -->
        
        <!-- => External link example -->
        <!-- <SidebarLink
            title="Github"
            href="https://github.com/kamona-wd/kui-laravel-breeze"
            external
            target="_blank"
        >
        </SidebarLink> -->
        <!-- => Collapsible examples -->
    </PerfectScrollbar>
</template>

<script setup>
import PerfectScrollbar from "@/Components/PerfectScrollbar.vue";
import SidebarLink from "@/Components/Sidebar/SidebarLink.vue";
import {DashboardIcon} from "@/Components/Icons/outline";
import SidebarCollapsible from "@/Components/Sidebar/SidebarCollapsible.vue";
import SidebarCollapsibleItem from "@/Components/Sidebar/SidebarCollapsibleItem.vue";
import MonitorDashboardIcon from "vue-material-design-icons/MonitorDashboard.vue";
import HomeAnalyticsIcon from "vue-material-design-icons/HomeAnalytics.vue";
import SettingsHelperIcon from "vue-material-design-icons/SettingsHelper.vue";
import KeyboardSettingsIcon from "vue-material-design-icons/KeyboardSettings.vue";
import WindowShutterSettingsIcon from "vue-material-design-icons/WindowShutterSettings.vue";
import FinanceIcon from "vue-material-design-icons/Finance.vue";
import FolderFileIcon from "vue-material-design-icons/FolderFile.vue";

// const canShowParams = computed(() => usePage().props.value.auth.user.email=='ibrahima.meite@amgs.africa');
// console.log(email);

</script>
