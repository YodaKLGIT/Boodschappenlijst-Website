
<x-app-layout>
        <h3 class="text-2xl font-medium text-yellow mb-4 text-center">Product List: {{ $productlist->name }}</h3>

    <div class="max-w-sm mx-auto mt-4">
        <article class="rounded-xl border border-gray-700 bg-gray-800 p-4">
            <ul class="space-y-1 mt-2">
                <li class="list-item">
                    <div class="bg-gray-700 rounded-t p-2 transition-all duration-300 ease-in-out">
                        <div class="flex justify-between items-center">
                            <strong class="font-medium text-white text-lg">Products</strong>
                            <div class="relative inline-block text-left">
                                <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    Actions
                                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="dropdownInformation" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformationButton">
                                        <li>
                                            <a href="{{ route('productlist.edit', $productlist->id) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit List</a>
                                        </li>
                                        <li>
                                            <form action="{{ route('productlist.destroy', $productlist->id) }}" method="POST" class="block px-4 py-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete List</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="products rounded-b bg-gray-600 p-2 overflow-hidden transition-all duration-300 ease-in-out mt-2">
                        <div class="space-y-1 mt-1">
                            @if($products->isEmpty())
                                <div class="text-gray-400">
                                    <p>No products found in this shopping list.</p>
                                </div>
                            @else
                                @php
                                    $groupedProducts = $products->groupBy('category.name');
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
                            @endif
                        </div>
                    </div>
                </li>
            </ul>
        </article>
    </div>
</x-app-layout>

