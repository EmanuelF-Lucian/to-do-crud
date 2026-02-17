<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import Pagination from '../../components/Pagination.vue';
import TasksTable from '../../components/TasksTable.vue';
import type { Task } from '../../types/task';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Tasks',
        href: '#',
    },
];

defineProps<{
    tasks: {
        data: Task[];
        links: { url: string | null; label: string; active: boolean }[];
    };
}>();
</script>

<template>
    <Head title="Tasks" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <TasksTable :tasks="tasks.data" />
            <div class="mt-4 justify-self-end">
                <Pagination :links="tasks.links" />
            </div>
        </div>
    </AppLayout>
</template>
