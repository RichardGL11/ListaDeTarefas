<?php

namespace Http\Todo;

use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditTodoTest extends TestCase
{
    #[Test]
    public function it_should_be_able_to_see_the_edit_form()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create();
        $this->actingAs($user);
        $response = $this->get(route('todos.edit', $todo));
        $response->assertStatus(200);
        $response->assertSee($todo->title);
        $response->assertSee($todo->description);
        $response->assertSee($todo->status);
    }
}
