<div class="w-full">
    <div class="shopping-list-wrapper">
        <article class="rounded-xl shadow-md overflow-hidden h-auto 
                        {{ $productlist->is_favorite ? 'border-4 border-yellow-400 bg-yellow-50' : 'bg-white' }}">
            <div class="p-3 flex flex-col cursor-pointer"
                 onclick="toggleProducts(event, '{{ $productlist->id }}')"
                 style="background-color: {{ $productlist->theme->strap_color }};">
                <div class="flex items-center justify-between relative">
                    <!-- Gold Star Before Name -->
                    <form action="{{ route('lists.toggleFavorite', $productlist->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="is_favorite" value="{{ $productlist->is_favorite ? 0 : 1 }}"> <!-- Toggle the value -->
                        <button type="submit" class="flex items-center focus:outline-none" onclick="event.stopPropagation();">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $productlist->is_favorite ? 'gold' : 'lightgray' }}" viewBox="0 0 24 24" class="w-4 h-4 mr-1">
                                <path d="M12 .587l3.668 7.568 8.332 1.207-6 5.848 1.416 8.25L12 18.896l-7.416 3.908L6 14.162l-6-5.848 8.332-1.207z"/>
                            </svg>
                        </button>
                    </form>
                    

                    <a href="{{ route('productlist.show', [$productlist->id]) }}"
                       id="product-link-{{ $productlist->id }}"
                       class="text-lg font-semibold text-white truncate pr-2"
                       onclick="event.stopPropagation();">
                        <h3 class="text-lg font-semibold text-white truncate">
                            {{ $productlist->name }}
                        </h3>
                    </a>

                    <span class="text-white text-sm font-bold px-3 py-1 rounded-full"
                          style="background-color: {{ $productlist->theme->count_circle_color }};">
                          {{ $productlist->products->sum(fn($product) => $product->pivot->quantity) }}
                    </span>
                </div>
                <span id="date-{{ $productlist->id }}" class="text-xs text-white mt-1 transition-opacity duration-300">
                    <span class="text-white-500 text-xs">Updated on:</span> {{ $productlist->updated_at->format('M d, Y') }}
                </span>
            </div>
            @if ($productlist->products->isNotEmpty())
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
                                            
                                            <form action="{{ route('product.markAsSeen', ['list' => $productlist->id, 'product' => $product->id]) }}" 
                                                method="POST" 
                                                class="mt-2 flex justify-center items-center space-x-2">
                                            @csrf
                                                                                    
                                            <!-- New badge inside the form -->
                                            @if ($product->pivot->is_new)
                                                <button type="submit" 
                                                        class="text-white bg-red-500 rounded px-2 py-1 hover:bg-red-600 focus:outline-none text-xs -mt-1 mr-4">
                                                    NEW
                                                </button>
                                            @endif
                                          </form>   
                                 
                                            <!-- Product Name -->
                                            <a href="{{ route('products.index', $product->id) }}"
                                               class="text-gray-600 truncate flex-1 hover:text-{{$productlist->theme->hover_color}} duration-200">
                                                {{ $product->brand->name }} {{ $product->name }}
                                            </a>
                                 
                                            <!-- Additional Info -->
                                            <span class="text-gray-500 ml-2 bg-white px-2 py-1 rounded-full text-xs">{{ $product->pivot->quantity }}</span>
                                            
                                            <!-- Remove Button -->
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


