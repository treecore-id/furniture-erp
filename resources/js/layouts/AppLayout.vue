<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { watch } from 'vue';
import { Toaster } from '@/components/ui/sonner';
import 'vue-sonner/style.css'
import { toast } from 'vue-sonner';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    buttonText?: string;
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();

watch(() => page.props.flash, (message: any) => {
    if (message?.success) {
        toast.success(message.success, {
            description: message.success
        });
    }
    if (message?.error) {
        toast.error(message.console.error, {
            description: message.console.error
        });
    }
}, { immediate: true, deep: true });
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" :button-text="buttonText">
        <slot />
        <Toaster class="pointer-events-auto"></Toaster>
    </AppLayout>
</template>
