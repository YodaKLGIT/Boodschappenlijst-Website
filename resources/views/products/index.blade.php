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
                    console.log('Dropdown toggled'); // Debug log
                });
            } else {
                console.log('Select list button not found'); // Debug log
            }

            // Handle list selection
            document.querySelectorAll('.list-option').forEach(button => {
                button.addEventListener('click', function() {
                    selectedListId = this.getAttribute('data-list-id');
                    dropdownMenu.classList.add('hidden'); // Hide dropdown after selection
                    selectListButton.innerText = this.innerText; // Update button text
                    console.log("Selected List ID:", selectedListId); // Debugging log

                    // Update hidden input value
                    document.querySelector('input[name="list_id"]').value = selectedListId;

                    // Store selected list ID in session storage
                    sessionStorage.setItem('selectedListId', selectedListId);
                    sessionStorage.setItem('selectedListName', this.innerText);
                });
            });

            // Handle product click
            document.querySelectorAll('.product-card').forEach(product => {
                product.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');

                    if (!selectedListId) {
                        alert('Please select a list first.');
                        console.log('No list selected'); // Debug log
                        return;
                    }

                    // Update hidden input value
                    document.querySelector('input[name="product_id"]').value = productId;

                    // Submit the form
                    document.querySelector('#add-product-form').submit();
                });
            });

            // Close dropdowns when clicking outside
            window.addEventListener('click', function() {
                dropdownMenu.classList.add('hidden'); // Hide the dropdown
                console.log('Dropdown closed'); // Debug log
            });

            // Restore selected list from session storage
            if (selectedListId) {
                document.querySelector('input[name="list_id"]').value = selectedListId;
                selectListButton.innerText = sessionStorage.getItem('selectedListName');
            }

            // Show toast notification if product was added
            @if(session('success'))
                showToast("{{ session('success') }}");
            @endif
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

    <div class="text-center p-10">
        <h1 class="font-bold text-4xl mb-4">Products</h1>
    </div>

    <div class="flex justify-center items-center space-x-4 mb-10">
        <!-- Product List Filter -->
        <div class="relative">
            <button class="border rounded-lg p-2 flex items-center select-list-button">
                Select List
                <svg class="inline h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <div class="absolute hidden mt-1 bg-white rounded-lg shadow-lg z-10">
                <ul class="py-1">
                    @foreach ($lists as $list)
                        <li>
                            <button class="list-option block px-4 py-2 hover:bg-gray-200 w-full text-left"
                                data-list-id="{{ $list->id }}">
                                {{ $list->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Adding Product to List -->
    <form id="add-product-form" action="{{ route('productlist.add') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="list_id" value="">
        <input type="hidden" name="product_id" value="">
    </form>

    <!-- Product Cards Section -->
    <section id="Products" class="w-full mx-auto px-0 mb-5">
        <div class="container mx-auto py-8 p-0">
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
                                    <div class="flex items-center mt-2">
                                        <p class="text-lg font-semibold text-black cursor-auto my-3">
                                            {{ $product->price ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>