<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { type NavMenu } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { Blocks, FolderOpen, Layers, LayoutGrid, Package } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const page = usePage();
const menu: NavMenu[] = [
    {
        label: 'Platform',
        permissions: 'staff',
        items: [
            {
                title: 'Dashboard',
                href: '/dashboard',
                icon: LayoutGrid,
            },
            {
                title: 'Project',
                href: '#',
                icon: FolderOpen,
                isActive: (page.url.split('/')[1] == 'project'),
                items: [
                    {
                        title: 'Lists',
                        href: '/project',
                    },
                    {
                        title: 'Create New',
                        href: '/project/create',
                    },
                    {
                        title: 'Archived',
                        href: '#',
                    },
                ]
            },
            {
                title: 'Product',
                href: '/product',
                icon: Package,
            },
        ]
    },
    {
        label: 'Manage',
        permissions: 'admin',
        items: [
            {
                title: 'Wood',
                href: '#',
                icon: Layers,
                isActive: (page.url.split('/')[1] == 'wood'),
                items: [
                    {
                        title: 'Lists',
                        href: '/wood',
                    },
                    {
                        title: 'Create New',
                        href: '/wood/create',
                    },
                    {
                        title: 'Archived',
                        href: '#',
                    },
                ]
            },
            {
                title: 'Category',
                href: '#',
                icon: Blocks,
                isActive: (page.url.split('/')[1] == 'category'),
                items: [
                    {
                        title: 'Lists',
                        href: '/category',
                    },
                    {
                        title: 'Create New',
                        href: '/category/create',
                    },
                    {
                        title: 'Archived',
                        href: '#',
                    },
                ]
            },
        ]
    }
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>
        <SidebarContent>
            <NavMain :menu-items="menu" />
        </SidebarContent>
        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
