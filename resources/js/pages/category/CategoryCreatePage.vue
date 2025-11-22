<template>
    <Head title="Create New Category" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Form v-bind="CategoryController.store.form()" :options="{preserveScroll: true}" reset-on-success reset-on-error v-slot="{ errors, processing, recentlySuccessful }" autocomplete="off">
            <div class="flex flex-col p-6">
                <section class="max-w-xl space-y-6">
                    <HeadingSmall title="Create New Category" description="Ensure your account is using a long, random password to stay secure" />
                    <div class="space-y-6">
                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input id="name" name="name" v-model="form.name" type="text" class="mt-1 block w-full" :class="errors.name ? 'border-red-500': ''" placeholder="Name" />
                            <InputError :message="errors.name || errors.slug" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="slug">Slug</Label>
                            <Input id="slug" name="slug" v-model="form.slug" type="text" class="mt-1 block w-full bg-accent focus-visible:ring-0 focus-visible:border-input cursor-no-drop" placeholder="Slug" readonly aria-readonly />
                        </div>
                        <div class="grid gap-2">
                            <Label for="parent_id">Parent</Label>
                            <Input id="parent_id" name="parent_id" :value="form.parent_id" type="hidden" class="sr-only hidden" />
                            <Popover v-model:open="open">
                                <PopoverTrigger as-child>
                                    <Button variant="outline" role="combobox" :aria-expanded="open" class="w-full justify-between">
                                        {{ selectedParentCategory?.name || "Select parent category..." }}
                                        <ChevronsUpDownIcon class="opacity-50" />
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent class="w-full p-0">
                                    <Command>
                                        <CommandInput placeholder="Search parent..." />
                                        <CommandList>
                                            <CommandEmpty>No category found.</CommandEmpty>
                                            <CommandGroup>
                                                <CommandItem value="" @select="(ev) => { selectCategory(null) }">None</CommandItem>
                                                <CommandItem v-for="item in data_category" :key="item.id" :value="item.id" @select="(ev) => { selectCategory(ev.detail.value as number) }">
                                                    {{ item.name }}
                                                    <CheckIcon :class="cn('ml-auto', value === item.id ? 'opacity-100' : 'opacity-0')" />
                                                </CommandItem>
                                            </CommandGroup>
                                        </CommandList>
                                    </Command>
                                </PopoverContent>
                            </Popover>
                            <p class="text-sm text-muted-foreground">
                                Optional. Categories, can have a hierarchy. You might have a Table category, and under that have children categories for Dining and Living Room.
                            </p>
                            <InputError :message="errors.parent_id" />
                        </div>
                        <div class="flex items-center gap-4">
                            <Button :disabled="processing" data-test="update-password-button" class="cursor-pointer">Save</Button>
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
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';
import AppLayout from '@/layouts/AppLayout.vue';
import { Form, Head, useForm, usePage } from '@inertiajs/vue3';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type BreadcrumbItem } from '@/types';
import { cn } from '@/lib/utils';
import { computed, ref, watch } from 'vue';
import { CheckIcon, ChevronsUpDownIcon } from 'lucide-vue-next';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList } from '@/components/ui/command';

interface Category {
    id: number;
    public_id: string;
    name: string;
    slug: string;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Wood',
        href: '/wood',
    },
    {
        title: 'Create New',
        href: '#',
    },
];

const open = ref(false);
const value = ref<number | null>(null);
const data_category = usePage().props.data_category as Category[];

const form = useForm({
    name: '',
    slug: '',
    parent_id: null as number | null,
})

const selectedParentCategory = computed(() =>
    data_category.find(category => category.id === value.value),
)
const selectCategory = (selectedValue: number | null) => {
    const new_parent_id = selectedValue == value.value ? null : selectedValue;
    value.value = new_parent_id;
    form.parent_id = new_parent_id;
    open.value = false;
}

watch(() => form.name, (new_name) => {
    form.slug = GenerateSlug(new_name);
})

const GenerateSlug = (text: string) => {
    if (!text) return '';
    return text.toLowerCase().trim().replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]+/g, '-').replace(/^-+|-+$/g, '');;
}
</script>

