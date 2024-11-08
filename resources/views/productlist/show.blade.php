<x-app-layout>
    <div class="max-w-4xl mx-auto mt-8">
        <h3 class="text-3xl font-bold text-yellow-500 mb-6 text-center">Shopping List: {{ $productlist->name }}</h3>

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

                    <!-- Dropdown menu -->
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

        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">Add a Note</h4>
            <form action="{{ route('list.notes.store', $productlist->id) }}" method="POST" class="bg-gray-50 p-4 rounded-lg">
                @csrf
                <input type="hidden" name="list_id" value="{{ $productlist->id }}">
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
                            <button type="submit" class="text-red-600 hover:text-red-800">Remove Note</button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">No notes available for this list.</p>
                @endforelse
            </div>
        </div>

        <!-- Users connected to the list -->
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
                        @if(Auth::id() === $productlist->user_id)
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

        <div class="bg-white shadow-md rounded-lg p-6 mt-8">
               <h4 class="text-xl font-semibold text-gray-800 mb-4">List Details</h4>
               <div class="bg-gray-50 p-4 rounded-lg">
                   <span class="text-xs text-gray-700 mt-1 transition-opacity duration-300">
                       Created by: {{ $productlist->owner ? $productlist->owner->name : 'Unknown' }}
                   </span>
               </div>
           </div>

        <!-- Invite Users to the List -->
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
       </div>
   </x-app-layout>
