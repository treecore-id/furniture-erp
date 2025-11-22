<template>
    <Head :title="data_wood.name " />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Form v-bind="WoodController.update.form(form_edit_wood)" :options="{preserveScroll: true}" :reset-on-error="[ 'name', 'description']" v-on:finish="editMode = false" v-slot="{ errors, processing, recentlySuccessful }" autocomplete="off">
            <div class="flex flex-col p-6">
                <section class="max-w-xl space-y-6">
                    <HeadingSmall :title="'Wood : ' + data_wood.name " description="Ensure your account is using a long, random password to stay secure" />
                    <div class="space-y-6">
                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input v-if="editMode" id="name" name="name" v-model="form_edit_wood.name" type="text" class="mt-1 block w-full" :class="errors.name ? 'border-red-500': ''" placeholder="Wood Name" />
                            <p v-else class="mt-1 block w-full leading-7 text-sm/relaxed">
                                {{ form_edit_wood.name }}
                            </p>
                            <InputError :message="errors.name" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="description">Description</Label>
                            <Textarea v-if="editMode" id="description" name="description" v-model="form_edit_wood.description" type="text" rows="5" class="mt-1 block w-full" :class="errors.description ? 'border-red-500': ''" placeholder="Description" />
                            <p v-else class="mt-1 block w-full leading-7 text-sm/relaxed">
                                {{ form_edit_wood.description }}
                            </p>
                            <InputError :message="errors.description" />
                        </div>
                        <div class="flex items-center gap-4">
                            <Button v-if="editMode" :disabled="processing" class="cursor-pointer">Save</Button>
                            <Button v-else @click="editMode = true" class="cursor-pointer">Edit</Button>
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-show="recentlySuccessful" class="text-sm text-neutral-600">
                                    Saved.
                                </p>
                            </Transition>
                        </div>
                    </div>
                </section>
            </div>
        </Form>
    </AppLayout>
</template>

<script setup lang="ts">
import WoodController from '@/actions/App/Http/Controllers/WoodController';
import AppLayout from '@/layouts/AppLayout.vue';
import { Form, Head, useForm, usePage } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { type BreadcrumbItem } from '@/types';
import { ref } from 'vue';

interface Wood {
    id: number;
    public_id: string;
    name: string;
    description: string;
}

const editMode = ref(false);
const data_wood = usePage().props.data_wood as Wood;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Wood',
        href: '/wood',
    },
    {
        title: data_wood.name,
        href: '#',
    }
];

const form_edit_wood = useForm<Wood>({
    id: parseInt(data_wood.public_id),
    public_id: data_wood.public_id,
    name: data_wood.name,
    description: data_wood.description
})
</script>
