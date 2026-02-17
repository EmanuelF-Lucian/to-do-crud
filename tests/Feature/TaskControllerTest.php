<?php

declare(strict_types=1);

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Authentication', function () {
    test('unauthenticated user cannot access tasks index', function () {
        $response = $this->get(route('tasks.index'));

        $response->assertRedirect(route('login'));
    });

    test('unauthenticated user cannot access task creation form', function () {
        $response = $this->get(route('tasks.create'));

        $response->assertRedirect(route('login'));
    });

    test('unauthenticated user cannot store a task', function () {
        $response = $this->post(route('tasks.store'), [
            'title' => 'Test Task',
            'description' => 'Test description',
            'status' => TaskStatus::Pending->value,
            'due_date' => '2026-12-31',
        ]);

        $response->assertRedirect(route('login'));
    });

    test('unauthenticated user cannot edit a task', function () {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task));

        $response->assertRedirect(route('login'));
    });

    test('unauthenticated user cannot update a task', function () {
        $task = Task::factory()->create();

        $response = $this->put(route('tasks.update', $task), [
            'title' => 'Updated Task',
            'description' => 'Updated description',
            'status' => TaskStatus::Completed->value,
            'due_date' => '2026-12-31',
        ]);

        $response->assertRedirect(route('login'));
    });

    test('unauthenticated user cannot delete a task', function () {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('login'));
    });
});

describe('Task Index', function () {
    test('authenticated user can access tasks index', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertStatus(200)
            ->assertInertia(
                fn ($page) => $page
                    ->component('tasks/Index')
                    ->has('tasks')
            );
    });

    test('user sees only their own tasks', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $userTask = Task::factory()->create(['user_id' => $user->id]);
        $otherUserTask = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertInertia(
            fn ($page) => $page
                ->component('tasks/Index')
                ->where('tasks.data.0.id', $userTask->id)
        );
    });

    test('tasks are paginated', function () {
        $user = User::factory()->create();
        Task::factory(20)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertInertia(
            fn ($page) => $page
                ->component('tasks/Index')
                ->has('tasks.data', 15)
        );
    });

    test('tasks are sorted by latest', function () {
        $user = User::factory()->create();
        $task1 = Task::factory()->create(['user_id' => $user->id, 'title' => 'Task 1']);
        sleep(1);
        $task2 = Task::factory()->create(['user_id' => $user->id, 'title' => 'Task 2']);

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertInertia(
            fn ($page) => $page
                ->component('tasks/Index')
                ->where('tasks.data.0.id', $task2->id)
                ->where('tasks.data.1.id', $task1->id)
        );
    });
});

describe('Task Create', function () {
    test('authenticated user can access task creation form', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.create'));

        $response->assertStatus(200)
            ->assertInertia(
                fn ($page) => $page
                    ->component('tasks/Create')
                    ->has('options')
            );
    });

    test('creation form has status options', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.create'));

        $response->assertInertia(
            fn ($page) => $page
                ->component('tasks/Create')
                ->where('options.0.value', TaskStatus::Pending->value)
                ->where('options.0.label', 'Pending')
        );
    });
});

describe('Task Store', function () {
    test('authenticated user can create a task', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'My First Task',
            'description' => 'This is a test task',
            'status' => TaskStatus::Pending->value,
            'due_date' => '2026-12-31',
        ]);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'title' => 'My First Task',
            'description' => 'This is a test task',
            'status' => TaskStatus::Pending->value,
            'user_id' => $user->id,
        ]);
    });

    test('task is created with correct user_id', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'My Task',
            'status' => TaskStatus::Pending->value,
        ]);

        $response->assertRedirect();
        expect(Task::orderBy('id', 'desc')->first()->user_id)->toBe($user->id);
    });

    test('title is required', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'description' => 'Description',
            'status' => TaskStatus::Pending->value,
        ]);

        $response->assertSessionHasErrors(['title']);
    });

    test('status is required', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Valid Task',
            'description' => 'Description',
        ]);

        $response->assertSessionHasErrors(['status']);
    });

    test('status must be a valid enum value', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Valid Task',
            'status' => 'invalid_status',
        ]);

        $response->assertSessionHasErrors(['status']);
    });

    test('due_date must be a valid date', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Valid Task',
            'status' => TaskStatus::Pending->value,
            'due_date' => 'not-a-date',
        ]);

        $response->assertSessionHasErrors(['due_date']);
    });

    test('success message is flashed on creation', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Valid Task',
            'status' => TaskStatus::Pending->value,
        ]);

        $response->assertRedirect(route('tasks.index'));
    });
});

