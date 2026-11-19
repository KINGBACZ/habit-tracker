<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HabitLog extends Model
{
    protected $fillable = ['habit_id', 'done_on'];

    // Дата автоматически превращается в объект даты
    protected $casts = [
        'done_on' => 'date',
    ];

    // Отметка принадлежит одной привычке
    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class);
    }
}