<script setup lang="ts">
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import DropdownMenu from '../ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '../ui/dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '../ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuLabel from '../ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuSeparator from '../ui/dropdown-menu/DropdownMenuSeparator.vue';
import DropdownMenuItem from '../ui/dropdown-menu/DropdownMenuItem.vue';
import { Ellipsis } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';

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

const props = defineProps<{
    data_wood: InertiaPaginated<Wood>,
}>();

onMounted(() => {
    console.log(props.data_wood)
})
</script>

<template>
    <Table>
        <TableCaption>A list of your recent invoices.</TableCaption>
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
            <TableRow v-if="props.data_wood.data.length == 0">
                <TableCell></TableCell>
                <TableCell class="text-left text-gray-600 dark:text-gray-300" colspan="2">— data empty —</TableCell>
                <TableCell></TableCell>
            </TableRow>
            <TableRow v-else v-for="(item, index) in props.data_wood.data" :key="index">
                <TableCell class="font-medium text-center">
                    {{ index + 1 }}
                </TableCell>
                <TableCell class="text-left">
                    {{ item.name }}
                </TableCell>
                <TableCell class="text-left">
                    <p class="line-clamp-2 hover:line-clamp-none transition-all duration-300 ease-out">
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
                                <Link :href="`/wood/${item.public_id}/edit`" class="block w-full cursor-pointer">Edit</Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem>Delete</DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
