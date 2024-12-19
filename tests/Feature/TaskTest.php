<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Jobs\DeleteOldCompletedTasks;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_view_tasks_list(): void
    {
        $this->actingAs($this->user)
            ->get(route('tasks.index'))
            ->assertStatus(200)
            ->assertViewIs('tasks.index');
    }

    public function test_unauthenticated_user_cannot_view_tasks(): void
    {
        $this->get(route('tasks.index'))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_create_task(): void
    {
        $taskData = [
            'title' => 'Nova Tarefa Teste',
            'description' => 'Descrição da tarefa de teste',
            'category_id' => null,
            'users' => [$this->user->id]
        ];

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Nova Tarefa Teste',
            'description' => 'Descrição da tarefa de teste'
        ]);
    }

    public function test_task_requires_title(): void
    {
        $taskData = [
            'title' => '',
            'description' => 'Descrição da tarefa de teste',
            'users' => [$this->user->id]
        ];

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $taskData);

        $response->assertSessionHasErrors('title');
    }

    public function test_user_can_create_task_with_category(): void
    {
        $category = Category::factory()->create([
            'user_id' => $this->user->id
        ]);

        $taskData = [
            'title' => 'Tarefa Com Categoria',
            'description' => 'Descrição da tarefa',
            'category_id' => $category->id,
            'users' => [$this->user->id]
        ];

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Tarefa Com Categoria',
            'category_id' => $category->id
        ]);
    }

    public function test_user_can_update_own_task(): void
    {
        $task = Task::factory()->create();
        $task->users()->attach($this->user);

        $updatedData = [
            'title' => 'Tarefa Atualizada',
            'description' => 'Nova descrição da tarefa',
            'users' => [$this->user->id]
        ];

        $response = $this->actingAs($this->user)
            ->put(route('tasks.update', $task), $updatedData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Tarefa Atualizada',
            'description' => 'Nova descrição da tarefa'
        ]);
    }

    public function test_user_cannot_update_others_task(): void
    {
        $otherUser = User::factory()->create();
        $task = Task::factory()->create();
        $task->users()->attach($otherUser);

        $response = $this->actingAs($this->user)
            ->put(route('tasks.update', $task), [
                'title' => 'Tentativa de Atualização',
                'description' => 'Nova descrição'
            ]);

        $response->assertForbidden();
    }

    public function test_user_can_delete_own_task(): void
    {
        $task = Task::factory()->create();
        $task->users()->attach($this->user);

        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_can_mark_task_as_completed(): void
{
    $task = Task::factory()->create();
    $task->users()->attach($this->user);

    $response = $this->actingAs($this->user)
        ->put(route('tasks.update', $task), [
            'title' => $task->title,
            'is_completed' => true,
            'users' => [$this->user->id]
        ]);

    $response->assertRedirect(route('tasks.index'));
    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'is_completed' => true
    ]);
}

public function test_tasks_can_be_filtered_by_category(): void
{
    $category = Category::factory()->create([
        'user_id' => $this->user->id
    ]);

    $taskInCategory = Task::factory()->create([
        'title' => 'Tarefa Na Categoria',
        'category_id' => $category->id
    ]);
    $taskInCategory->users()->attach($this->user);

    $taskWithoutCategory = Task::factory()->create([
        'title' => 'Tarefa Sem Categoria',
        'category_id' => null
    ]);
    $taskWithoutCategory->users()->attach($this->user);

    $response = $this->actingAs($this->user)
        ->get(route('tasks.index', ['category_id' => $category->id]));

    $response->assertSuccessful()
        ->assertViewHas('tasks', function ($tasks) use ($taskInCategory, $taskWithoutCategory) {
            return $tasks->contains($taskInCategory) && !$tasks->contains($taskWithoutCategory);
        });
}

public function test_old_completed_tasks_can_be_deleted(): void
{
    $oldTask = Task::factory()->create([
        'is_completed' => true,
        'updated_at' => now()->subDays(8)
    ]);
    $oldTask->users()->attach($this->user);

    $recentTask = Task::factory()->create([
        'is_completed' => true,
        'updated_at' => now()->subDays(3)
    ]);
    $recentTask->users()->attach($this->user);

    DeleteOldCompletedTasks::dispatch();

    $this->assertDatabaseMissing('tasks', ['id' => $oldTask->id]);
    $this->assertDatabaseHas('tasks', ['id' => $recentTask->id]);
}

public function test_tasks_can_be_filtered_by_completion_status(): void
{
    // Criar uma tarefa completa
    $completedTask = Task::factory()->create([
        'title' => 'Tarefa Completa',
        'is_completed' => true
    ]);
    $completedTask->users()->attach($this->user);

    // Criar uma tarefa incompleta
    $pendingTask = Task::factory()->create([
        'title' => 'Tarefa Pendente',
        'is_completed' => false
    ]);
    $pendingTask->users()->attach($this->user);

    // Testar filtro de tarefas completas
    $response = $this->actingAs($this->user)
        ->get(route('tasks.index', ['is_completed' => '1']));

    $response->assertSuccessful()
        ->assertViewHas('tasks', function ($tasks) use ($completedTask, $pendingTask) {
            return $tasks->contains($completedTask) && !$tasks->contains($pendingTask);
        });
}

public function test_task_can_be_created_with_new_category(): void
{
    $taskData = [
        'title' => 'Nova Tarefa',
        'description' => 'Descrição da tarefa',
        'new_category' => 'Categoria Nova',
        'users' => [$this->user->id]
    ];

    $response = $this->actingAs($this->user)
        ->post(route('tasks.store'), $taskData);

    $response->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('categories', [
        'name' => 'Categoria Nova',
        'user_id' => $this->user->id
    ]);

    $category = Category::where('name', 'Categoria Nova')->first();
    $this->assertDatabaseHas('tasks', [
        'title' => 'Nova Tarefa',
        'category_id' => $category->id
    ]);
}

public function test_category_requires_name(): void
{
    $response = $this->actingAs($this->user)
        ->post(route('categories.store'), [
            'name' => ''
        ]);

    $response->assertSessionHasErrors('name');
}
}
