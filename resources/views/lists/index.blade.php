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
                <p class="text-gray-600 mb-4">No product lists available.</p>
                <a href="{{ route('productlist.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-pink-600 px-4 py-2 text-white hover:bg-pink-700 transition-colors duration-300">
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
                            <label for="sort" class="block mb-2 text-sm font-medium text-gray-700">Order By</label>
                            <select id="sort" name="sort" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-0 focus:border-gray-300" onchange="this.form.submit()">
                                <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Name</option>
                                <option value="last_added" {{ request('sort') === 'last_added' ? 'selected' : '' }}>Last Added</option>
                                <option value="last_updated" {{ request('sort') === 'last_updated' ? 'selected' : '' }}>Last Updated</option>
                                <option value="product_count" {{ request('sort') === 'product_count' ? 'selected' : '' }}>Product Count</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Cards Section -->
                <div class="lg:w-4/5">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($productlists as $productlist)
                            <div class="w-full">
                                <div class="shopping-list-wrapper">
                                    <article class="rounded-xl bg-white shadow-md overflow-hidden h-auto">
                                        <div class="p-3 flex flex-col cursor-pointer" 
                                             onclick="toggleProducts(event, '{{ $productlist->id }}')"
                                             style="background-color: {{ $productlist->theme->strap_color }};">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-lg font-semibold text-white truncate pr-2">{{ $productlist->name }}</h3>
                                                <span class="text-white text-sm font-bold px-3 py-1 rounded-full" 
                                                      style="background-color: {{ $productlist->theme->count_circle_color }}">
                                                    {{ $productlist->products->count() }}
                                                </span>
                                            </div>
                                            <span id="date-{{ $productlist->id }}" class="text-xs text-white mt-1 transition-opacity duration-300">
                                                {{ $productlist->updated_at->format('M d, Y')}}
                                            </span>
                                        </div>
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
                                                                    <a href="{{ route('products.index', $product->id) }}" class="text-gray-600 truncate flex-1 hover:bg-[{{ $productlist->theme->hover_color }}] hover:text-gray-800 rounded px-1 transition-colors duration-200">
                                                                        {{ $product->brand->name }} {{ $product->name }}
                                                                    </a>
                                                                    <span class="text-gray-500 ml-2 bg-white px-2 py-1 rounded-full text-xs">{{ $product->pivot->quantity }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
