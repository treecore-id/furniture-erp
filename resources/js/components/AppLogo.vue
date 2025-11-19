<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { useGlobalSettings } from '@/pages/store/globalSettings';

const settings = useGlobalSettings;
</script>

<template>
    <div v-if="settings.company_logo != null" class="flex aspect-square size-8 items-center justify-center">
        <img :src="settings.company_logo" :alt="settings.company_name">
    </div>
    <div v-else class="flex aspect-square size-8 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground">
        <AppLogoIcon class="size-5 fill-current text-white dark:text-black" />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="truncate leading-tight font-semibold">
            {{ settings.company_name }}
        </span>
    </div>
</template>
