<x-app-layout>
    <head>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    </head>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container max-w-screen-lg mx-auto bg-blue-800 rounded-xl p-8 flex items-center">
            <!-- Left Content -->
            <div class="hero-content mr-auto">
                <h1 class="text-4xl font-extrabold mb-4 text-white">Make healthy life with fresh groceries</h1>
                <p class="text-lg font-light text-white mb-4">Easily make your grocery list from home and enjoy our healthy selection of products.</p>
                <a href="#" class="btn-primary inline-flex items-center px-6 py-3 mr-3 text-white bg-blue-600 hover:bg-blue-500 rounded-lg">View lists</a>
                <a href="#" class="btn-secondary inline-flex items-center px-6 py-3 text-white border border-gray-300 hover:bg-gray-700 rounded-lg">View products</a>
            </div>

            <!-- Right Image -->
            <div class="hidden lg:block hero-image">
                <img src="{{ asset('images/grocerystock.png') }}" alt="Fresh grocery delivery" class="rounded-xl">
            </div>
        </div>
    </section>

<!-- Categories Section -->
<section class="categories-section mb-16"> <!-- Added margin-bottom -->
    <div class="max-w-screen-lg mx-auto">
        <h2 class="text-3xl font-extrabold text-center mb-12">Top Categories</h2>
        <div class="flex justify-between gap-8">
            <!-- Category 1 -->
            <div class="category-item bg-white rounded-lg p-6 text-center shadow-lg hover:shadow-xl transition w-1/4">
                <img src="{{ asset('images/all.png') }}" alt="Browse All" class="mx-auto mb-4 h-16">
                <h3 class="text-xl text-gray-900 font-semibold mb-2">Browse All</h3>
                <p class="text-gray-400">240 items</p>
            </div>
            
            <!-- Category 2 -->
            <div class="category-item bg-white rounded-lg p-6 text-center shadow-lg hover:shadow-xl transition w-1/4">
                <img src="{{ asset('images/veg.png') }}" alt="Vegetables" class="mx-auto mb-4 h-16">
                <h3 class="text-xl text-gray-900 font-semibold mb-2">Vegetables</h3>
                <p class="text-gray-400">140 items</p>
            </div>

            <!-- Category 3 -->
            <div class="category-item bg-white rounded-lg p-6 text-center shadow-lg hover:shadow-xl transition w-1/4">
                <img src="{{ asset('images/meat.png') }}" alt="Meat" class="mx-auto mb-4 h-16">
                <h3 class="text-xl text-gray-900 font-semibold mb-2">Meat</h3>
                <p class="text-gray-400">25 items</p>
            </div>

            <!-- Category 4 -->
            <div class="category-item bg-white rounded-lg p-6 text-center shadow-lg hover:shadow-xl transition w-1/4">
                <img src="{{ asset('images/fruit.png') }}" alt="Fruits" class="mx-auto mb-4 h-16">
                <h3 class="text-xl text-gray-900 font-semibold mb-2">Fruits</h3>
                <p class="text-gray-400">55 items</p>
            </div>
        </div>
    </div>
</section>



<footer class="">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="#" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="images/icon2.png" class="h-8 rounded-xl" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text">ShopMate</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">About</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="#" class="hover:underline">ShopMate</a>. All Rights Reserved.</span>
    </div>
</footer>

</x-app-layout>
