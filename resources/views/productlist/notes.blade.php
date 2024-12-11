<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
            <div class="p-6 space-y-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Notes</h3>
                
                <!-- Display existing notes -->
                @if ($productlist->notes->isNotEmpty())
                    <div class="space-y-2 mb-4 max-h-96 overflow-y-auto">
                        @foreach ($productlist->notes as $note)
                            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $note->title }}</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $note->description }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">
                                    By {{ $note->user->name }} on {{ $note->created_at->format('M d, Y H:i') }}
                                </p>
                                @if (Auth::id() === $note->user_id)
                                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 dark:text-gray-400 mb-4">No notes yet</p>
                @endif

                <!-- Add new note form -->
                <form action="{{ route('list.notes.store', $productlist->id) }}" method="POST" class="space-y-2">
                    @csrf
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-900 dark:text-white">Title</label>
                        <input type="text" name="title" id="title" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-800">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea name="description" id="description" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-0 dark:border-gray-600 dark:text-gray-800"></textarea>
                    </div>
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                        Add Note
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>