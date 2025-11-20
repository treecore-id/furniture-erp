<script setup lang="ts">
import { Button } from './ui/button';

interface Props {
    title: string;
    description?: string;
    button?: boolean;
    buttonProcessing?: boolean;
    recentlySuccessful?: boolean;
}

defineProps<Props>();
</script>

<template>
    <header class="flex flex-row justify-between items-center">
        <div class="flex flex-col space-y-1">
            <h3 class="text-base font-medium">{{ title }}</h3>
            <p v-if="description" class="text-sm text-muted-foreground">
                {{ description }}
            </p>
        </div>
        <div v-if="button">
            <Button :disabled="buttonProcessing" class="cursor-pointer">Save</Button>
            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                <p v-show="recentlySuccessful" class="text-sm text-neutral-600">
                    Saved.
                </p>
            </Transition>
        </div>
    </header>
</template>
