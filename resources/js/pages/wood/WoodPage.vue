<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import BasicTables from '@/components/table/BasicTables.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Wood',
        href: '/wood',
    },
];

const data_wood = usePage().props.data_wood as any;
</script>

<template>
    <Head title="Wood" />

    <AppLayout :breadcrumbs="breadcrumbs" :button-text="'/wood/create'">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <BasicTables :data_wood="data_wood" />
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
