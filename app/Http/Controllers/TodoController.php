<?php

namespace App\Http\Controllers;

use App\Enums\TodoStatusEnum;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TodoController extends Controller
{

    public function create(): View
    {
        return view('Todo.CreateTodoView');
    }

    public function store(StoreTodoRequest $request): RedirectResponse
    {
        Todo::query()->create([
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
            'status' => TodoStatusEnum::Pending,
            'user_id' => auth()->id(),
        ]);

        return redirect('/dashboard', 201);
    }

    public function edit(Todo $todo): View
    {
        $this->authorize('edit', $todo);

        return view('Todo.EditTodoView', [
            'todo' => $todo,
            'status' => TodoStatusEnum::cases(),
        ]);
    }

    public function update(UpdateTodoRequest $request, Todo $todo): RedirectResponse
    {
        $this->authorize('update', $todo);
        $todo->update([
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
            'status' => $request->validated('status'),
        ]);

        return redirect('/dashboard');
    }

    public function destroy(Todo $todo): RedirectResponse
    {
        $this->authorize('delete', $todo);
        $todo->delete();

        return redirect('/dashboard');
    }
}
