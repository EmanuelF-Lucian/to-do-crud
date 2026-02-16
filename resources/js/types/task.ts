import type { User } from './auth';

export type TaskStatus = 'pending' | 'in_progress' | 'completed';

export interface Task {
    id: number;
    title: string;
    description: string;
    due_date: string; // ISO date string
    status: TaskStatus;
    user_id: number;
    created_at: string; // ISO date string
    updated_at: string; // ISO date string
    user: User;
}
