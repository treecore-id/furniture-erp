<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { edit } from '@/routes/appearance';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { useGlobalSettings } from '../store/globalSettings';
import AppLogoIcon from '@/components/AppLogoIcon.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Application settings',
        href: edit().url,
    },
];

const settings = useGlobalSettings;

const form = useForm({
    _method: 'put',
    company_name: settings.company_name,
    company_logo: null as File | null,
});

const submit = () => {
    form.post('/settings/apps', {
        preserveScroll: true,
        onSuccess: (response: any) => {
            form.company_name = form.data().company_name;
            form.company_logo = null;
            
            settings.company_name = form.company_name;
            const new_logo_url = response.props.flash.new_logo_url;

            if (new_logo_url) {
                settings.company_logo = new_logo_url;
            }
        }
    })
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Application settings" />
        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Application settings" description="Update your account's appearance settings" />
                <form @submit.prevent="submit" class="space-y-6" enctype="multipart/form-data">
                    <div class="grid gap-2">
                        <Label for="company_name">Company Name</Label>
                        <Input v-model="form.company_name" id="company_name" name="company_name" type="text" class="mt-1 block w-full" placeholder="Company Name" />
                        <InputError :message="form.errors.company_name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="company_logo">Company Logo</Label>
                        <div class="flex flex-row items-center space-x-6">
                            <div>
                                <Input @input="form.company_logo = $event.target.files[0]" id="company_logo" name="company_logo" type="file" class="mt-1 block w-full" placeholder="Company Logo" />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                            </div>
                            <div>
                                <div v-if="settings.company_logo != null" class="flex aspect-square size-12 items-center justify-center">
                                    <img :src="settings.company_logo" :alt="settings.company_name">
                                </div>
                                <div v-else class="flex aspect-square size-8 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground">
                                    <AppLogoIcon class="size-5 fill-current text-white dark:text-black" />
                                </div>
                            </div>
                        </div>
                        <InputError :message="form.errors.company_logo" />
                    </div>
                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing" class="cursor-pointer">Save</Button>
                        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">
                                Saved.
                            </p>
                        </Transition>
                    </div>
                </Form>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
