<script setup lang="ts">
import { SearchIcon } from 'lucide-vue-next';
import Button from '@/components/ui/button/Button.vue';
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group';

defineProps<{
    search: string;
    status: string;
    options: { value: string; label: string }[];
}>();

const emit = defineEmits<{
    (e: 'update:search', value: string): void;
    (e: 'update:status', value: string): void;
}>();
</script>

<template>
    <div class="flex items-center gap-4 p-2">
        <!-- Search -->
        <InputGroup class="max-w-84">
            <InputGroupInput
                placeholder="Search..."
                :model-value="search"
                @input="emit('update:search', $event.target.value)"
            />
            <InputGroupAddon>
                <SearchIcon />
            </InputGroupAddon>
        </InputGroup>

        <!-- Status: All -->
        <Button
            :variant="status === '' ? 'default' : 'outline'"
            @click="emit('update:status', '')"
        >
            All
        </Button>

        <!-- Status: dynamic options -->
        <Button
            v-for="option in options"
            :key="option.value"
            :variant="status === option.value ? 'default' : 'outline'"
            @click="emit('update:status', option.value)"
        >
            {{ option.label }}
        </Button>
    </div>
</template>
