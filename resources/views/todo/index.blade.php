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
                            <th scope="col" class="px-6 py-3">Category</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todos as $data)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
            <a href="{{ route('todo.edit', $data) }}" class="hover:underline text-xs">
                {{ $data->title }}
            </a>
        </td>
        <td class="px-6 py-4">
            <span class="text-xs text-gray-800 dark:text-gray-300">
                {{ $data->category?->title ?? '-' }}
            </span>
        </td>
        <td class="px-6 py-4">
            @if ((int)$data->is_complete === 0)
                <span class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                    Ongoing
                </span>
            @else
                <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                    Completed
                </span>
            @endif
        </td>
        <td class="px-6 py-4">
            <div class="flex space-x-2">
                @if ((int)$data->is_complete === 0)
                    <form action="{{ route('todo.complete', $data) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="background-color: #16a34a;" class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium px-3 py-1 rounded">
                            Complete
                        </button>
                    </form>
                @else
                    <form action="{{ route('todo.uncomplete', $data) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white text-xs font-medium px-3 py-1 rounded">
                            Uncomplete
                        </button>
                    </form>
                @endif
                <form action="{{ route('todo.destroy', $data) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1 rounded">
                        Delete
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
            No data available
        </td>
    </tr>
@endforelse
                    </tbody>
                </table>
            </div>

            {{-- Delete All Completed --}}
            @if ($todoCompleted > 1)
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