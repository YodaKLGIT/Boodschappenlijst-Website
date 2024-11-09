<x-app-layout>
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
            </article>
        </div>
    </div>

    <!-- Product Details Section -->
    <div class="container mx-auto px-4 py-8 mb-16">
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-gray-800">Products</h4>
                <div class="relative inline-block text-left">
                    <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
                        Actions
                        <svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div id="dropdownInformation" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInformationButton">
                            <li>
                                <a href="{{ route('productlist.edit', $productlist->id) }}" class="block px-4 py-2 hover:bg-gray-100">Edit List</a>
                            </li>
                            <li>
                                <form action="{{ route('productlist.destroy', $productlist->id) }}" method="POST" class="block px-4 py-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-left hover:bg-gray-100">Delete List</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Products by Category -->
            <div class="products bg-gray-50 rounded-lg p-4">
                @if($productlist->products->isEmpty())
                    <div class="text-gray-500 text-center">
                        <p>No products found in this shopping list.</p>
                    </div>
                @else
                    @php
                        $groupedProducts = $productlist->products->groupBy('category.name');
                    @endphp
                    @foreach ($groupedProducts as $category => $products)
                        <div class="category-section mb-6">
                            <h5 class="text-lg font-semibold text-blue-600 mb-3">{{ $category }}</h5>
                            @foreach ($products as $product)
                                <div class="flex justify-between items-center bg-white shadow-sm rounded-lg p-3 mb-3">
                                    <div class="flex items-center">
                                        <p class="text-gray-800 font-medium mr-2">{{ $product->brand->name }}</p>
                                        <p class="text-gray-800">{{ $product->name }}</p>
                                    </div>
                                    <div class="text-gray-800">
                                        <span class="font-medium">Quantity:</span> {{ $product->pivot->quantity }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Notes Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">Add a Note</h4>
            <form action="{{ route('list.notes.store', $productlist->id) }}" method="POST" class="bg-gray-50 p-4 rounded-lg">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                    <input type="text" id="title" name="title" placeholder="Note Title" class="w-full p-3 rounded bg-white border border-gray-300 text-gray-800" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea id="description" name="description" placeholder="Note Description" class="w-full p-3 rounded bg-white border border-gray-300 text-gray-800" required></textarea>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-5 py-2.5">Add Note</button>
            </form>
        </div>

        <!-- Notes Display -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">Notes</h4>
            <div class="bg-gray-50 p-4 rounded-lg">
                @forelse($productlist->notes as $note)
                    <div class="bg-white shadow-sm rounded-lg p-4 mb-4">
                        <div class="mb-2">
                            <span class="block text-gray-700 font-medium">Title:</span>
                            <h5 class="text-gray-800 font-semibold">{{ $note->title }}</h5>
                        </div>
                        <div>
                            <span class="block text-gray-700 font-medium">Description:</span>
                            <p class="text-gray-600">{{ $note->description }}</p>
                        </div>
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">No notes available.</p>
                @endforelse
            </div>
        </div>

        <!-- Connected Users Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
    <h4 class="text-xl font-semibold text-gray-800 mb-4">Connected Users</h4>
    <div class="bg-gray-50 p-4 rounded-lg">
        @if($productlist->sharedUsers->isEmpty())
            <p class="text-gray-500 text-center">No users connected to this list.</p>
        @else
            <ul>
                @foreach($productlist->sharedUsers as $user)
                    <li class="text-gray-800 flex justify-between items-center">
                        <span>{{ $user->name }} ({{ $user->email }})</span>
                        @if($isOwner && $user->id !== $owner->id)
                            <form action="{{ route('productlist.removeUser', [$productlist->id, $user->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

        <!-- Invite Users Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">Invite Users</h4>
            <form action="{{ route('productlist.invite', $productlist->id) }}" method="POST" class="bg-gray-50 p-4 rounded-lg">
                @csrf
                <div class="mb-4">
                    <label for="user_id" class="block text-gray-700 font-medium mb-2">Select User</label>
                    <select id="user_id" name="user_id" class="w-full p-3 rounded bg-white border border-gray-300 text-gray-800" required>
                        <option value="">Select a user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-5 py-2.5">Invite User</button>
            </form>
        </div>

        <!-- List Details Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-8">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">List Details</h4>
            <div class="bg-gray-50 p-4 rounded-lg">
                <span class="text-xs text-gray-700 mt-1 transition-opacity duration-300">
                    Created by: {{ $owner->name ?? 'Unknown' }}
                </span>
            </div>
        </div>
    </div>
</x-app-layout>