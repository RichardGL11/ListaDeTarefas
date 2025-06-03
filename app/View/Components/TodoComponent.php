<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TodoComponent extends Component
{
    public function render(): View|Closure|string
    {
        $query = auth()->user()->todos();

        $status = request('status');

        if ($status === 'EXCLUIDO') {
            $query = $query->onlyTrashed();
        } elseif (in_array($status, ['PENDENTE', 'CONCLUIDO'])) {
            $query->where('status', $status);
        }

        return view('components.todo-component', [
            'todos' => $query->simplePaginate(10),
        ]);
    }
}
