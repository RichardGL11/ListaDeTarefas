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
    #[Test]
    public function test_pagination(): void
    {
        $user = User::factory()->create();
        Todo::factory(20)->for($user)->completed()->create();
        $this->actingAs($user);
        $response = $this->get('/dashboard');
        $response->assertSeeText('Previous');
        $response->assertSeeText('Next');
    }

    #[Test]
    public function test_soft_deleted_todo(): void
    {
        $user = User::factory()->create();
        $softDeletedTodo = Todo::factory(10)->for($user)->trashed()->completed()->create();
        $pendingTodo = Todo::factory(10)->for($user)->pending()->create();
        $this->actingAs($user);
        $response = $this->get('/dashboard?status=PENDENTE');

        $pendingTodo->each(function ($todo) use ($response) {
            $response->assertSeeText($todo->title);
            $response->assertSeeText(strtoupper($todo->status->value));
            $response->assertSeeText($todo->decription);
        });


        $response = $this->get('/dashboard?status=EXCLUIDO');

        $softDeletedTodo->each(function ($todo) use ($response) {
            $response->assertSeeText($todo->title);
            $response->assertSeeText(strtoupper($todo->status->value));
            $response->assertSeeText($todo->decription);
        });
        $response->assertDontSeeText('PENDENTE');
    }

}
