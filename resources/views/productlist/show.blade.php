<x-app-layout>
    <!-- Product List Title Section -->
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Product List</h1>
                <img src="{{ asset('images/list.png') }}" alt="Product List" class="w-16 h-16 object-contain">
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 mb-16">
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-full">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="w-full">
                        <div class="shopping-list-wrapper">
                            <article class="rounded-xl bg-white shadow-md overflow-hidden h-auto">
                                <div class="p-3 flex flex-col" 
                                     style="background-color: {{ $productlist->theme->strap_color }};"
                                     onclick="toggleProducts(event, '{{ $productlist->id }}')">
                                    <div class="flex items-center justify-between">
                                        <form action="{{ route('lists.toggleFavorite', $productlist->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="is_favorite" value="{{ $productlist->is_favorite ? 0 : 1 }}">
                                            <button type="submit" class="flex items-center focus:outline-none" 
                                                    onclick="event.stopPropagation();">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $productlist->is_favorite ? 'gold' : 'lightgray' }}" 
                                                     viewBox="0 0 24 24" class="w-4 h-4 mr-1">
                                                    <path d="M12 .587l3.668 7.568 8.332 1.207-6 5.848 1.416 8.25L12 18.896l-7.416 3.908L6 14.162l-6-5.848 8.332-1.207z"/>
                                                </svg>
                                            </button>
                                        </form>

                                        <!-- Name Editing Form -->
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
                                <!-- Product details will go here -->
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

