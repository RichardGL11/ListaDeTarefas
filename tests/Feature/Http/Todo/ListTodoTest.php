<?php

namespace Http\Todo;

use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ListTodoTest extends TestCase
{
    #[Test]
    public function it_should_list_my_todos()
    {
        $user = User::factory()->create();
        $otherTodos = Todo::factory(5)->create();
        $myTodos = Todo::factory(10)->for($user)->create();

        $this->actingAs($user);
        $response = $this->get('/dashboard');

        $myTodos->each(function ($todo) use ($response) {
            $response->assertSee($todo->title);
            $response->assertSee($todo->description);
            $response->assertSee(strtoupper($todo->status->value));
            $response->assertSee(Carbon::parse($todo->created_at)->format('d/M/Y'));
        });

        $otherTodos->each(function ($todo) use ($response) {
            $response->assertDontSee($todo->title);
            $response->assertDontSee($todo->description);
        });
    }
}
