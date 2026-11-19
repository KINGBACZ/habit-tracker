<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();
            // Связь с привычкой: если привычку удалить, её отметки удалятся тоже
            $table->foreignId('habit_id')->constrained()->cascadeOnDelete();
            $table->date('done_on');
            $table->timestamps();

            // Одна привычка отмечается не больше одного раза в день
            $table->unique(['habit_id', 'done_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habit_logs');
    }
};