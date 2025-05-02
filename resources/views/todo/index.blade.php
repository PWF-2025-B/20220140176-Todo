<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            {{ __('Todo List') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 space-y-6">

            {{-- Alert & Create Button --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 shadow p-6 rounded-lg">
                <x-create-button href="{{ route('todo.create') }}" />
                <div class="space-y-1 w-full md:w-auto">
                    @if (session('success'))
                        <p x-data="{ show: true }" x-show="show" x-transition
                           x-init="setTimeout(() => show = false, 5000)"
                           class="text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </p>
                    @endif
                    @if (session('danger'))
                        <p x-data="{ show: true }" x-show="show" x-transition
                           x-init="setTimeout(() => show = false, 5000)"
                           class="text-sm text-red-600 dark:text-red-400">
                            {{ session('danger') }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Todo Table --}}
            <div class="bg-white dark:bg-gray-800 shadow p-6 rounded-lg overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3">Title</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todos as $todo)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900">
                                <td class="px-6 py-4">
                                    <a href="{{ route('todo.edit', $todo->id) }}" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $todo->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    @if (!$todo->is_done)
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            On Going
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            Done
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2 flex-wrap">
                                        {{-- Done/Uncomplete --}}
                                        <form action="{{ $todo->is_done ? route('todo.uncomplete', $todo) : route('todo.complete', $todo) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1 text-xs font-semibold text-white rounded 
                                                       {{ $todo->is_done ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700' }}">
                                                {{ $todo->is_done ? 'Mark On Going' : 'Mark Done' }}
                                            </button>
                                        </form>

                                        {{-- Delete --}}
                                        <form action="{{ route('todo.destroy', $todo) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No tasks found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Delete All Completed --}}
            @if ($todosCompleted > 1)
                <div class="bg-white dark:bg-gray-800 shadow p-6 rounded-lg text-right">
                    <form action="{{ route('todo.deleteallcompleted') }}" method="POST" onsubmit="return confirm('Delete all completed tasks?');">
                        @csrf
                        @method('DELETE')
                        <x-primary-button>
                            Delete All Completed Tasks
                        </x-primary-button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>