<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { store } from '../../actions/App/Http/Controllers/TaskController';

import InputError from '../../components/InputError.vue';
import Button from '../../components/ui/button/Button.vue';
import Input from '../../components/ui/input/Input.vue';
import Label from '../../components/ui/label/Label.vue';
import Textarea from '../../components/ui/textarea/Textarea.vue';
import tasks from '../../routes/tasks';

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
        title: 'Create',
        href: '#',
    },
];

defineProps<{
    options: { label: string; value: string }[];
}>();
</script>

<template>
    <Head title="Tasks Create" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto w-full max-w-5xl space-y-8 py-8">
            <h1 class="text-2xl font-bold">Create New Task</h1>
            <Form
                :action="store()"
                method="POST"
                v-slot="{ errors, processing }"
                resetOnSuccess
                class="space-y-4"
            >
                <div class="space-y-2">
                    <Label for="title">Title</Label>
                    <Input
                        id="title"
                        name="title"
                        type="text"
                        required
                        autofocus
                        placeholder="Task Title"
                    />
                    <InputError :message="errors.title" />
                </div>
                <div class="space-y-2">
                    <Label for="description">Description</Label>
                    <Textarea
                        id="description"
                        name="description"
                        type="text"
                        placeholder="Task Description"
                    />
                    <InputError :message="errors.description" />
                </div>
                <div class="space-y-2">
                    <Label for="due_date">Due Date</Label>
                    <Input
                        id="due_date"
                        name="due_date"
                        type="date"
                        placeholder="Task Due Date"
                    />
                    <InputError :message="errors.due_date" />
                </div>
                <div class="space-y-2">
                    <Label for="status">Status</Label>
                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-md border border-sidebar-border/70 bg-background px-3 py-2 focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:border-sidebar-border"
                    >
                        <option :value="null">Select a status...</option>
                        <option
                            v-for="option in options"
                            :key="option.value"
                            :value="option.value"
                        >
                            {{ option.label }}
                        </option>
                    </select>
                    <InputError :message="errors.status" />
                </div>
                <div class="mt-8 space-x-4 justify-self-end">
                    <Link :href="tasks.index().url">
                        <Button type="button" variant="ghost">Cancel</Button>
                    </Link>
                    <Button
                        class="disabled:cursor-not-allowed disabled:opacity-50"
                        type="submit"
                        :disabled="processing"
                    >
                        Create Task
                    </Button>
                </div>
            </Form>
        </div>
    </AppLayout>
</template>
