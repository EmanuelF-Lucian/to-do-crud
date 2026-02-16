<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

import type { Task } from '../../types/task';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Tasks',
        href: '/tasks',
    },
    {
        title: 'Details',
        href: '#',
    },
];

defineProps<{
    task: Task;
}>();
</script>

<template>
    <Head title="Task Details" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <ul>
                <li>{{ task.title }}</li>
            </ul>
        </div>
    </AppLayout>
</template>
