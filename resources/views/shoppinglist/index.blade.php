<x-app-layout>
    <!-- Header for the lists section -->
    <h3 class="text-2xl font-medium text-yellow mb-4 text-center">Lists</h3>
    
    <article class="rounded-xl border border-gray-700 bg-gray-800 p-6 max-w-xl mx-auto mt-4">
        <ul class="space-y-2 mt-4">
            <li class="list-item">
                <div class="bg-gray-700 rounded-t p-4 transition-all duration-300 ease-in-out">
                    <div class="flex justify-between items-center">
                        <a href="#" class="flex-grow" onclick="toggleProducts(event)">
                            <strong class="font-medium text-white text-lg">Vegetables</strong>
                        </a>
                    </div>
                </div>
                <div class="products rounded-b bg-gray-600 p-2 overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 0; opacity: 0;">
                    <div class="space-y-1 mt-1">
                        <div class="flex justify-between border-b border-gray-500 pb-2 mb-2">
                            <p class="text-white">Carrot</p>
                            <span class="text-gray-400">2 kg</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-500 pb-2 mb-2">
                            <p class="text-white">Broccoli</p>
                            <span class="text-gray-400">1 kg</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-500 pb-2 mb-2">
                            <p class="text-white">Spinach</p>
                            <span class="text-gray-400">500 g</span>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="space-y-2 mt-4">
            <li class="list-item">
                <div class="bg-red-700 rounded-t p-4 transition-all duration-300 ease-in-out">
                    <div class="flex justify-between items-center">
                        <a href="#" class="flex-grow" onclick="toggleProducts(event)">
                            <strong class="font-medium text-white text-lg">Fruit</strong>
                        </a>
                    </div>
                </div>
                <div class="products rounded-b bg-red-600 p-2 overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 0; opacity: 0;">
                    <div class="space-y-1 mt-1">
                        <div class="flex justify-between border-b border-gray-500 pb-2 mb-2">
                            <p class="text-white">Apples</p>
                            <span class="text-gray-400">2 kg</span>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </article>
</x-app-layout>

<script>
    function toggleProducts(event) {
        event.preventDefault(); // Prevent the default anchor behavior
        const productsDiv = event.target.closest('li').querySelector('.products');

        if (productsDiv) {
            const isVisible = productsDiv.style.maxHeight !== '0px';
            
            // If it's currently visible, hide it
            if (isVisible) {
                productsDiv.style.maxHeight = '0'; // Start collapsing
                productsDiv.style.opacity = '0'; // Fade out
            } else {
                productsDiv.style.maxHeight = `${productsDiv.scrollHeight}px`; // Expand to full height
                productsDiv.style.opacity = '1'; // Fade in
            }
        }
    }
</script>

<style>
    .products {
        transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out; /* Smooth transition for height and opacity */
    }
</style>



