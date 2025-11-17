<script setup lang="ts">
import ProjectController from '@/actions/App/Http/Controllers/ProjectController';
import AppLayout from '@/layouts/AppLayout.vue';
import { Form, Head } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Project',
        href: '/project/create',
    },
];
</script>

<template>
    <Head title="Project" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Create New Wood" />
        <div class="flex flex-col px-4 py-6 space-y-6">
            <HeadingSmall title="Create New Wood" description="Ensure your account is using a long, random password to stay secure" />
            <Form v-bind="ProjectController.store.form()" :options="{preserveScroll: true}" reset-on-success :reset-on-error="[ 'name', 'description']" v-slot="{ errors, processing, recentlySuccessful }" autocomplete="off">
                <div class="space-y-4 overflow-hidden">
                    <div class="flex flex-wrap space-y-6 mb-4 -mx-3 sticky top-0">
                        <div class="w-full px-3 lg:w-1/4 space-y-2">
                            <Label for="name">Name</Label>
                            <Input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="Name" />
                            <InputError :message="errors.name" />
                        </div>
                        <div class="w-full px-3 lg:w-1/4 space-y-2">
                            <Label for="client">Client</Label>
                            <Input id="client" name="client" type="text" class="mt-1 block w-full" placeholder="Client" />
                            <InputError :message="errors.client" />
                        </div>
                        <div class="w-full px-3 lg:w-1/4 space-y-2">
                            <Label for="address">Address</Label>
                            <Input id="address" name="address" type="text" class="mt-1 block w-full" placeholder="Address" />
                            <InputError :message="errors.address" />
                        </div>
                        <div class="w-full px-3 lg:w-1/4 space-y-2">
                            <Label for="project_value">Value</Label>
                            <Input id="project_value" name="project_value" type="text" class="mt-1 block w-full" placeholder="Value" />
                            <InputError :message="errors.project_value" />
                        </div>
                        <div class="w-full px-3 lg:w-1/4 space-y-2">
                            <Label for="project_value">Value</Label>

                            <InputError :message="errors.project_value" />
                        </div>
                        <div class="w-full px-3 lg:w-1/4 space-y-2">
                            <Label for="description">Description</Label>
                            <Textarea id="description" name="description" type="text" rows="5" class="mt-1 block w-full" placeholder="Description" />
                            <InputError :message="errors.description" />
                        </div>
                        <div class="w-full px-3 lg:w-1/4 space-y-2">
                            <div class="flex items-center gap-4">
                                <Button :disabled="processing" class="cursor-pointer">Save</Button>
                                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                    <p v-show="recentlySuccessful" class="text-sm text-neutral-600">
                                        Saved.
                                    </p>
                                </Transition>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-full h-[50dvh] overflow-auto">
                        <table class="w-full mb-20">
                            <thead>
                                <tr>
                                    <th class="sticky top-0 bg-gray-100 dark:bg-gray-900 px-4 py-3 text-left">
                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                            #
                                        </p>
                                    </th>
                                    <th class="sticky top-0 bg-gray-100 dark:bg-gray-900 px-4 py-3 text-left">
                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                            Product
                                        </p>
                                    </th>
                                    <th class="sticky top-0 bg-gray-100 dark:bg-gray-900 px-4 py-3 text-left">
                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                            Diameter (cm)
                                        </p>
                                    </th>
                                    <th class="sticky top-0 bg-gray-100 dark:bg-gray-900 px-4 py-3 text-left">
                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                            Harga
                                        </p>
                                    </th>
                                    <th class="sticky top-0 bg-gray-100 dark:bg-gray-900 px-4 py-3 text-left">
                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                            Qty
                                        </p>
                                    </th>
                                    <th class="sticky top-0 bg-gray-100 dark:bg-gray-900 px-4 py-3 text-left">
                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                            CBM (m<sup>3</sup>)
                                        </p>
                                    </th>
                                    <th class="sticky top-0 bg-gray-100 dark:bg-gray-900 px-4 py-3 text-left">
                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                            Total Harga
                                        </p>
                                    </th>
                                    <th class="sticky top-0 bg-gray-100 dark:bg-gray-900 px-4 py-3 text-left">
                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                            Aksi
                                        </p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr>
                                    <td colspan="9" class="border border-x-0 border-gray-100 px-4 py-3 dark:border-white/5">
                                        <p class="text-center text-sm text-gray-700 dark:text-gray-300">
                                            Pilih jenis dan bentuk kayu!
                                        </p>
                                    </td>
                                </tr> -->
                                <tr v-for="(value, index) in 10" :key="index" class="cursor-pointer hover:bg-gray-100 dark:hover:bg-white/5">
                                    <td class="border border-s-0 border-gray-100 px-4 py-3 dark:border-white/5">
                                        <p class="text-sm block text-gray-800 dark:text-gray-300">
                                            {{ index + 1 }}
                                        </p>
                                    </td>
                                    <td class="border border-gray-100 px-4 py-3 dark:border-white/5">
                                        <input type="number" step="1" min="0" placeholder="Enter wood length" class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                    </td>
                                    <td class="border border-gray-100 px-4 py-3 dark:border-white/5">
                                        <input type="number" step="1" min="0" placeholder="Enter wood diameter" class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                    </td>
                                    <td class="border border-gray-100 px-4 py-3 dark:border-white/5">
                                        <input type="number" step="1" min="1" max="1000000000" class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                    </td>
                                    <td class="border border-gray-100 px-4 py-3 dark:border-white/5">
                                        <input type="number" step="1" min="1" max="1000" class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                    </td>
                                    <td class="border border-gray-100 px-4 py-3 dark:border-white/5">
                                        <p class="text-sm block text-gray-800 dark:text-gray-300">
                                            item.cbm.toFixed(3)
                                        </p>
                                        <input type="number" step="0.001" min="0" class="hidden sr-only">
                                    </td>
                                    <td class="border border-gray-100 px-4 py-3 dark:border-white/5">
                                        <p class="text-sm block text-gray-800 dark:text-gray-300">
                                            formatRupiah(item.price * item.qty * item.cbm)
                                        </p>
                                    </td>
                                    <td class="border border-e-0 border-gray-100 px-4 py-3 dark:border-white/5">
                                        <button type="button" class="hover:text-error-500 dark:hover:text-error-500 text-gray-700 dark:text-gray-300">
                                            <svg class="fill-current" width="20" height="20" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.54142 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z" fill=""></path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </Form>
        </div>
    </AppLayout>
</template>
<!-- name
client
address
description
project_value
date_start
date_deadline -->
