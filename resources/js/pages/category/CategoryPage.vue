<template>
    <Head title="Category" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Alert Dialog: Archive & Delete -->
        <AlertDialog :open="isDialogOpen" @update:open="isDialogOpen = $event">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>
                        Are you sure?
                    </AlertDialogTitle>
                    <AlertDialogDescription>
                        <template v-if="actionType === 'destroy'">
                            you want to delete it?
                        </template>
                        <template v-else-if="actionType === 'archive'">
                            you want to archive it?
                        </template>
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="isDialogOpen = false">Cancel</AlertDialogCancel>
                    <AlertDialogAction @click="handleConfirmationAction">
                        {{ actionType === 'destroy' ? 'Delete' : 'Archive' }}
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-6">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[5%] text-center">
                            #
                        </TableHead>
                        <TableHead class="w-[30%]">
                            Name
                        </TableHead>
                        <TableHead class="w-[30%]">
                            Slug
                        </TableHead>
                        <TableHead class="w-[25%]">
                            Parent
                        </TableHead>
                        <TableHead class="w-[10%] text-center">
                            Action
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-if="data_category.data.length == 0">
                        <TableCell></TableCell>
                        <TableCell class="text-left text-gray-600 dark:text-gray-300" colspan="2">— data is empty —</TableCell>
                        <TableCell></TableCell>
                    </TableRow>
                    <TableRow v-else v-for="(item, index) in data_category.data" :key="index">
                        <TableCell class="font-medium text-center">
                            {{ index + 1 }}
                        </TableCell>
                        <TableCell class="text-left">
                            {{ item.name }}
                        </TableCell>
                        <TableCell class="text-left">
                            {{ item.slug }}
                        </TableCell>
                        <TableCell class="text-left">
                            {{ item.parent ? item.parent.name : '-' }}
                        </TableCell>
                        <TableCell class="text-center">
                            <DropdownMenu>
                                <DropdownMenuTrigger>
                                    <Ellipsis class="text-gray-600 hover:cursor-pointer"/>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end">
                                    <DropdownMenuLabel>Actions</DropdownMenuLabel>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem>
                                        <Link :href="`/category/${item.public_id}`" class="block w-full cursor-pointer px-2 py-1.5">Details</Link>
                                    </DropdownMenuItem>
                                    <DropdownMenuItem>
                                        <button @click="triggerConfirmation(item.public_id, 'archive')" type="button" class="block w-full text-left cursor-pointer px-2 py-1.5">Archive</button>
                                    </DropdownMenuItem>
                                    <DropdownMenuItem>
                                        <button @click="triggerConfirmation(item.public_id, 'destroy')" type="button" class="block w-full text-left cursor-pointer px-2 py-1.5">Delete</button>
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
            <!-- Pagination -->
            <Pagination v-slot="{ page }" @update:page="handlePageChange" :items-per-page="data_category.per_page" :total="data_category.total" :default-page="data_category.current_page">
                <PaginationContent v-slot="{ items }">
                    <PaginationPrevious />
                    <template v-for="(item, index) in items" :key="index">
                        <PaginationItem v-if="item.type === 'page'" :value="item.value" :is-active="item.value === page">
                            {{ item.value }}
                        </PaginationItem>
                    </template>
                    <PaginationEllipsis v-if="data_category.links.length > 5" :index="4" />
                    <PaginationNext />
                </PaginationContent>
            </Pagination>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { Ellipsis } from 'lucide-vue-next';
import { ref } from 'vue';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle
} from '@/components/ui/alert-dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger
} from '@/components/ui/dropdown-menu';
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious
} from '@/components/ui/pagination';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow
} from '@/components/ui/table';

interface Category {
    id: number;
    public_id: string;
    name: string;
    slug: string;
    parent_id: number;
    parent: Category;
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
    per_page: number;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Category',
        href: '#',
    },
];

const props = defineProps<{
    data_category: InertiaPaginated<Category>
}>();

const isDialogOpen = ref(false);
const actionType = ref<'archive' | 'destroy' | null>(null);
const targetPublicId = ref<string | null>(null);
const data_category = ref<InertiaPaginated<Category>>(props.data_category);

const handlePageChange = (page: number) => {
    router.get('/category', { page: page }, {
            only: ['data_category'],
            preserveScroll: true,
        }
    );
};

const triggerConfirmation = (publicId: string, type: 'archive' | 'destroy') => {
    targetPublicId.value = publicId;
    actionType.value = type;
    isDialogOpen.value = true;
};

const handleConfirmationAction = () => {
    isDialogOpen.value = false;

    if (!targetPublicId.value || !actionType.value) return;

    const public_id = targetPublicId.value;
    const type = actionType.value;

    if (type === 'archive') {
        router.patch(`/category/${public_id}/archive`, {}, {
            preserveScroll: true,
            onSuccess: (page: any) => {
                if (page.props.data_category) {
                    data_category.value = page.props.data_category
                }
            }
        });
    } else if (type === 'destroy') {
        router.delete(`/category/${public_id}`, {
            preserveState: true,
            onSuccess: (page: any) => {
                if (page.props.data_category) {
                    data_category.value = page.props.data_category
                }
            }
        });
    }

    targetPublicId.value = null;
    actionType.value = null;
};
</script>
