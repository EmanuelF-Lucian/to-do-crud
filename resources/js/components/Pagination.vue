<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    links: { url: string | null; label: string; active: boolean }[];
}>();
</script>

<template>
    <div class="flex gap-1">
        <template v-for="link in links" :key="link.label">
            <Link
                v-if="link.url"
                :href="link.url"
                :class="[
                    'rounded border px-3 py-1 text-sm',
                    link.active
                        ? 'border-primary bg-primary text-white'
                        : 'border-border hover:bg-muted',
                ]"
                preserve-scroll
            >
                <span v-html="link.label" />
            </Link>
            <span
                v-else
                class="rounded border border-border px-3 py-1 text-sm opacity-40"
                v-html="link.label"
            />
        </template>
    </div>
</template>
