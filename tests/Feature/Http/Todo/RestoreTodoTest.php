<?php

namespace Http\Todo;

use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RestoreTodoTest extends TestCase
{
    #[Test]
    public function it_should_be_able_to_restore_a_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->trashed()->createOne();
        $this->actingAs($user);
        $response = $this->post(route('todos.restore', $todo->id));
        $response->assertRedirect('/dashboard');
        $todo->fresh();
        $this->assertNotSoftDeleted($todo);
    }

    #[Test]
    public function test_only_the_owner_can_restore_the_todo()
    {
        $user = User::factory()->create();
        $wrongUser = User::factory()->create();
        $todo = Todo::factory()->for($user)->trashed()->createOne();
        $this->actingAs($wrongUser);
        $response = $this->post(route('todos.restore', $todo->id));
        $response->assertStatus(403);
        $todo->fresh();
        $this->assertSoftDeleted($todo);
    }
}
