<script setup lang="ts">
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';
import { urlIsActive } from '@/lib/utils';
import { type NavMenu, NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from './ui/collapsible';
import { ChevronRight } from 'lucide-vue-next';

defineProps<{
    menuItems: NavMenu[];
    mainItems?: NavItem[];
    secondaryItems?: NavItem[];
}>();

const page = usePage();
</script>

<template>
    <SidebarGroup v-for="item in menuItems" :key="item.label" class="px-2 py-0">
        <SidebarGroupLabel>{{ item.label }}</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="subItem in item.items" :key="subItem.title">
                <SidebarMenuButton v-if="!subItem.items?.length" as-child :is-active="urlIsActive(subItem.href, page.url)" :tooltip="subItem.title">
                    <Link :href="subItem.href">
                        <component :is="subItem.icon" />
                        <span>{{ subItem.title }}</span>
                    </Link>
                </SidebarMenuButton>
                <Collapsible v-if="subItem.items?.length" as-child class="group/collapsible" :default-open="subItem.isActive" :tooltip="subItem.title">
                    <CollapsibleTrigger as-child>
                        <SidebarMenuButton :is-active="subItem.isActive" :tooltip="subItem.title">
                            <component :is="subItem.icon" v-if="subItem.icon" />
                            <span>{{ subItem.title }}</span>
                            <ChevronRight class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                        </SidebarMenuButton>
                    </CollapsibleTrigger>
                    <CollapsibleContent>
                        <SidebarMenuSub>
                            <SidebarMenuSubItem v-for="subsubItem in subItem.items" :key="subsubItem.title">
                                <SidebarMenuSubButton as-child :is-active="urlIsActive(subsubItem.href, page.url)">
                                    <Link :href="subsubItem.href">
                                        <span>{{ subsubItem.title }}</span>
                                    </Link>
                                </SidebarMenuSubButton>
                            </SidebarMenuSubItem>
                        </SidebarMenuSub>
                    </CollapsibleContent>
                </Collapsible>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
