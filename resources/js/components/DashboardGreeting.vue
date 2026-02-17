<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { show } from '../routes/tasks';

defineProps<{
    name: string;
    deadlines: {
        today: number;
        tomorrow: number;
        today_tasks: { id: number; title: string }[];
        tomorrow_tasks: { id: number; title: string }[];
    };
}>();
</script>

<template>
    <div
        class="flex h-full flex-col justify-center gap-4 rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
    >
        <h2 class="text-2xl font-bold">Welcome back, {{ name }}!</h2>

        <!-- Azi -->
        <template v-if="deadlines.today > 0">
            <p class="text-muted-foreground">
                You have
                <span class="font-semibold text-red-500">{{
                    deadlines.today
                }}</span>
                {{ deadlines.today === 1 ? 'task' : 'tasks' }} due today:
            </p>
            <ul class="space-y-1">
                <li
                    v-for="task in deadlines.today_tasks"
                    :key="task.id"
                    class="flex items-center gap-2 text-sm"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-red-500" />
                    <Link :href="show(task.id)" class="hover:underline">
                        {{ task.title }}
                    </Link>
                </li>
            </ul>
        </template>

        <!-- Maine -->
        <template v-else-if="deadlines.tomorrow > 0">
            <p class="text-muted-foreground">
                No deadlines today, but
                <span class="font-semibold text-yellow-500">{{
                    deadlines.tomorrow
                }}</span>
                {{ deadlines.tomorrow === 1 ? 'task is' : 'tasks are' }} due
                tomorrow:
            </p>
            <ul class="space-y-1">
                <li
                    v-for="task in deadlines.tomorrow_tasks"
                    :key="task.id"
                    class="flex items-center gap-2 text-sm"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-yellow-500" />
                    <Link :href="show(task.id)" class="hover:underline">
                        {{ task.title }}
                    </Link>
                </li>
            </ul>
        </template>

        <!-- Niciun deadline -->
        <template v-else>
            <p class="text-muted-foreground">
                No upcoming deadlines. You're all caught up! 🎉
            </p>
        </template>
    </div>
</template>
