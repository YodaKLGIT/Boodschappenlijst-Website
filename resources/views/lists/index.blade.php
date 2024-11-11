<x-app-layout>

    <!-- Product Lists Header Section -->
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <h1 class="text-2xl font-semibold text-gray-800 mb-2">Product Lists</h1>
                <img src="{{ asset('images/list.png') }}" alt="Product Lists"
                    class="mx-auto w-16 h-16 object-contain mb-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
            </div>
        </div>
    </div>

    <!-- Navigation Section (Below the header) -->
    <div class="bg-white shadow-sm mb-6">
        <div class="container mx-auto px-4 py-3">
            <div class="flex space-x-4">
                <a href="{{ route('lists.index') }}" class="text-sm font-semibold text-gray-700 hover:text-gray-900">All
                    Lists</a>
                <a href="{{ route('lists.favorites') }}"
                    class="text-sm font-semibold text-gray-700 hover:text-gray-900">Favorites</a>
            </div>
        </div>
    </div>

    <!-- Product Lists Content Section -->
    <div class="container mx-auto px-4 py-8 mb-16">
        <!-- Centered and Larger Create Button -->
        <div class="flex justify-center mb-6">
            <a href="{{ route('productlist.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-pink-600 px-6 py-3 text-white hover:bg-pink-700 transition-colors duration-300 text-lg">
                <span class="text-lg">Create a new list</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>
        </div>

        @if ($lists->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 max-w-md mx-auto">
                <p class="text-gray-600 mb-4">No product lists available.</p>
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
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                    <span class="sr-only">Search icon</span>
                                </div>
                                <input type="text" name="search" id="search-navbar"
                                    class="block w-full p-2 pl-10 text-sm text-black border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Search..." value="{{ request('search') }}">
                            </div>

                            <label for="sort" class="block mb-2 text-sm font-medium text-gray-700 mt-4">Order
                                By</label>
                            <select id="sort" name="sort"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-0 focus:border-gray-300"
                                onchange="this.form.submit()">
                                <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Name</option>
                                <option value="last_added" {{ request('sort') === 'last_added' ? 'selected' : '' }}>Last
                                    Added</option>
                                <option value="last_updated" {{ request('sort') === 'last_updated' ? 'selected' : '' }}>
                                    Last Updated</option>
                                <option value="product_count"
                                    {{ request('sort') === 'product_count' ? 'selected' : '' }}>Product Count</option>
                                <option value="brand" {{ request('sort') === 'brand' ? 'selected' : '' }}>Brand
                                </option>
                                <option value="category" {{ request('sort') === 'category' ? 'selected' : '' }}>
                                    Category</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Cards Section -->
                <div class="lg:w-4/5">

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($lists->where('is_favorite', true) as $productlist)
                            <x-product-list-card :productlist="$productlist" />
                        @endforeach
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($lists->where('is_favorite', false) as $productlist)
                            <x-product-list-card :productlist="$productlist" />
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutLink = document.querySelector('a[href="{{ route('logout') }}"]');
            if (logoutLink) {
                logoutLink.addEventListener('click', function() {
                    sessionStorage.clear();
                });
            }

            // Check if there are any lists available
            const lists = @json($lists);
            if (lists.length === 0) {
                sessionStorage.removeItem('selectedListId');
                sessionStorage.removeItem('selectedListName');
                // Update the dropdown to show a message
                const selectListButton = document.querySelector('.select-list-button');
                if (selectListButton) {
                    selectListButton.innerHTML = 'No lists available';
                }
            }
        });
    </script>
</x-app-layout>