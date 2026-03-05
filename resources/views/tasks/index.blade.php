<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tasks') }}
            </h2>
            <a href="{{ route('tasks.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('+ New Task') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Total Tasks') }}</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['totalTask'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Pending') }}</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['totalPending'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('In Progress') }}</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['totalInProgress'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">{{ __('Completed') }}</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['totalCompleted'] }}</p>
                </div>
            </div>

            {{-- Flash message --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search & Filters --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('tasks.index') }}"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    {{-- Search --}}
                    <div>
                        <label for="search"
                            class="block text-sm font-medium text-gray-700 mb-1">{{ __('Search') }}</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Search tasks..."
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    {{-- Priority Filter --}}
                    <div>
                        <label for="priority"
                            class="block text-sm font-medium text-gray-700 mb-1">{{ __('Priority') }}</label>
                        <select name="priority" id="priority"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">{{ __('All Priorities') }}</option>
                            @foreach (\App\Enums\PriorityEnum::cases() as $priority)
                                <option value="{{ $priority->value }}" @selected(request('priority') === $priority->value)>
                                    {{ $priority->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status Filter --}}
                    <div>
                        <label for="status"
                            class="block text-sm font-medium text-gray-700 mb-1">{{ __('Status') }}</label>
                        <select name="status" id="status"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">{{ __('All Statuses') }}</option>
                            @foreach (\App\Enums\StatusEnum::cases() as $status)
                                <option value="{{ $status->value }}" @selected(request('status') === $status->value)>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Due Date Filter --}}
                    <div>
                        <label for="due_date"
                            class="block text-sm font-medium text-gray-700 mb-1">{{ __('Due Date') }}</label>
                        <input type="date" name="due_date" id="due_date" value="{{ request('due_date') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Filter') }}
                        </button>
                        <a href="{{ route('tasks.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Reset') }}
                        </a>
                    </div>
                </form>
            </div>

            {{-- Task List --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @forelse ($tasks as $task)
                    <div
                        class="p-6 border-b border-gray-200 hover:bg-gray-50 transition {{ $loop->last ? 'border-b-0' : '' }}">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            {{-- Task Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $task->title }}</h3>

                                    {{-- Priority Badge --}}
                                    @php
                                        $priorityColors = [
                                            'green' => 'bg-green-100 text-green-800',
                                            'yellow' => 'bg-yellow-100 text-yellow-800',
                                            'red' => 'bg-red-100 text-red-800',
                                        ];
                                        $pColor =
                                            $priorityColors[$task->priority->color()] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pColor }}">
                                        {{ $task->priority->label() }}
                                    </span>

                                    {{-- Status Badge --}}
                                    @php
                                        $statusColors = [
                                            'gray' => 'bg-gray-100 text-gray-800',
                                            'blue' => 'bg-blue-100 text-blue-800',
                                            'green' => 'bg-green-100 text-green-800',
                                        ];
                                        $sColor = $statusColors[$task->status->color()] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sColor }}">
                                        {{ $task->status->label() }}
                                    </span>
                                </div>

                                @if ($task->description)
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $task->description }}</p>
                                @endif

                                <div class="mt-2 flex items-center gap-4 text-xs text-gray-500">
                                    @if ($task->due_date)
                                        <span
                                            class="{{ $task->due_date->isPast() && $task->status !== \App\Enums\StatusEnum::Completed ? 'text-red-600 font-semibold' : '' }}">
                                            Due: {{ $task->due_date->format('M d, Y') }}
                                        </span>
                                    @endif
                                    <span>Created: {{ $task->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('tasks.edit', $task) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-yellow-50 text-yellow-700 border border-yellow-300 rounded-md text-xs font-medium hover:bg-yellow-100 transition">
                                    {{ __('Edit') }}
                                </a>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 border border-red-300 rounded-md text-xs font-medium hover:bg-red-100 transition">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No tasks found') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Get started by creating a new task.') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('tasks.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                {{ __('+ New Task') }}
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
