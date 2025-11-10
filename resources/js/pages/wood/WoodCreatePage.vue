<script setup lang="ts">
import WoodController from '@/actions/App/Http/Controllers/WoodController';
import AppLayout from '@/layouts/AppLayout.vue';
import WoodLayout from '@/layouts/wood/Layout.vue';
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
        title: 'Wood',
        href: '/wood/create',
    },
];
</script>

<template>
    <Head title="Wood" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Create New Wood" />
        <WoodLayout>
            <div class="space-y-6">
                <HeadingSmall title="Create New Wood" description="Ensure your account is using a long, random password to stay secure" />
                <Form v-bind="WoodController.store.form()" :options="{preserveScroll: true}" reset-on-success :reset-on-error="[ 'name', 'description']" class="space-y-6" v-slot="{ errors, processing, recentlySuccessful }">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="Wood Name" />
                        <InputError :message="errors.name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="description">Description</Label>
                        <Textarea id="description" name="description" type="text" class="mt-1 block w-full" placeholder="Description" />
                        <InputError :message="errors.description" />
                    </div>
                    <div class="flex items-center gap-4">
                        <Button :disabled="processing" data-test="update-password-button">Save</Button>
                        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                            <p v-show="recentlySuccessful" class="text-sm text-neutral-600">
                                Saved.
                            </p>
                        </Transition>
                    </div>
                </Form>
            </div>
        </WoodLayout>
    </AppLayout>
</template>
