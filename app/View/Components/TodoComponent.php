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

        if (request()->has('status') && in_array(request('status'), ['PENDENTE', 'CONCLUIDO'])) {
            $query->where('status', request('status'));
        }

        return view('components.todo-component', [
            'todos' => $query->simplePaginate(10),
        ]);
    }
}