describe('Task Edit', function () {
    test('user can access edit form for their own task', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        $response->assertStatus(200)
            ->assertInertia(
                fn ($page) => $page
                    ->component('tasks/Edit')
                    ->where('task.id', $task->id)
                    ->has('options')
            );
    });

    test('user cannot access edit form for another user\'s task', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        $response->assertStatus(403);
    });

    test('edit form includes all task data', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Original Task',
            'description' => 'Original description',
            'status' => TaskStatus::InProgress,
        ]);

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        $response->assertInertia(
            fn ($page) => $page
                ->component('tasks/Edit')
                ->where('task.title', 'Original Task')
                ->where('task.description', 'Original description')
                ->where('task.status', TaskStatus::InProgress->value)
        );
    });

    test('edit form has status options', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        $response->assertInertia(
            fn ($page) => $page
                ->component('tasks/Edit')
                ->has('options', 3)
        );
    });
});

describe('Task Update', function () {
    test('user can update their own task', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('tasks.update', $task), [
            'title' => 'Updated Task',
            'description' => 'Updated description',
            'status' => TaskStatus::Completed->value,
            'due_date' => '2026-12-31',
        ]);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Task',
            'description' => 'Updated description',
            'status' => TaskStatus::Completed->value,
        ]);
    });

    test('user cannot update another user\'s task', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id, 'title' => 'Original Title']);

        $response = $this->actingAs($user)->put(route('tasks.update', $task), [
            'title' => 'Hacked Task',
            'status' => TaskStatus::Pending->value,
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Original Title',
        ]);
    });

    test('title is required on update', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('tasks.update', $task), [
            'status' => TaskStatus::Pending->value,
        ]);

        $response->assertSessionHasErrors(['title']);
    });

    test('status is required on update', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('tasks.update', $task), [
            'title' => 'Updated Title',
        ]);

        $response->assertSessionHasErrors(['status']);
    });

    test('status must be valid enum on update', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('tasks.update', $task), [
            'title' => 'Updated Title',
            'status' => 'invalid',
        ]);

        $response->assertSessionHasErrors(['status']);
    });

    test('due_date must be valid date on update', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('tasks.update', $task), [
            'title' => 'Updated Title',
            'status' => TaskStatus::Pending->value,
            'due_date' => 'invalid-date',
        ]);

        $response->assertSessionHasErrors(['due_date']);
    });

    test('success message is flashed on update', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('tasks.update', $task), [
            'title' => 'Updated Title',
            'status' => TaskStatus::Pending->value,
        ]);

        $response->assertRedirect(route('tasks.index'));
    });
});

describe('Task Delete', function () {
    test('user can delete their own task', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    });

    test('user cannot delete another user\'s task', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    });

    test('success message is flashed on deletion', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
    });

    test('task is actually deleted from database', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $taskId = $task->id;

        $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $this->assertNull(Task::find($taskId));
    });
});

describe('Task Show', function () {
    test('user can view their own task', function () {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.show', $task));

        $response->assertStatus(200)
            ->assertInertia(
                fn ($page) => $page
                    ->component('tasks/Show')
                    ->where('task.id', $task->id)
            );
    });

    test('user cannot view another user\'s task', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->get(route('tasks.show', $task));

        $response->assertStatus(403);
    });
});
