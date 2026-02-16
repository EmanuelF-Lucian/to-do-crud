<script setup lang="ts">
import { Form, Head, Link, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';

import Button from '../../components/ui/button/Button.vue';
import Input from '../../components/ui/input/Input.vue';
import Label from '../../components/ui/label/Label.vue';
import tasks from '../../routes/tasks';
import type { Task } from '../../types/task';

const props = defineProps<{
    options: { label: string; value: string }[];
    task: Task;
}>();

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
        title: 'Edit Task',
        href: '#',
    },
];

const form = useForm({
    title: props.task.title,
    description: props.task.description,
    due_date: props.task.due_date,
    status: props.task.status,
});
</script>

<template>
    <Head title="Edit Task" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto w-full max-w-5xl space-y-8 py-8">
            <h1 class="text-2xl font-bold">Edit Task</h1>
            <Form
                :action="`/tasks/${props.task.id}`"
                method="PUT"
                class="space-y-4"
            >
                <div class="space-y-2">
                    <Label for="title">Title</Label>
                    <Input
                        id="title"
                        v-model="form.title"
                        name="title"
                        type="text"
                        placeholder="Task Title"
                    />
                </div>
                <div class="space-y-2">
                    <Label for="description">Description</Label>
                    <Input
                        id="description"
                        v-model="form.description"
                        name="description"
                        type="text"
                        placeholder="Task Description"
                    />
                </div>
                <div class="space-y-2">
                    <Label for="due_date">Due Date</Label>
                    <Input
                        id="due_date"
                        v-model="form.due_date"
                        name="due_date"
                        type="date"
                        placeholder="Task Due Date"
                    />
                </div>
                <div class="space-y-2">
                    <Label for="status">Status</Label>
                    <select
                        id="status"
                        v-model="form.status"
                        name="status"
                        class="w-full rounded-md border border-sidebar-border/70 bg-background px-3 py-2 focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:border-sidebar-border"
                    >
                        <option
                            v-for="option in props.options"
                            :key="option.value"
                            :value="option.value"
                        >
                            {{ option.label }}
                        </option>
                    </select>
                </div>
                <div class="mt-8 space-x-4 justify-self-end">
                    <Link :href="tasks.index().url">
                        <Button type="button" variant="ghost">Cancel</Button>
                    </Link>
                    <Button type="submit">Update Task</Button>
                </div>
            </Form>
        </div>
    </AppLayout>
</template>
