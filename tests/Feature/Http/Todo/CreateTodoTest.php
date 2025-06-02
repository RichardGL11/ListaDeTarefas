<?php

namespace Http\Todo;
use App\Enums\TodoStatusEnum;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Todo;
use App\Models\User;
use Tests\TestCase;

class CreateTodoTest extends TestCase
{
    #[Test]
    public function it_should_be_able_to_create_a_todo()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create());
        $response = $this->post(route('todos.store'), [
            'title' => 'Todo Title',
            'description' => 'Todo description',
        ]);
        $response->assertStatus(201);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseCount(Todo::class, 1);
        $this->assertDatabaseHas(Todo::class, [
            'title' => 'Todo Title',
            'description' => 'Todo description',
            'status' => TodoStatusEnum::Pending
        ]);


    }
}
