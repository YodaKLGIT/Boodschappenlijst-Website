<x-app-layout>
    <!-- Header Section -->
    <!-- Header Section -->
    <div class="bg-blue-800 -xl p-6 mb-6">
        <div class="max-w-screen-lg mx-auto flex flex-col lg:flex-row items-center">
            <div class="text-center lg:text-left lg:mr-auto mb-4 lg:mb-0">
                <h1 class="text-3xl font-extrabold text-white">Your Product Lists</h1>
                <p class="text-md font-light text-white">Manage your grocery lists and keep track of your favorite products.</p>
            </div>
            <div class="flex justify-center lg:justify-end space-x-3">
                <a href="{{ route('productlist.create') }}" class="btn-primary inline-flex items-center px-4 py-2 text-white bg-blue-600 hover:bg-blue-500 rounded-lg">Create a new list</a>
                <a href="{{ route('lists.index') }}" class="btn-secondary inline-flex items-center px-4 py-2 text-white bg-gray-600 hover:bg-gray-500 rounded-lg">All Lists</a>
                <a href="{{ route('lists.favorites') }}" class="btn-secondary inline-flex items-center px-4 py-2 text-white bg-gray-600 hover:bg-gray-500 rounded-lg">Favorite Lists</a>
            </div>
        </div>
    </div>

    <!-- Product Lists Content Section -->
    <div class="container mx-auto px-4 py-8 mb-16">
        @if ($lists->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 max-w-md mx-auto">
                <p class="text-gray-600 mb-4">No product lists available.</p>
            </div>
        @else
            <div class=" p-8 rounded-lg border-2  shadow-xl">
                <div class="flex flex-col lg:flex-row space-y-6 lg:space-y-0 lg:space-x-6">
                    <!-- Filter Section -->
                    <div class="lg:w-1/5 bg-white p-6 rounded-lg shadow-lg border border-sky-200">
                        <h2 class="font-semibold text-lg text-gray-800 mb-6">Filters</h2>
                        <form action="{{ route('lists.index') }}" method="GET">
                            <div class="relative mb-6">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-sky-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                    <span class="sr-only">Search icon</span>
                                </div>
                                <input type="text" name="search" id="search-navbar" class="block w-full p-2 pl-10 text-sm text-black border border-sky-300 rounded-md bg-sky-50 focus:ring-2 focus:ring-sky-500 focus:border-sky-500" placeholder="Search..." value="{{ request('search') }}">
                            </div>

                            <label for="sort" class="block mb-2 text-sm font-medium text-gray-700">Order By</label>
                            <select id="sort" name="sort" class="w-full border-sky-300 rounded-md shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500" onchange="this.form.submit()">
                                <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Name</option>
                                <option value="last_added" {{ request('sort') === 'last_added' ? 'selected' : '' }}>Last Added</option>
                                <option value="last_updated" {{ request('sort') === 'last_updated' ? 'selected' : '' }}>Last Updated</option>
                                <option value="product_count" {{ request('sort') === 'product_count' ? 'selected' : '' }}>Product Count</option>
                                <option value="brand" {{ request('sort') === 'brand' ? 'selected' : '' }}>Brand</option>
                                <option value="category" {{ request('sort') === 'category' ? 'selected' : '' }}>Category</option>
                            </select>
                        </form>
                    </div>

                    <!-- Cards Section -->
                    <div class="lg:w-4/5">
                        <div class="bg-sky-50 p-8 rounded-lg border-2 border-sky-200 shadow-md">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($lists as $productlist)
                                    <x-product-list-card :productlist="$productlist" />
                                @endforeach
                            </div>
                        </div>
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

