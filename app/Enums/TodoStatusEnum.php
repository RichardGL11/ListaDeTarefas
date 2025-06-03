<?php

namespace App\Enums;

enum TodoStatusEnum: string
{
    case Pending = 'pendente';
    case Completed = 'concluido';
}
