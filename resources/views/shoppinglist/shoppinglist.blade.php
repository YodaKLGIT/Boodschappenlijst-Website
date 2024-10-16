<x-app-layout>
    <div class="flex max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="w-3/4 pr-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $shoppinglist->name }}</h2>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Created: {{ $shoppinglist->created_at->format('M d, Y') }}</span>
                    </div>

                    @if($shoppinglist->products->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400 text-center py-4">No products in this shopping list.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($shoppinglist->products->groupBy('category.name') as $category => $products)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">{{ $category }}</h3>
                                    <ul class="space-y-2">
                                        @foreach($products as $product)
                                            <li class="flex justify-between items-center bg-white dark:bg-gray-600 p-3 rounded-md shadow-sm">
                                                <div>
                                                    <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $product->name }}</span>
                                                    <span class="text-gray-600 dark:text-gray-400 text-sm ml-2">{{ $product->brand->name }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="text-gray-600 dark:text-gray-400 mr-4">
                                                        Qty: {{ $product->pivot->quantity ?? 'Not specified' }}
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-8 flex justify-between">
                        <a href="{{ route('shoppinglist.index') }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded shadow transition">
                            Back to Lists
                        </a>
                        <a href="{{ route('shoppinglist.edit', $shoppinglist) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                            Edit List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-1/4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Notes</h3>
                    
                    <!-- Note Creation Form -->
                    <form action="{{ route('shoppinglist.add_note', $shoppinglist) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <input type="text" name="title" placeholder="Note Title" required
                                   class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="mb-4">
                            <textarea name="description" placeholder="Note Description" required
                                      class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white" rows="3"></textarea>
                        </div>
                        <button type="submit" 
                                class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded shadow transition">
                            Add Note
                        </button>
                    </form>

                    <!-- Display Notes -->
                    <div class="mt-6 space-y-4">
                        @forelse($shoppinglist->notes as $note)
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded">
                                <h4 class="font-semibold text-gray-800 dark:text-white">{{ $note->title }}</h4>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">{{ $note->description }}</p>
                                <small class="text-gray-500 dark:text-gray-400 block mt-2">
                                    By {{ $note->user->name }} on {{ $note->created_at->format('M d, Y H:i') }}
                                </small>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400">No notes yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
