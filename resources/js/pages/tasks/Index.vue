<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
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
    tasks: Task[];
}>();
</script>

<template>
    <Head title="Tasks" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <TasksTable :tasks="tasks" />
        </div>
    </AppLayout>
</template>
