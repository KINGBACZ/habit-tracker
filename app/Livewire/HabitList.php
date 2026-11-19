<?php

namespace App\Livewire;
use Livewire\Attributes\Layout;
use App\Models\Habit;
use App\Models\HabitLog;
use Carbon\Carbon;
use Livewire\Component;
#[Layout('components.layouts.app')]
class HabitList extends Component
{
    public string $name = '';

    // Добавление новой привычки
    public function addHabit(): void
    {
        $this->validate([
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'Введите название привычки',
        ]);

        Habit::create([
            'name' => $this->name,
            'color' => '#00796B',
        ]);

        $this->reset('name');
    }

    // Отметить или снять отметку за сегодня
    public function toggleToday(int $habitId): void
    {
        $today = Carbon::today()->toDateString();

        $log = HabitLog::where('habit_id', $habitId)
            ->where('done_on', $today)
            ->first();

        if ($log) {
            $log->delete();
        } else {
            HabitLog::create([
                'habit_id' => $habitId,
                'done_on' => $today,
            ]);
        }
    }

    // Удалить привычку
    public function deleteHabit(int $habitId): void
    {
        Habit::findOrFail($habitId)->delete();
    }

    // Выполнена ли привычка сегодня
    public function isDoneToday(Habit $habit): bool
    {
        return $habit->logs()
            ->whereDate('done_on', Carbon::today())
            ->exists();
    }

    // Серия дней подряд
    public function streak(Habit $habit): int
    {
        $dates = $habit->logs()
            ->pluck('done_on')
            ->map(fn ($d) => Carbon::parse($d)->toDateString());

        $count = 0;
        $day = Carbon::today();

        // Если сегодня ещё не отмечено, считаем серию от вчера
        if (! $dates->contains($day->toDateString())) {
            $day = $day->subDay();
        }

        while ($dates->contains($day->toDateString())) {
            $count++;
            $day = $day->subDay();
        }

        return $count;
    }

    public function render()
    {
        return view('livewire.habit-list', [
            'habits' => Habit::latest()->get(),
        ]);
    }
}