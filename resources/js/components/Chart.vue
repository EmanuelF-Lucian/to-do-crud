<script setup lang="ts">
import { Donut } from '@unovis/ts';
import { VisDonut, VisSingleContainer } from '@unovis/vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import type { ChartConfig } from '@/components/ui/chart';
import {
    ChartContainer,
    ChartTooltip,
    ChartTooltipContent,
    componentToString,
} from '@/components/ui/chart';

const props = defineProps<{
    stats: {
        total: number;
        pending: number;
        in_progress: number;
        completed: number;
    };
}>();

const chartData = [
    {
        status: 'pending',
        count: props.stats.pending,
        fill: 'var(--color-pending)',
    },
    {
        status: 'in_progress',
        count: props.stats.in_progress,
        fill: 'var(--color-in_progress)',
    },
    {
        status: 'completed',
        count: props.stats.completed,
        fill: 'var(--color-completed)',
    },
];
type Data = (typeof chartData)[number];

const chartConfig = {
    count: {
        label: 'Tasks',
        color: undefined,
    },
    pending: {
        label: 'Pending',
        color: 'var(--chart-1)',
    },
    in_progress: {
        label: 'In Progress',
        color: 'var(--chart-2)', // albastru
    },
    completed: {
        label: 'Completed',
        color: 'var(--chart-3)', // verde
    },
} satisfies ChartConfig;
</script>

<template>
    <Card class="flex flex-col">
        <CardHeader class="items-center pb-0">
            <CardTitle>Tasks by Status</CardTitle>
            <CardDescription>Current distribution</CardDescription>
        </CardHeader>
        <CardContent class="flex-1 pb-0">
            <ChartContainer
                :config="chartConfig"
                class="mx-auto aspect-square max-h-62.5"
            >
                <VisSingleContainer
                    :data="chartData"
                    :margin="{ top: 30, bottom: 30 }"
                >
                    <VisDonut
                        :value="(d: Data) => d.count"
                        :color="
                            (d: Data) =>
                                chartConfig[
                                    d.status as keyof typeof chartConfig
                                ].color
                        "
                        :arc-width="30"
                    />
                    <ChartTooltip
                        :triggers="{
                            [Donut.selectors.segment]: componentToString(
                                chartConfig,
                                ChartTooltipContent,
                                { hideLabel: true },
                            )!,
                        }"
                    />
                </VisSingleContainer>
            </ChartContainer>
        </CardContent>

        <!-- Legenda manuală -->
        <div class="flex justify-center gap-6 pb-4 text-sm">
            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-chart-1" />
                Pending ({{ stats.pending }})
            </div>
            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-chart-2" />
                In Progress ({{ stats.in_progress }})
            </div>
            <div class="flex items-center gap-2">
                <span class="h-3 w-3 rounded-full bg-chart-3" />
                Completed ({{ stats.completed }})
            </div>
        </div>
    </Card>
</template>
