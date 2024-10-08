<x-app-layout>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.relative > button').forEach(button => {
                button.addEventListener('click', function () {
                    const dropdown = this.nextElementSibling;
                    dropdown.classList.toggle('hidden');
                });
            });

            // Close dropdowns when clicking outside
            window.addEventListener('click', function (e) {
                if (!e.target.closest('.relative')) {
                    document.querySelectorAll('.absolute').forEach(dropdown => {
                        dropdown.classList.add('hidden');
                    });
                }
            });
        });
    </script>

    <div class="text-center p-10">
        <h1 class="font-bold text-4xl mb-4">Products</h1>
    </div>

    <div class="flex justify-center items-center space-x-4 mb-10">
        <!-- Sort Dropdown -->
        <div class="relative">
            <button class="border rounded-lg p-2 flex items-center">
                Sort
                <span class="ml-1 text-gray-600">{{ request()->sort ?? 'Select Sorting' }}</span>
                <svg class="inline h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <!-- Dropdown Options -->
            <div class="absolute hidden mt-1 bg-white rounded-lg shadow-lg z-10">
                <ul class="py-1">
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}" class="block px-4 py-2 hover:bg-gray-200">Ascending</a>
                    </li>
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}" class="block px-4 py-2 hover:bg-gray-200">Descending</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Brand Filter -->
        <div class="relative">
            <button class="border rounded-lg p-2 flex items-center">
                Brand
                <span class="ml-1 text-gray-600">{{ request()->brand ? $brands->find(request()->brand)->name : 'Select a brand' }}</span>
                <svg class="inline h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <!-- Dropdown Options -->
            <div class="absolute hidden mt-1 bg-white rounded-lg shadow-lg z-10">
                <ul class="py-1">
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['brand' => null]) }}" class="block px-4 py-2 hover:bg-gray-200">All Brands</a>
                    </li>
                    @foreach($brands as $brand)
                        <li>
                            <a href="{{ request()->fullUrlWithQuery(['brand' => $brand->id]) }}" class="block px-4 py-2 hover:bg-gray-200">
                                {{ $brand->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Reset Filters Button -->
        <a href="{{ request()->fullUrlWithQuery(['sort' => null, 'brand' => null]) }}" class="border rounded-lg p-2 bg-blue-500 text-white">Reset Filters</a>
    </div>

    <!-- ✅ Grid Section - Starts Here 👇 -->
    <section id="Projects" class="w-full mx-auto px-0 mb-5">
        <div class="container mx-auto py-8 p-0">
            <div class="flex justify-center">
                <div class="max-w-screen-xl">
                    <div class="inline-grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($products as $product)
                        <!-- ✅ Product card - Starts Here 👇 -->
                        <div class="w-64 bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
                            <a href="#">
                                <img src="https://via.placeholder.com/300" alt="{{ $product->name }}" class="h-64 w-full object-cover rounded-t-xl" />
                                <div class="px-4 py-3">
                                    <span class="text-gray-400 mr-3 uppercase text-xs">{{ $product->brand->name ?? 'Brand' }}</span>
                                    <p class="text-lg font-bold text-black truncate block capitalize">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600 truncate">{{ $product->description }}</p>
                                    <div class="flex items-center mt-2">
                                        <p class="text-lg font-semibold text-black cursor-auto my-3">{{ $product->price ?? 'N/A' }}</p>
                                        @if ($product->discounted_price)
                                        <del>
                                            <p class="text-sm text-gray-600 cursor-auto ml-2">{{ $product->original_price }}</p>
                                        </del>
                                        @endif
                                        <div class="ml-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-bag-plus" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z" />
                                                <path
                                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
