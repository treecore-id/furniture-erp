<template>
    <Head title="Create New Wood" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Alert Dialog: Archive & Delete -->
        <AlertDialog :open="isDialogOpen" @update:open="isDialogOpen = $event">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>
                        Form Validation
                    </AlertDialogTitle>
                    <AlertDialogDescription>
                        Please double check and complete the form!
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="isDialogOpen = false">Close</AlertDialogCancel>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
        <form @submit.prevent="submit" autocomplete="off">
            <div class="flex flex-col px-4 py-6 space-y-6">
                <HeadingSmall :button="true" :button-processing="new_project.processing" :recently-successful="new_project.recentlySuccessful" title="Create New Wood" description="Ensure your account is using a long, random password to stay secure" />
                <div class="grid grid-cols-1 lg:grid-cols-4 items-start gap-6 sticky top-0">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" name="name" v-model="new_project.name" type="text" class="mt-1 block w-full" :class="errors?.name ? 'border-red-400' : ''" placeholder="Name" />
                        <InputError :message="errors?.name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="client">Client</Label>
                        <Input id="client" name="client" type="text" class="mt-1 block w-full" placeholder="Client" />
                        <InputError :message="errors?.client" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="project_value">Project Value</Label>
                        <Input id="project_value" name="project_value" type="number" class="mt-1 block w-full" placeholder="Value" />
                        <InputError :message="errors?.project_value" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="date_start">Date Start</Label>
                        <Input id="date_start" name="date_start" type="text" class="mt-1 block w-full" placeholder="Value" />
                        <InputError :message="errors?.date_start" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="date_deadline">Target Date</Label>
                        <Input id="date_deadline" name="date_deadline" type="text" class="mt-1 block w-full" placeholder="Value" />
                        <InputError :message="errors?.date_deadline" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="address">Address</Label>
                        <Textarea id="address" name="address" type="text" rows="3" class="mt-1 block w-full" placeholder="Address" />
                        <InputError :message="errors?.address" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="description">Description</Label>
                        <Textarea id="description" name="description" type="text" rows="3" class="mt-1 block w-full" placeholder="Description" />
                        <InputError :message="errors?.description" />
                    </div>
                    <!-- <div class="grid gap-2">
                        <div class="flex items-center gap-4">
                            <Button :disabled="new_project.processing" class="cursor-pointer">Save</Button>
                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-show="new_project.recentlySuccessful" class="text-sm text-neutral-600">
                                    Saved.
                                </p>
                            </Transition>
                        </div>
                    </div> -->
                </div>
                <div class="w-full flex justify-end">
                    <Button @click="AddRow" type="button" class="cursor-pointer">Add Order</Button>
                </div>
                <div class="max-w-full h-[50dvh] overflow-auto">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-[5%] text-center">
                                    #
                                </TableHead>
                                <TableHead class="w-[20%]">
                                    Product
                                </TableHead>
                                <TableHead class="w-[15%]">
                                    Code
                                </TableHead>
                                <TableHead class="w-[10%]">
                                    CBM (m<sup>3</sup>)
                                </TableHead>
                                <TableHead class="w-[10%]">
                                    Unit Price
                                </TableHead>
                                <TableHead class="w-[10%]">
                                    Qty
                                </TableHead>
                                <TableHead class="w-[10%]">
                                    Total CBM (m<sup>3</sup>)
                                </TableHead>
                                <TableHead class="w-[10%]">
                                    Total Price
                                </TableHead>
                                <TableHead class="w-[10%] text-center">
                                    Action
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(item, index) in new_project.order_lists" :key="index">
                                <TableCell class="font-medium text-center">
                                    {{ index + 1 }}
                                </TableCell>
                                <TableCell class="text-left">
                                    <Input v-model="item.name" id="name" name="name" type="text" class="mt-1 block w-full" placeholder="Product Name" />
                                </TableCell>
                                <TableCell class="text-left">
                                    <Input v-model="item.product_code" id="product_code" name="product_code" type="text" class="mt-1 block w-full" placeholder="Product Code" />
                                </TableCell>
                                <TableCell class="text-left">
                                    <Input v-model="item.cbm" id="cbm" name="cbm" type="number" min="0" max="100" step="0.001" class="mt-1 block w-full" placeholder="cbm" />
                                </TableCell>
                                <TableCell class="text-left">
                                    <Input v-model="item.unit_price" id="unit_price" name="unit_price" type="number" min="0" max="1000000000" placeholder="0" />
                                </TableCell>
                                <TableCell class="text-left">
                                    <Input v-model="item.qty" id="qty" name="qty" type="number" min="0" max="100" class="mt-1 block w-full" placeholder="qty" />
                                </TableCell>
                                <TableCell class="text-left">
                                    {{ totalCBM.toFixed(3) }}
                                </TableCell>
                                <TableCell class="text-left">
                                    {{ formatRupiah(totalPrice) }}
                                </TableCell>
                                <TableCell class="text-center">
                                    <Button v-if="index != 0 || new_project.order_lists.length > 1" @click="RemoveRow" type="button" variant="outline" size="icon" class="text-gray-600 cursor-pointer hover:text-red-400">
                                        <Trash/>
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </form>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { type BreadcrumbItem } from '@/types';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useFormatters } from '@/composables/useHelpers';
import { computed, ref } from 'vue';
import { AlertDialog, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '@/components/ui/alert-dialog';

defineProps({ errors: Object })

interface Order {
    name: string;
    product_code: string;
    cbm: number;
    unit_price: number;
    qty: number;
    total_price: number;
}

interface Project {
    name: string;
    client: string;
    address: string;
    description: string;
    project_value: number;
    date_start: string;
    date_deadline: string;
    date_end: string;
    order_lists: Order[];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Project',
        href: '/project/create',
    },
];

const new_project = useForm<Project>({
    name: '',
    client: '',
    address: '',
    description: '',
    project_value: 0,
    date_start: '',
    date_deadline: '',
    date_end: '',
    order_lists: [{
        name: '',
        product_code: '',
        cbm: 0,
        unit_price: 0,
        qty: 0,
        total_price: 0,
    }]

});

const { formatRupiah } = useFormatters();

const isDialogOpen = ref(false);
// Computed properties
// const totalQty = computed(() => {
//     return new_project.order_lists.reduce((total, item) => total + item.qty, 0);
// });

const totalCBM = computed(() => {
    return new_project.order_lists.reduce((total, item) => total + (item.cbm * item.qty), 0);
});

const totalPrice = computed(() => {
    return new_project.order_lists.reduce((total, item) => total + (item.unit_price * item.cbm) * item.qty, 0);
});

// Row management
const AddRow = () => {
    new_project.order_lists.push({
        name: '',
        product_code: '',
        cbm: 0,
        unit_price: 0,
        qty: 0,
        total_price: 0,
    });
};

const RemoveRow = (index: number) => {
    if (new_project.order_lists.length > 1) {
        new_project.order_lists.splice(index, 1);
    }
};

const FormCheck = () => {
    return true;
}

// Submit Form
const submit = () => {
    if (FormCheck()) {
        new_project.post('/project', {
            onSuccess: () => {
                console.log('sending form..')
            }
        })
    } else {
        isDialogOpen.value = true
    }
}
</script>
