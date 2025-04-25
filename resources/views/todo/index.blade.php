<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
         <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg p-6">
             {{-- Header Button + Alert --}}
             <div class="flex items-center justify-between mb-4">
                 <x-create-button href="{{ route('todo.create') }}" />
 
                 <div>
                     @if (session('success'))
                         <p x-data="{ show: true }" x-show="show" x-transition
                             x-init="setTimeout(() => show = false, 5000)"
                             class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}
                         </p>
                     @endif
 
                     @if (session('danger'))
                         <p x-data="{ show: true }" x-show="show" x-transition
                             x-init="setTimeout(() => show = false, 5000)"
                             class="text-sm text-red-600 dark:text-red-400">{{ session('danger') }}
                         </p>
                     @endif
                 </div>
             </div>
 
             {{-- Table --}}
             <div class="relative overflow-x-auto">
                 <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                     <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                         <tr>
                             <th scope="col" class="px-6 py-3">Title</th>
                             <th scope="col" class="px-6 py-3 md:block">Status</th>
                             <th scope="col" class="px-6 py-3">Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         @forelse($todos as $data)
                             <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                 <td scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                     <a href="{{ route('todo.edit', $data) }}" class="hover:underline">{{ $data->title }}</a>
                                 </td>
                                 <td class="hidden px-6 py-4 md:block">
                                     @if (!$data->is_done)
                                         <span class="inline-flex bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                             Ongoing
                                         </span>
                                     @else
                                         <span class="inline-flex bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                             Done
                                         </span>
                                     @endif
                                 </td>
                                 <td class="px-6 py-4">
                                     <div class="flex space-x-3">
                                         {{-- Action Here --}}
                                     </div>
                                 </td>
                             </tr>
                         @empty
                             <tr class="odd:bg-white dark:bg-gray-900 even:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                 <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                     No data available
                                 </td>
                             </tr>
                         @endforelse
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
</x-app-layout>