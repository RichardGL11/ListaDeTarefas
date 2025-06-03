<?php

namespace App\Models;

use App\Enums\TodoStatusEnum;
use Database\Factories\TodoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    /** @use HasFactory<TodoFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['title', 'description', 'status', 'user_id'];

    protected $casts = ['status' => TodoStatusEnum::class];

    public function user(): BelongsTo
    {
        return $this->belongsto(User::class);
    }
}
