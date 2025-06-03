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
        $response = $this->post(route('todos.restore',$todo->id));
        $response->assertRedirect('/dashboard');
        $todo->fresh();
        $this->assertNotSoftDeleted($todo);
    }
}
