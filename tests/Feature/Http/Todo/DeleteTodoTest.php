<?php

namespace Http\Todo;

use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteTodoTest extends TestCase
{

    #[Test]
    public function it_should_be_able_to_soft_delete_a_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'title',
            'description' => 'todo that will be soft deleted'
        ]);
        $this->actingAs($user);

        $this->delete(route('todos.destroy', $todo));

        $todo->fresh();
        $this->assertSoftDeleted($todo);

        $this->assertDatabaseHas(Todo::class, [
            'title' => 'title',
            'description' => 'todo that will be soft deleted'
        ]);
    }
    #[Test]
    public function test_only_the_owner_can_soft_delete_the_todo()
    {
        $user = User::factory()->create();
        $wrongUser = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'title',
            'description' => 'todo that will be soft deleted'
        ]);
        $this->actingAs($wrongUser);

        $response = $this->delete(route('todos.destroy', $todo));
        $response->assertStatus(403);
        $todo->fresh();
        $this->assertNotSoftDeleted($todo);
    }
}
