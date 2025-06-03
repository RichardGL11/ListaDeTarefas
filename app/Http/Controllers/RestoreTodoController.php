<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\RedirectResponse;

class RestoreTodoController extends Controller
{
    public function __invoke(int $id): RedirectResponse
    {
        $todo = Todo::onlyTrashed()->where('id', $id)->firstOrFail();
        $this->authorize('restore', $todo);
        $todo->restore();
        return redirect('/dashboard');
    }
}
