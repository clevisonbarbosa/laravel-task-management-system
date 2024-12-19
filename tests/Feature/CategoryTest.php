<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_category_is_created_with_task(): void
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
    }

    public function test_existing_category_can_be_used(): void
    {
        $category = Category::factory()->create([
            'user_id' => $this->user->id
        ]);

        $taskData = [
            'title' => 'Nova Tarefa',
            'description' => 'Descrição da tarefa',
            'category_id' => $category->id,
            'users' => [$this->user->id]
        ];

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'title' => 'Nova Tarefa',
            'category_id' => $category->id
        ]);
    }

    public function test_user_cannot_use_others_category(): void
    {
        $otherUser = User::factory()->create();
        $otherCategory = Category::factory()->create([
            'user_id' => $otherUser->id
        ]);

        $taskData = [
            'title' => 'Nova Tarefa',
            'description' => 'Descrição da tarefa',
            'category_id' => $otherCategory->id,
            'users' => [$this->user->id]
        ];

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $taskData);

        $response->assertSessionHasErrors('category_id');
    }
}
