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
                <a href="/lists" class="btn-primary inline-flex items-center px-6 py-3 mr-3 text-white bg-blue-600 hover:bg-blue-500 rounded-lg">View lists</a>
                <a href="/products" class="btn-secondary inline-flex items-center px-6 py-3 text-white border border-gray-300 hover:bg-gray-700 rounded-lg">View products</a>
            </div>
            <!-- Right Image -->
            <div class="hidden lg:block hero-image">
                <img src="{{ asset('images/grocerystock.png') }}" alt="Fresh grocery delivery" class="rounded-xl">
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section mb-16">
        <div class="max-w-screen-lg mx-auto">
            <h2 class="text-3xl font-bold mb-8">Categories</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Shop All Option -->
                <a href="{{ route('products.index') }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100">
                    <h3 class="text-xl font-semibold mb-2">Shop All</h3>
                    <p class="text-gray-600">Browse all products</p>
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="block p-6 bg-white rounded-lg shadow hover:bg-gray-100">
                        <h3 class="text-xl font-semibold mb-2">{{ $category->name }}</h3>
                        <p class="text-gray-600">{{ $category->description }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>