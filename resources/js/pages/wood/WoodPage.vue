<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Ellipsis } from 'lucide-vue-next';

interface Wood {
    id: number;
    public_id: string;
    name: string;
    description: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    page: number | null;
    active: boolean;
}

interface InertiaPaginated<T> {
    current_page: number;
    data: T[];
    links: PaginationLink[];
    total: number;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Wood',
        href: '/wood',
    },
];

const data_wood = usePage().props.data_wood as InertiaPaginated<Wood>;

onMounted(() => {
    console.log(data_wood)
})

const WoodArchive = (public_id: string) => {
    if (!confirm('Are you sure to delete?')) {
        return;
    } else {
        router.visit(`/wood/${public_id}/archive`, {
            method: 'patch',
            preserveState: true,
            only: ['data_wood'],
        });
    }
}
</script>

<template>
    <Head title="Wood" />

    <AppLayout :breadcrumbs="breadcrumbs" :button-text="'/wood/create'">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <Table>
                <TableCaption>
                    A list of your recent invoices.
                </TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[5%] text-center">
                            #
                        </TableHead>
                        <TableHead class="w-[15%]">
                            Name
                        </TableHead>
                        <TableHead class="w-[70%]">
                            Description
                        </TableHead>
                        <TableHead class="w-[10%] text-center">
                            Action
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-if="data_wood.data.length == 0">
                        <TableCell></TableCell>
                        <TableCell class="text-left text-gray-600 dark:text-gray-300" colspan="2">— data empty —</TableCell>
                        <TableCell></TableCell>
                    </TableRow>
                    <TableRow v-else v-for="(item, index) in data_wood.data" :key="index">
                        <TableCell class="font-medium text-center">
                            {{ index + 1 }}
                        </TableCell>
                        <TableCell class="text-left">
                            {{ item.name }}
                        </TableCell>
                        <TableCell class="text-left">
                            <p class="line-clamp-2 transition-all duration-300 ease-out">
                                {{ item.description }}
                            </p>
                        </TableCell>
                        <TableCell class="text-center">
                            <DropdownMenu>
                                <DropdownMenuTrigger>
                                    <Ellipsis class="text-gray-600 hover:cursor-pointer"/>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent>
                                    <DropdownMenuLabel>Actions</DropdownMenuLabel>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem>
                                        <Link :href="`/wood/${item.public_id}`" class="block w-full cursor-pointer">Details</Link>
                                    </DropdownMenuItem>
                                    <DropdownMenuItem>
                                        <Link @click.stop="WoodArchive(item.public_id)" as="button" class="block w-full text-left cursor-pointer">Archive</Link>
                                    </DropdownMenuItem>
                                    <DropdownMenuItem>Delete</DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>
