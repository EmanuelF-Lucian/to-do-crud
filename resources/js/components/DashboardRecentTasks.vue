<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { show } from '../routes/tasks';
import type { Task } from '../types/task';

defineProps<{
    tasks: Task[];
}>();
</script>

<template>
    <div
        class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
    >
        <h2 class="mb-4 text-lg font-semibold">Recent Tasks</h2>

        <div
            v-if="tasks.length === 0"
            class="py-8 text-center text-muted-foreground"
        >
            No tasks yet.
        </div>

        <div v-else class="divide-y divide-border">
            <div
                v-for="task in tasks"
                :key="task.id"
                class="flex items-center justify-between py-3"
            >
                <Link :href="show(task.id)" class="font-medium hover:underline">
                    {{ task.title }}
                </Link>
                <span
                    :class="[
                        'rounded-full px-2 py-1 text-xs font-medium',
                        task.status_color,
                    ]"
                >
                    {{ task.status_label }}
                </span>
            </div>
        </div>
    </div>
</template>
