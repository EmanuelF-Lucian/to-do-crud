<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Edit, Trash2 } from 'lucide-vue-next';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { create, edit, show } from '../routes/tasks';
import type { Task } from '../types/task';
import DeleteAlertDialog from './DeleteAlertDialog.vue';

defineProps<{
    tasks: Task[];
}>();

const deleteTask = (id: number) => {
    router.delete(`/tasks/${id}`);
};
</script>

<template>
    <Table class="border-collapse rounded-md border border-muted">
        <TableHeader>
            <TableRow>
                <TableHead>Title</TableHead>

                <TableHead>Status</TableHead>
                <TableHead>Due Date</TableHead>
                <TableHead class="text-right"> Actions </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-if="tasks.length === 0">
                <TableCell
                    colspan="4"
                    class="py-8 text-center text-lg text-muted-foreground"
                >
                    No tasks .
                    <Link :href="create()" class="underline">
                        You can create one here.
                    </Link>
                </TableCell>
            </TableRow>
            <TableRow v-for="task in tasks" :key="task.id">
                <TableCell>
                    <Link
                        :href="show(task.id)"
                        class="font-medium hover:underline"
                    >
                        {{ task.title }}
                    </Link>
                </TableCell>

                <TableCell>
                    <span :class="['rounded-full px-1', task.status_color]">
                        {{ task.status_label }}
                    </span></TableCell
                >
                <TableCell>{{ task.due_date }}</TableCell>
                <TableCell class="flex items-center justify-end text-right">
                    <Link :href="edit(task.id)" class="mr-2">
                        <Edit class="w-4 text-chart-2" />
                    </Link>
                    <DeleteAlertDialog @delete="deleteTask(task.id)">
                        <template #trigger>
                            <Trash2 class="w-4 text-destructive" />
                        </template>
                    </DeleteAlertDialog>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
