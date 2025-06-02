<?php

namespace Http\Todo;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
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
            'status' => TodoStatusEnum::Pending,
        ]);
    }

    #[DataProvider('title_validation_provider')]
    public function test_title_validation_rules(array $input, string $error): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('todos.store', [
            'title' => $input['title'],
            'description' => 'todo description',
        ]));

        $response->assertSessionHasErrors(['title' => $error]);
    }

    public static function title_validation_provider(): array
    {
        return [
            'missing title' => [
                'input' => ['title' => null],
                'error' => 'The title field is required.',
            ],
            'short title' => [
                'input' => ['title' => 'aa'],
                'error' => 'The title field must be at least 3 characters.',
            ],
            'long title' => [
                'input' => ['title' => str_repeat('a', 256)],
                'error' => 'The title field must not be greater than 255 characters.',
            ],
        ];
    }
}
