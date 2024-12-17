<x-app-layout>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedListId = sessionStorage.getItem('selectedListId') || null;

            // Toggle dropdown visibility for selecting a list
            const selectListButton = document.querySelector('.select-list-button');
            const dropdownMenu = document.querySelector('.select-list-button + .absolute');

            if (selectListButton) {
                selectListButton.addEventListener('click', function(event) {
                    event.stopPropagation(); // Prevent click from bubbling up
                    dropdownMenu.classList.toggle('hidden'); // Toggle visibility
                });
            }

            // Handle list selection
            document.querySelectorAll('.list-option').forEach(button => {
                button.addEventListener('click', function() {
                    selectedListId = this.getAttribute('data-list-id');
                    dropdownMenu.classList.add('hidden');
                    selectListButton.innerText = this.innerText;

                    document.querySelector('input[name="list_id"]').value = selectedListId;
                    sessionStorage.setItem('selectedListId', selectedListId);
                    sessionStorage.setItem('selectedListName', this.innerText);
                });
            });

            // Handle product card click
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function(event) {
                    if (event.target.closest('.quantity-input') || event.target.closest(
                            '.quantity-button')) {
                        return;
                    }

                    const productId = this.getAttribute('data-product-id');
                    const quantity = this.querySelector('.quantity-input').value;

                    if (!selectedListId) {
                        alert('Please select a list first.');
                        return;
                    }

                    document.querySelector('input[name="product_id"]').value = productId;
                    document.querySelector('input[name="quantity"]').value = quantity;
                    sessionStorage.setItem('productAdded', 'true');
                    document.querySelector('#add-product-form').submit();
                });
            });

            // Prevent quantity input click from triggering product card click
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            });

            // Handle increment and decrement buttons
            document.querySelectorAll('.quantity-button').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.stopPropagation();
                    const input = document.getElementById(this.getAttribute(
                        'data-input-counter-increment') || this.getAttribute(
                        'data-input-counter-decrement'));
                    let value = parseInt(input.value, 10);
                    if (this.getAttribute('data-input-counter-increment')) {
                        value++;
                    } else if (this.getAttribute('data-input-counter-decrement')) {
                        value = value > 1 ? value - 1 : 1;
                    }
                    input.value = value;
                });
            });

            // Restore selected list from session storage
            if (selectedListId) {
                document.querySelector('input[name="list_id"]').value = selectedListId;
                selectListButton.innerText = sessionStorage.getItem('selectedListName');
            }

            // Check if there are any lists available
            const lists = @json($lists);
            if (lists.length === 0) {
                sessionStorage.removeItem('selectedListId');
                sessionStorage.removeItem('selectedListName');
                // Update the dropdown to show a message
                if (selectListButton) {
                    selectListButton.innerText = 'No lists available';
                }
            }

            // Show toast notification if a product was added
            if (sessionStorage.getItem('productAdded') === 'true') {
                showToast('Product added to the list successfully!');
                sessionStorage.removeItem('productAdded');
            }

            // Toggle dropdown visibility for brand filter
            const brandButton = document.querySelector('.brand-button');
            const brandDropdown = document.querySelector('.brand-dropdown');

            if (brandButton) {
                brandButton.addEventListener('click', function(event) {
                    event.stopPropagation(); // Prevent click from bubbling up
                    brandDropdown.classList.toggle('hidden'); // Toggle visibility
                });
            }

            // Toggle dropdown visibility for sort filter
            const sortButton = document.querySelector('.sort-button');
            const sortDropdown = document.querySelector('.sort-dropdown');

            if (sortButton) {
                sortButton.addEventListener('click', function(event) {
                    event.stopPropagation(); // Prevent click from bubbling up
                    sortDropdown.classList.toggle('hidden'); // Toggle visibility
                });
            }

            // Close dropdowns when clicking outside
            window.addEventListener('click', function() {
                dropdownMenu.classList.add('hidden'); // Hide the list dropdown
                brandDropdown.classList.add('hidden'); // Hide the brand dropdown
                sortDropdown.classList.add('hidden'); // Hide the sort dropdown
            });
        });

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg';
            toast.innerText = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }, 3000);
        }
    </script>

    <div class="flex justify-center p-10">
        <!-- Sidebar -->
        <div class="w-64 p-6 bg-white border-r border-gray-200">
            <h2 class="font-bold text-xl mb-4">Filters</h2>

            <!-- Select List Dropdown -->
            <h3 class="font-semibold text-lg mb-2">Select list</h3>
            <div class="relative mb-4">
                <button
                    class="w-full border rounded-lg p-2 flex items-center select-list-button bg-blue-500 text-white hover:bg-blue-600">
                    Select List
                    <svg class="inline h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div class="absolute hidden mt-1 bg-white rounded-lg shadow-lg z-10 w-full">
                    <ul class="py-1">
                        @foreach ($lists as $list)
                            <li>
                                <button
                                    class="list-option block px-4 py-2 hover:bg-gray-200 w-full text-left text-gray-700"
                                    data-list-id="{{ $list->id }}">
                                    {{ $list->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Category Filter -->
            <h3 class="font-semibold text-lg mb-2">Category</h3>
            <div class="flex flex-col space-y-2 mb-4">
                @foreach ($categories as $category)
                    <a href="?category={{ $category->id }}" class="block border p-2 rounded-lg hover:bg-gray-200">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Brand Filter Dropdown -->
            <h3 class="font-semibold text-lg mb-2">Brand</h3>
            <div class="relative mb-4">
                <button
                    class="w-full border rounded-lg p-2 flex items-center brand-button bg-blue-500 text-white hover:bg-blue-600">
                    Brand
                    <span
                        class="ml-1 text-gray-600">{{ request()->brand ? $brands->find(request()->brand)->name : 'Select a brand' }}</span>
                    <svg class="inline h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div class="absolute hidden mt-1 bg-white rounded-lg shadow-lg z-10 w-full brand-dropdown">
                    <ul class="py-1">
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['brand' => null]) }}"
                                class="block px-4 py-2 hover:bg-gray-200">All Brands</a>
                        </li>
                        @foreach ($brands as $brand)
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['brand' => $brand->id]) }}"
                                    class="block px-4 py-2 hover:bg-gray-200">
                                    {{ $brand->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Sorting Options Dropdown -->
            <h3 class="font-semibold text-lg mb-2">Sort By</h3>
            <div class="relative mb-4">
                <button
                    class="w-full border rounded-lg p-2 flex items-center sort-button bg-blue-500 text-white hover:bg-blue-600">
                    Sort
                    <span
                        class="ml-1 text-gray-600">{{ request()->sort ? (request()->sort == 'asc' ? 'Name (A-Z)' : 'Name (Z-A)') : 'Select Sorting' }}</span>
                    <svg class="inline h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div class="absolute hidden mt-1 bg-white rounded-lg shadow-lg z-10 w-full sort-dropdown">
                    <ul class="py-1">
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}"
                                class="block px-4 py-2 hover:bg-gray-200">Sort by Asc</a>
                        </li>
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}"
                                class="block px-4 py-2 hover:bg-gray-200">Sort by Desc</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Reset Filters Button -->
            <div class="mt-4">
                <a href="{{ url()->current() }}"
                    class="block w-full text-center border rounded-lg p-2 bg-red-500 text-white hover:bg-red-600">
                    Reset Filters
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-10 pt-0">
            <h1 class="font-bold text-4xl mb-4 text-center">Products</h1>

            <!-- Product Cards Section -->
            <section id="Products" class="w-full mx-auto px-0 mb-5">
                <div class="container mx-auto py-0 p-0">
                    <div class="flex justify-center">
                        <div class="max-w-screen-xl">
                            <div class="inline-grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach ($products as $product)
                                    <div class="product-card w-64 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl"
                                        data-product-id="{{ $product->id }}">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                            class="h-64 w-full object-cover rounded-t-xl" />
                                        <div class="px-4 py-3">
                                            <span class="text-gray-400 mr-3 uppercase text-xs">
                                                {{ $product->brand->name ?? 'Brand' }}
                                            </span>
                                            <p class="text-lg font-bold text-black truncate block capitalize">
                                                {{ $product->name }}
                                            </p>
                                            <p class="text-sm text-gray-600 truncate">{{ $product->description }}</p>
                                            <div class="flex items-center justify-start mt-2">
                                                <label for="quantity-{{ $product->id }}" class="sr-only">Choose
                                                    quantity:</label>
                                                <div class="relative flex items-center max-w-[8rem]">
                                                    <button type="button"
                                                        data-input-counter-decrement="quantity-{{ $product->id }}"
                                                        class="quantity-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-2 h-8 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                        <svg class="w-3 h-3 text-gray-900 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 18 2">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                        </svg>
                                                    </button>
                                                    <input type="text" id="quantity-{{ $product->id }}"
                                                        data-input-counter data-input-counter-min="1"
                                                        class="quantity-input bg-gray-50 border-x-0 border-gray-300 h-8 font-bold text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        value="1" required />
                                                    <button type="button"
                                                        data-input-counter-increment="quantity-{{ $product->id }}"
                                                        class="quantity-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-2 h-8 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                        <svg class="w-3 h-3 text-gray-900 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 18 18">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M9 1v16M1 9h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Hidden Form for Adding Product to List -->
    <form id="add-product-form" action="{{ route('productlist.add') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="list_id" value="">
        <input type="hidden" name="product_id" value="">
        <input type="hidden" name="quantity" value="1">
    </form>
</x-app-layout>
