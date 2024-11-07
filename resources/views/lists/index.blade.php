<x-app-layout>
    <!-- Product Lists Title Section -->
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Product Lists</h1>
                <img src="{{ asset('images/list.png') }}" alt="Product Lists" class="w-16 h-16 object-contain">
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 mb-16">
        @if($productlists->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 max-w-md mx-auto">
                <p class="text-gray-600 mb-4">No lists available.</p>
                <a href="{{ route('list.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-pink-600 px-4 py-2 text-white hover:bg-pink-700 transition-colors duration-300">
                    <span class="text-sm">Create a new list</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row">
                <!-- Filter Section -->
                <div class="lg:w-1/5 mb-6 lg:mb-0 lg:pr-6">
                    <div class="bg-white rounded-lg shadow-md p-4 sticky top-4">
                        <h2 class="font-semibold text-lg mb-4">Filters</h2>
                        <form action="{{ route('lists.index') }}" method="GET">
                            <div class="relative mb-4">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                    <span class="sr-only">Search icon</span>
                                </div>
                                <input type="text" name="search" id="search-navbar" class="block w-full p-2 pl-10 text-sm text-black border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." value="{{ request('search') }}">
                            </div>

                            <label for="sort" class="block mb-2 text-sm font-medium text-gray-700 mt-4">Order By</label>
                            <select id="sort" name="sort" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-0 focus:border-gray-300" onchange="this.form.submit()">
                                <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Name</option>
                                <option value="last_added" {{ request('sort') === 'last_added' ? 'selected' : '' }}>Last Added</option>
                                <option value="last_updated" {{ request('sort') === 'last_updated' ? 'selected' : '' }}>Last Updated</option>
                                <option value="product_count" {{ request('sort') === 'product_count' ? 'selected' : '' }}>Product Count</option>
                                <option value="brand" {{ request('sort') === 'brand' ? 'selected' : '' }}>Brand</option>
                                <option value="category" {{ request('sort') === 'category' ? 'selected' : '' }}>Category</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Cards Section -->
                <div class="lg:w-4/5">
                    <div class="mb-4">
                        <h2 class="text-gray-700 text-lg">Favorite Lists</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($productlists->where('is_favorite', true) as $productlist) <!-- Filter for favorite lists -->
                            <div class="w-full">
                                <div class="shopping-list-wrapper">
                                    <article class="rounded-xl bg-white shadow-md overflow-hidden h-auto">
                                        <div class="p-3 flex flex-col cursor-pointer" 
                                             onclick="toggleProducts(event, '{{ $productlist->id }}')"
                                             style="background-color: {{ $productlist->theme->strap_color }};">
                                            <div class="flex items-center justify-between">
                                                <!-- Gold Star Before Name -->
                                                <form action="{{ route('lists.toggleFavorite', $productlist->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="is_favorite" value="{{ $productlist->is_favorite ? 0 : 1 }}"> <!-- Toggle the value -->
                                                    <button type="submit" class="flex items-center focus:outline-none" 
                                                            onclick="event.stopPropagation();">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $productlist->is_favorite ? 'gold' : 'lightgray' }}" 
                                                             viewBox="0 0 24 24" class="w-4 h-4 mr-1">
                                                            <path d="M12 .587l3.668 7.568 8.332 1.207-6 5.848 1.416 8.25L12 18.896l-7.416 3.908L6 14.162l-6-5.848 8.332-1.207z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                
                                                <a href="{{ route('lists.show', [$productlist->id]) }}" 
                                                    id="product-link-{{ $productlist->id }}" 
                                                    class="text-lg font-semibold text-white truncate pr-2"
                                                    onclick="event.stopPropagation();">
                                                     <h3 class="text-lg font-semibold text-white truncate">
                                                         {{ $productlist->name }}
                                                     </h3>
                                                 </a>

                                                <span class="text-white text-sm font-bold px-3 py-1 rounded-full" 
                                                      style="background-color: {{ $productlist->theme->count_circle_color }};">
                                                    {{ $productlist->products->count() }}
                                                </span>
                                            </div>
                                            <span id="date-{{ $productlist->id }}" class="text-xs text-white mt-1 transition-opacity duration-300">
                                                {{ $productlist->updated_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                        @if ($productlist->products->isNotEmpty()) <!-- Check if there are products -->
                                            <div id="products-{{ $productlist->id }}" class="products overflow-hidden transition-all duration-300 ease-in-out flex-grow" 
                                                 style="max-height: 0; opacity: 0; background-color: {{ $productlist->theme->content_bg_color }};">
                                                <div class="p-4 space-y-4">
                                                    @foreach ($productlist->products->groupBy('category.name') as $category => $products)
                                                        <div class="category-section pb-4 border-b border-gray-200 last:border-b-0 last:pb-0">
                                                            <h4 class="font-medium text-gray-700 mb-2">{{ $category }}</h4>
                                                            <ul class="space-y-2">
                                                                @foreach ($products as $product)
                                                                    <li class="flex justify-between items-center text-sm p-2 rounded transition-colors duration-200"
                                                                        style="background-color: {{ $productlist->theme->body_color }};">
                                                                        <a href="{{ route('products.index', $product->id) }}" 
                                                                           class="text-gray-600 truncate flex-1 hover:text-{{$productlist->theme->hover_color}} duration-200">
                                                                            {{ $product->brand->name }} {{ $product->name }}
                                                                        </a>
                                                                        <span class="text-gray-500 ml-2 bg-white px-2 py-1 rounded-full text-xs">{{ $product->pivot->quantity }}</span>
                                                                        <form action="{{ route('lists.products.remove', [$productlist->id, $product->id]) }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors duration-300">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                                                </svg>
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif <!-- End of product check -->
                                    </article>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Text Section Below Favorite Lists -->
                    <div class="mt-4">
                        <h2 class="text-gray-600 text-lg">Normal Lists</h2>
                    </div>

                    <!-- Normal Lists Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($productlists->where('is_favorite', false) as $productlist) <!-- Filter for normal lists -->
                            <div class="w-full">
                                <div class="shopping-list-wrapper">
                                    <article class="rounded-xl bg-white shadow-md overflow-hidden h-auto">
                                        <div class="p-3 flex flex-col cursor-pointer" 
                                             onclick="toggleProducts(event, '{{ $productlist->id }}')"
                                             style="background-color: {{ $productlist->theme->strap_color }};">
                                            

                                            <div class="flex items-center justify-between">
                                                <!-- Gold Star or Greyed-Out Star Before Name -->
                                                <form action="{{ route('lists.toggleFavorite', $productlist->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="is_favorite" value="{{ $productlist->is_favorite ? 0 : 1 }}"> <!-- Toggle the value -->
                                                    <button type="submit" class="flex items-center focus:outline-none" 
                                                            onclick="event.stopPropagation();">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $productlist->is_favorite ? 'gold' : 'lightgray' }}" 
                                                             viewBox="0 0 24 24" class="w-4 h-4 mr-1">
                                                            <path d="M12 .587l3.668 7.568 8.332 1.207-6 5.848 1.416 8.25L12 18.896l-7.416 3.908L6 14.162l-6-5.848 8.332-1.207z"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                
                                                
                                                <a href="{{ route('lists.show', [$productlist->id]) }}" 
                                                    id="product-link-{{ $productlist->id }}" 
                                                    class="text-lg font-semibold text-white truncate pr-2"
                                                    onclick="event.stopPropagation();">
                                                     <h3 class="text-lg font-semibold text-white truncate">
                                                         {{ $productlist->name }}
                                                     </h3>
                                                 </a>
                     
                                                <span class="text-white text-sm font-bold px-3 py-1 rounded-full" 
                                                      style="background-color: {{ $productlist->theme->count_circle_color }};">
                                                    {{ $productlist->products->count() }}
                                                </span>
                                            </div>
                                            <span id="date-{{ $productlist->id }}" class="text-xs text-white mt-1 transition-opacity duration-300">
                                                {{ $productlist->updated_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                        @if ($productlist->products->isNotEmpty()) <!-- Check if there are products -->
                                            <div id="products-{{ $productlist->id }}" class="products overflow-hidden transition-all duration-300 ease-in-out flex-grow" 
                                                 style="max-height: 0; opacity: 0; background-color: {{ $productlist->theme->content_bg_color }};">
                                                <div class="p-4 space-y-4">
                                                    @foreach ($productlist->products->groupBy('category.name') as $category => $products)
                                                        <div class="category-section pb-4 border-b border-gray-200 last:border-b-0 last:pb-0">
                                                            <h4 class="font-medium text-gray-700 mb-2">{{ $category }}</h4>
                                                            <ul class="space-y-2">
                                                                @foreach ($products as $product)
                                                                    <li class="flex justify-between items-center text-sm p-2 rounded transition-colors duration-200"
                                                                        style="background-color: {{ $productlist->theme->body_color }};">
                                                                        <a href="{{ route('products.index', $product->id) }}" 
                                                                           class="text-gray-600 truncate flex-1 hover:text-{{$productlist->theme->hover_color}} duration-200">
                                                                            {{ $product->brand->name }} {{ $product->name }}
                                                                        </a>
                                                                        <span class="text-gray-500 ml-2 bg-white px-2 py-1 rounded-full text-xs">{{ $product->pivot->quantity }}</span>
                                                                        <form action="{{ route('lists.products.remove', [$productlist->id, $product->id]) }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors duration-300">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                                                </svg>
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif <!-- End of product check -->
                                    </article>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif <!-- Closing the if statement for checking if product lists are empty -->
    </div>
</x-app-layout>
