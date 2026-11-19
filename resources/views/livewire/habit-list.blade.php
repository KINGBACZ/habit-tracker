<div class="max-w-2xl mx-auto py-10 px-4">

    <h1 class="text-3xl font-bold text-teal-700 mb-6">Трекер привычек</h1>

    {{-- Форма добавления --}}
    <form wire:submit="addHabit" class="flex gap-2 mb-2">
        <input type="text" wire:model="name"
               placeholder="Например: зарядка, чтение 20 минут"
               class="flex-1 rounded-lg border border-slate-300 px-4 py-2 shadow-sm">
        <button type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg">
            Добавить
        </button>
    </form>

    @error('name')
        <p class="text-red-600 mb-4">{{ $message }}</p>
    @enderror

    {{-- Список привычек --}}
    <div class="space-y-3 mt-6">
        @forelse ($habits as $habit)
            <div class="bg-white rounded-xl shadow p-4 flex items-center justify-between">
                <div>
                    <p class="font-semibold text-slate-800">{{ $habit->name }}</p>
                    <p class="text-sm text-slate-500">Серия: {{ $this->streak($habit) }} дн.</p>
                </div>

                <div class="flex gap-2">
                    <button wire:click="toggleToday({{ $habit->id }})"
                            class="px-4 py-2 rounded-lg transition
                                {{ $this->isDoneToday($habit) ? 'bg-green-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                        {{ $this->isDoneToday($habit) ? '✓ Сделано' : 'Отметить' }}
                    </button>

                    <button wire:click="deleteHabit({{ $habit->id }})"
                            wire:confirm="Удалить привычку?"
                            class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg">
                        Удалить
                    </button>
                </div>
            </div>
        @empty
            <p class="text-slate-500">Пока нет привычек. Добавьте первую.</p>
        @endforelse
    </div>

</div>