<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { Edit, Trash2 } from 'lucide-vue-next';
import DeleteAlertDialog from '@/components/DeleteAlertDialog.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { edit, index } from '../../routes/tasks';

import type { Task } from '../../types/task';

const props = defineProps<{
    task: Task;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Tasks', href: index().url },
    { title: props.task.title, href: '#' },
];

const deleteTask = () => {
    router.delete(`/tasks/${props.task.id}`, {
        onSuccess: () => router.visit(index().url),
    });
};
</script>

<template>
    <Head title="Task Details" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto w-full max-w-3xl space-y-6 px-4 py-8">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">{{ task.title }}</h1>
            </div>

            <!-- Card detalii -->
            <div class="divide-y divide-border rounded-lg border border-border">
                <div class="flex items-center justify-between px-4 py-3">
                    <span class="text-sm text-muted-foreground">Status</span>
                    <span class="text-sm font-medium">{{
                        task.status_label
                    }}</span>
                </div>
                <div class="flex items-center justify-between px-4 py-3">
                    <span class="text-sm text-muted-foreground">Due Date</span>
                    <span class="text-sm font-medium">
                        {{ task.due_date ?? '—' }}
                    </span>
                </div>
                <div v-if="task.description" class="space-y-1 px-4 py-3">
                    <span class="text-sm text-muted-foreground"
                        >Description</span
                    >
                    <p class="text-sm">{{ task.description }}</p>
                </div>
            </div>

            <!-- Back -->
            <div class="flex items-center justify-between">
                <Link
                    :href="index().url"
                    class="text-sm text-muted-foreground hover:underline"
                >
                    ← Back to Tasks
                </Link>
                <div class="flex items-center gap-2">
                    <Link :href="edit(task.id).url">
                        <Button variant="outline" size="sm">
                            <Edit class="mr-1 h-4 w-4" />
                            Edit
                        </Button>
                    </Link>

                    <DeleteAlertDialog @delete="deleteTask">
                        <template #trigger>
                            <Button
                                variant="outline"
                                size="sm"
                                class="text-red-600"
                            >
                                <Trash2 class="mr-1 h-4 w-4" />
                                Delete
                            </Button>
                        </template>
                    </DeleteAlertDialog>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
