<x-app-layout>
    <h3 class="text-2xl font-medium text-yellow mb-4 text-center">Shopping Lists</h3>

    @if($shoppinglists->isEmpty())
        <div class="max-w-sm mx-auto mt-4">
            <div role="alert" id="notification" class="rounded-xl bg-white p-4 dark:bg-gray-900">
                <div class="flex items-start gap-4">
                    <span class="text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <strong class="block font-medium text-gray-900 dark:text-white">No shopping lists available</strong>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-200">
                            You haven't created any shopping lists yet. Click below to create one!
                        </p>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('shoppinglist.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                                <span class="text-sm">Create a new list</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Flex Container for Filter and Lists -->
        <div class="flex flex-col md:flex-row items-start gap-4 px-4">
            <!-- Filter Section -->
            <div class="w-[400px] p-4"> <!-- Increased filter width to 400px for better usability -->
                <form action="{{ route('shoppinglist.index') }}" method="GET">
                    <label for="sort" class="block mb-1 text-sm font-semibold">Sort</label>
                    <select id="sort" name="sort" class="border rounded-md p-1 text-sm w-full" onchange="this.form.submit()">
                        <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
                        <option value="last_added" {{ request('sort') === 'last_added' ? 'selected' : '' }}>Last Added</option>
                        <option value="last_updated" {{ request('sort') === 'last_updated' ? 'selected' : '' }}>Last Updated</option>
                    </select>
                </form>
            </div>

            <!-- Shopping Lists Section -->
            <section class="flex-1 p-2"> <!-- Allow the shopping lists section to grow -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4"> <!-- Ensured two lists on small screens -->
                    @foreach ($shoppinglists as $shoppinglist)
                        <div class="shopping-list-wrapper"> <!-- New wrapper div -->
                            <article class="rounded-xl border border-gray-700 bg-gray-800 p-4 w-full mx-auto">
                                <ul class="space-y-1">
                                    <li class="list-item">
                                        <div class="bg-gray-700 rounded-t p-2 transition-all duration-300 ease-in-out">
                                            <div class="flex justify-between items-center p-2"> <!-- Added padding for spacing -->
                                                <a href="#" class="flex-grow" onclick="toggleProducts(event, '{{ $shoppinglist->id }}')">
                                                    <strong class="font-medium text-white text-lg">{{ $shoppinglist->name }}</strong>
                                                </a>
                                                <!-- Dropdown Button -->
                                                <div class="relative inline-block text-left">
                                                    <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                        Actions
                                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                                        </svg>
                                                    </button>

                                                    <!-- Dropdown menu -->
                                                    <div id="dropdownInformation" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformationButton">
                                                            <li>
                                                                <a href="{{ route('shoppinglist.show', $shoppinglist->id) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">View</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('shoppinglist.edit', $shoppinglist->id) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('shoppinglist.destroy', $shoppinglist->id) }}" method="POST" class="block px-4 py-2">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="w-full text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="products rounded-b bg-gray-600 p-2 overflow-hidden transition-all duration-300 ease-in-out" id="products-{{ $shoppinglist->id }}" style="max-height: 0; opacity: 0;">
                                            <div class="space-y-1 mt-1">
                                                @php
                                                    $groupedProducts = $shoppinglist->products->groupBy('category.name');
                                                @endphp
                                                @foreach ($groupedProducts as $category => $products)
                                                    <div class="category-section">
                                                        <h4 class="text-base font-semibold text-white">{{ $category }}</h4>
                                                        @foreach ($products as $product)
                                                            <div class="flex justify-between border-b border-gray-500 pb-1 mb-1">
                                                                <div class="flex items-center">
                                                                    <p class="text-white mr-1">{{ $product->brand->name }}</p>
                                                                    <p class="text-white">{{ $product->name }}</p>
                                                                </div>
                                                                <div class="text-white">
                                                                    <span class="font-medium">Quantity:</span> {{ $product->pivot->quantity }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </article>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
        <section class="flex justify-center mt-4">
            <a href="{{ route('shoppinglist.create') }}">
                <button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-full text-lg px-6 py-4 transition-all duration-300 ease-in-out transform hover:scale-110 active:scale-95">
                    +
                </button>
            </a>
        </section>
    @endif

     <!-- Section for the button -->
    
</x-app-layout>






































