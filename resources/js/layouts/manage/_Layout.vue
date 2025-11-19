<script setup lang="ts">
</script>

<template>
    <div class="px-4 py-6">
        <div class="flex flex-col lg:flex-row lg:space-x-12">
            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
