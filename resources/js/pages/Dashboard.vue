<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import Chart from '../components/Chart.vue';
import DashboardGreeting from '../components/DashboardGreeting.vue';
import DashboardRecentTasks from '../components/DashboardRecentTasks.vue';
import type { Task } from '../types/task';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

defineProps<{
    stats: {
        total: number;
        pending: number;
        in_progress: number;
        completed: number;
    };
    recent_tasks: Task[];
    deadlines: {
        today: number;
        tomorrow: number;
        today_tasks: Task[];
        tomorrow_tasks: Task[];
    };
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-max gap-4 md:grid-cols-2">
                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <DashboardGreeting
                        :name="$page.props.auth.user.name"
                        :deadlines="deadlines"
                    />
                </div>

                <div
                    class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <Chart :stats="stats" />
                </div>
            </div>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <DashboardRecentTasks :tasks="recent_tasks" />
            </div>
        </div>
    </AppLayout>
</template>
