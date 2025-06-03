<?php

namespace Http\Todo;

use App\Models\Todo;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FilterTodoTest extends TestCase
{
    #[Test]
    public function it_should_filter_the_todo_by_the_status(): void
    {
        $user = User::factory()->create();
        $completedTodo = Todo::factory(10)->for($user)->completed()->create();
        $pendingTodo = Todo::factory(10)->for($user)->pending()->create();
        $this->actingAs($user);
        $response = $this->get('/dashboard?status=PENDENTE');

        $pendingTodo->each(function ($todo) use ($response) {
            $response->assertSeeText($todo->title);
            $response->assertSeeText(strtoupper($todo->status->value));
            $response->assertSeeText($todo->decription);
        });
        $response->assertDontSeeText('CONCLUIDO');

        $response = $this->get('/dashboard?status=CONCLUIDO');

        $completedTodo->each(function ($todo) use ($response) {
            $response->assertSeeText($todo->title);
            $response->assertSeeText(strtoupper($todo->status->value));
            $response->assertSeeText($todo->decription);
        });
        $response->assertDontSeeText('PENDENTE');
    }
}
