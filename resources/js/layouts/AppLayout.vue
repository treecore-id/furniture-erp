<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';
import { Toaster } from '@/components/ui/sonner';
import 'vue-sonner/style.css'
import { toast } from 'vue-sonner';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();

const processFlashMessage = (message: any) => {
    if (message?.success) {
        toast.success('Success', {
            description: message.success
        });
    }
    if (message?.error) {
        toast.error('Error', {
            description: message.error
        });
    }
};

onMounted(() => {
    processFlashMessage(page.props.flash);
});

watch(() => page.props.flash, (newMessage: any, oldMessage: any) => {
    console.log(oldMessage);
    processFlashMessage(newMessage);
}, { deep: true });

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
        <Toaster class="pointer-events-auto"></Toaster>
    </AppLayout>
</template>
