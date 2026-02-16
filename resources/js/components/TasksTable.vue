<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Edit, Trash2Icon } from 'lucide-vue-next';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import type { Task } from '../types/task';

defineProps<{
    tasks: Task[];
}>();
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead>Title</TableHead>

                <TableHead>Status</TableHead>
                <TableHead>Due Date</TableHead>
                <TableHead class="text-right"> Actions </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="task in tasks" :key="task.id">
                <TableCell>{{ task.title }}</TableCell>

                <TableCell>{{ task.status }}</TableCell>
                <TableCell>{{ task.due_date }}</TableCell>
                <TableCell
                    class="flex items-center justify-end gap-4 text-right"
                >
                    <Link :href="`/tasks/${task.id}/edit`" class="mr-2">
                        <Edit class="w-4 text-green-600" />
                    </Link>
                    <Link
                        :href="`/tasks/${task.id}`"
                        method="delete"
                        as="button"
                    >
                        <Trash2Icon class="w-4 text-red-600" />
                    </Link>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
