<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Shopping List Details -->
            <div class="w-full md:w-2/3">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 space-y-4">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $productlist->name }}</h2>

                        <!-- Owner Information -->
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white">Owner</label>
                            <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $owner->name ?? 'Unknown' }}</p>
                        </div>

                        <!-- Shared Users -->
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white">Shared with</label>
                            @if ($productlist->sharedUsers->isNotEmpty())
                                <ul class="mt-1 space-y-2">
                                    @foreach ($productlist->sharedUsers as $user)
                                        <li class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-2 rounded">
                                            <span class="text-gray-800 dark:text-gray-200">{{ $user->name }}</span>
                                            @if ($isOwner && $user->id !== $owner->id)
                                                <form action="{{ route('productlist.removeUser', [$productlist->id, $user->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600">
                                                        Remove
                                                    </button>
                                                </form>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-1 text-gray-600 dark:text-gray-400">Not shared with anyone</p>
                            @endif
                        </div>

                        <!-- Products List -->
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Products</label>
                            @if ($productlist->products->isNotEmpty())
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
                                    <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach ($productlist->products as $product)
                                            <li class="p-3 hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-200">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-gray-900 dark:text-white">
                                                        {{ $product->brand->name }} - {{ $product->name }}
                                                    </span>
                                                    <span class="text-gray-600 dark:text-gray-400">
                                                        Quantity: {{ $product->pivot->quantity }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    Category: {{ $product->category->name }}
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p class="mt-1 text-gray-600 dark:text-gray-400">No products in this list</p>
                            @endif
                        </div>

                        <!-- Invite Users Section (Only visible to owner) -->
                        @if ($isOwner)
                            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Invite Users</h3>
                                <form action="{{ route('productlist.invite', $productlist->id) }}" method="POST" class="space-y-2">
                                    @csrf
                                    <div>
                                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select User</label>
                                        <select id="user_id" name="user_id" class="w-full p-3 rounded bg-white border border-gray-300 text-gray-800" required>
                                            <option value="">Select a user</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" 
                                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                                        Invite User
                                    </button>
                                </form>
                            </div>
                        @endif

                        <!-- Buttons -->
                        <div class="flex justify-between mt-4">
                            <a href="{{ route('productlist.index') }}" 
                                class="flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow transition">
                                Back to Lists
                            </a>
                            <a href="{{ route('productlist.edit', $productlist->id) }}" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                                Edit List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="w-full md:w-1/3">
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
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea name="description" id="description" rows="3" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                            </div>
                            <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                                Add Note
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>