<?php

namespace Http\Todo;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateTodoTest extends TestCase
{
    #[Test]
    public function it_should_update_a_todo()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'old title',
            'description' => 'old description',
            'status' => TodoStatusEnum::Pending
        ]);
        $this->actingAs($user);
        $response = $this->put(route('todos.update', $todo), [
            'title' => 'Updated Todo Title',
            'description' => 'updated description',
            'status' => TodoStatusEnum::Completed->value,
        ]);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseCount(Todo::class, 1);
        $this->assertDatabaseHas(Todo::class, [
            'title' => 'Updated Todo Title',
            'description' => 'updated description',
            'status' => TodoStatusEnum::Completed
        ]);

        $this->assertDatabaseMissing(Todo::class,[
            'title' => 'old title',
            'description' => 'old description',
            'status' => TodoStatusEnum::Pending
        ]);
    }
}
