<?php

namespace Http\Todo;

use App\Enums\TodoStatusEnum;
use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
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
            'status' => TodoStatusEnum::Pending,
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
            'status' => TodoStatusEnum::Completed,
        ]);

        $this->assertDatabaseMissing(Todo::class, [
            'title' => 'old title',
            'description' => 'old description',
            'status' => TodoStatusEnum::Pending,
        ]);
    }

    #[Test]
    public function test_only_the_owner_can_update_the_todo()
    {
        $user = User::factory()->create();
        $wrongUser = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'old title',
            'description' => 'old description',
            'status' => TodoStatusEnum::Pending,
        ]);
        $this->actingAs($wrongUser);
        $response = $this->put(route('todos.update', $todo), [
            'title' => 'Updated Todo Title',
            'description' => 'updated description',
            'status' => TodoStatusEnum::Completed->value,
        ]);
        $response->assertStatus(403);
        $this->assertDatabaseCount(Todo::class, 1);
        $this->assertDatabaseHas(Todo::class, [
            'title' => 'old title',
            'description' => 'old description',
            'status' => TodoStatusEnum::Pending,
        ]);

        $this->assertDatabaseMissing(Todo::class, [
            'title' => 'Updated Todo Title',
            'description' => 'updated description',
            'status' => TodoStatusEnum::Completed,
        ]);
    }

    #[DataProvider('title_validation_provider')]
    public function test_title_validation_rules(array $input, string $error): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'old title',
            'description' => 'old description',
        ]);
        $this->actingAs($user);
        $response = $this->put(route('todos.update', $todo), [
            'title' => $input['title'],
            'description' => 'todo description',
        ]);

        $response->assertSessionHasErrors(['title' => $error]);
    }
    #[DataProvider('description_validation_provider')]
    public function test_description_validation_rules(array $input, string $error): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'old title',
            'description' => 'old description',
        ]);
        $this->actingAs($user);
        $response = $this->put(route('todos.update', $todo), [
            'title' => 'title for todo',
            'description' => $input['description'],
        ]);

        $response->assertSessionHasErrors(['description' => $error]);
    }
    #[DataProvider('status_validation_provider')]
    public function test_status_validation_rules(array $input, string $error): void
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->for($user)->create([
            'title' => 'old title',
            'description' => 'old description',
        ]);
        $this->actingAs($user);
        $response = $this->put(route('todos.update', $todo), [
            'title' => 'title for todo',
            'description' => 'description',
            'status' => $input['status'],
        ]);

        $response->assertSessionHasErrors(['status' => $error]);
    }

    public static function description_validation_provider(): array
    {
        return [
            'missing description' => [
                'input' => ['description' => null],
                'error' => 'The description field is required.',
            ],
            'short description' => [
                'input' => ['description' => 'aa'],
                'error' => 'The description field must be at least 3 characters.',
            ],
            'long description' => [
                'input' => ['description' => str_repeat('a', 256)],
                'error' => 'The description field must not be greater than 255 characters.',
            ],
        ];
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

    public static function status_validation_provider(): array
    {
        return [
            'wrong status' => [
                'input' => ['status' => 'aaa'],
                'error' => 'The selected status is invalid.',
            ],
        ];
    }
}
