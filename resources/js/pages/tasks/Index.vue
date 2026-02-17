<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { onBeforeUnmount, ref, watch } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import Pagination from '../../components/Pagination.vue';

import TaskFilters from '../../components/TaskFilters.vue';
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

const props = defineProps<{
    tasks: {
        data: Task[];
        links: { url: string | null; label: string; active: boolean }[];
    };
    options: { value: string; label: string }[];
    filters: {
        search: string;
        status?: string;
    };
}>();

const search = ref(props.filters.search ?? '');
const status = ref(props.filters.status ?? '');

const applyFilters = (overrides: Record<string, string> = {}) => {
    router.get(
        '/tasks',
        {
            search: search.value,
            status: status.value,
            ...overrides,
        },
        {
            preserveState: true,
            replace: true,
            preserveScroll: true,
            only: ['tasks'],
        },
    );
};

const debouncedFilter = debounce(() => applyFilters(), 500);

watch(search, () => debouncedFilter(), { flush: 'post' });

onBeforeUnmount(() => debouncedFilter.cancel());

const setStatus = (value: string) => {
    status.value = value;
    applyFilters();
};
</script>

<template>
    <Head title="Tasks" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-8 p-4">
            <TaskFilters
                :search="search"
                :status="status"
                :options="options"
                @update:search="(value) => (search = value)"
                @update:status="(value) => setStatus(value)"
            />

            <TasksTable :tasks="tasks.data" />

            <div class="mt-4 justify-self-end">
                <Pagination :links="tasks.links" />
            </div>
        </div>
    </AppLayout>
</template>
