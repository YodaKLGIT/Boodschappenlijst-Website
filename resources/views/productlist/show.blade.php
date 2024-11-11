<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Shopping List Details -->
            <div class="w-full md:w-2/3">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 space-y-4">
                        <!-- Themed Title Section -->
                        <div class="container mx-auto px-4 py-8 mb-16">
                            <div class="shopping-list-wrapper max-w-4xl mx-auto">
                                <article class="rounded-xl bg-white shadow-md overflow-hidden">
                                    <div class="p-3 flex flex-col items-center" 
                                         style="background-color: {{ $productlist->theme->strap_color }};">
                                        <div class="flex items-center justify-between w-full">
                                            <!-- Favorite Toggle -->
                                            <form action="{{ route('lists.toggleFavorite', $productlist->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="is_favorite" value="{{ $productlist->is_favorite ? 0 : 1 }}">
                                                <button type="submit" class="flex items-center focus:outline-none" onclick="event.stopPropagation();">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $productlist->is_favorite ? 'gold' : 'lightgray' }}" viewBox="0 0 24 24" class="w-4 h-4 mr-1">
                                                        <path d="M12 .587l3.668 7.568 8.332 1.207-6 5.848 1.416 8.25L12 18.896l-7.416 3.908L6 14.162l-6-5.848 8.332-1.207z"/>
                                                    </svg>
                                                </button>
                                            </form>

                                            <!-- Name Editing Form (Themed Title) -->
                                            <form action="{{ route('lists.updateName', $productlist->id) }}" method="POST" class="mt-2 flex-grow relative flex justify-center items-center">
                                                @csrf
                                                <input type="text" name="name" value="{{ $productlist->name }}" 
                                                       class="bg-transparent text-white focus:outline-none p-3 w-auto max-w-max border-2 border-transparent focus:border-blue-500 rounded-full text-center peer placeholder-black"
                                                       placeholder="Enter list name"
                                                       required 
                                                       onkeydown="if(event.key === 'Enter'){ this.form.submit(); }">
                                            </form>

                                            <span class="text-white text-sm font-bold px-3 py-1 rounded-full" 
                                                  style="background-color: {{ $productlist->theme->count_circle_color }};">
                                                {{ $productlist->products->count() }}
                                            </span>
                                        </div>
                                        <span id="date-{{ $productlist->id }}" class="text-xs text-white mt-1 transition-opacity duration-300">
                                            {{ $productlist->updated_at->format('M d, Y') }}
                                        </span>
                                    </div>

                                    <!-- Products List (Moved here to be directly below the list name) -->
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow mt-4 w-full">
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
                                </article>
                            </div>
                        </div>

                        <!-- Add Products Button -->
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}" 
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                                Add Products
                            </a>
                        </div>

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
                            <a href="{{ route('lists.index') }}" 
                                class="flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow transition">
                                Back to Lists
                            </a>
                            <a href="{{ route('productlist.edit', $productlist->id) }}" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                                Edit List
                            </a>
                            <form action="{{ route('productlist.destroy', $productlist->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                                    Delete List
                                </button>
                            </form>
                        </div>           
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="w-full md:w-1/3">
                <div class="bg-white white:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
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
        </div>
    </div>
</x-app-layout>