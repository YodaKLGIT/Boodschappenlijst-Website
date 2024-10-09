<x-app-layout>
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

    <section>
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Shopping Lists</h2>
                
                <img src="images/list.png" alt="" class="mx-auto mt-4 w-32 h-32 object-contain">
            </div>

            <div class="flex flex-col lg:flex-row">
                <!-- Filter Section -->
                <div class="lg:w-1/5 mb-6 lg:mb-0 lg:pr-6">
                    <div class="bg-gray-100 p-6 rounded-lg h-full flex flex-col justify-end">
                        <div class="mt-8">
                            <form action="{{ route('lists.index') }}" method="GET">
                                <label for="sort" class="block mb-2 text-sm font-semibold text-gray-900">Sort By</label>
                                <select id="sort" name="sort" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" onchange="this.form.submit()">
                                    <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Name</option>
                                    <option value="last_added" {{ request('sort') === 'last_added' ? 'selected' : '' }}>Last Added</option>
                                    <option value="last_updated" {{ request('sort') === 'last_updated' ? 'selected' : '' }}>Last Updated</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Cards Section -->
                <div class="lg:w-4/5">
                    <div class="lg:col-span-2 lg:pt-10">
                        <div class="overflow-x-auto">
                            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($shoppinglists as $shoppinglist)
                                    <li class="w-full">
                                        <div class="shopping-list-wrapper">
                                            <article class="rounded-xl p-4 w-full h-full">
                                                <ul class="space-y-1">
                                                    <li class="list-item">
                                                        <div class="bg-gray-700 rounded-t p-2 h-16 flex items-center"> <!-- Fixed height -->
                                                            <a href="#" class="w-full" onclick="toggleProducts(event, '{{ $shoppinglist->id }}')">
                                                                <strong class="font-medium text-white text-lg line-clamp-1">{{ $shoppinglist->name }}</strong>
                                                            </a>
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
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>