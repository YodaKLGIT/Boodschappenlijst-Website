<x-app-layout>
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
            <div class="p-6 space-y-2" style="min-height: 300px;">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Create Shopping List</h2>

                @if ($errors->any())
                    <div class="mb-2 p-4 text-red-600 bg-red-100 border border-red-300 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('shoppinglist.store') }}" method="POST" class="space-y-2">
                    @csrf

                    {{-- Title Input --}}
                    <div class="mb-3">
                        <label for="name" class="block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            required>
                    </div>

                    {{-- Products Dropdown --}}
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Products</label>
                        <details class="relative border border-gray-300 bg-gray-50 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                            <summary class="flex items-center justify-between cursor-pointer p-2">
                                Select Products
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </summary>
                            <div class="bg-white dark:bg-gray-700 max-h-40 overflow-y-auto rounded-lg shadow w-full">
                                <ul class="text-sm text-gray-700 dark:text-gray-200">
                                
                                    @foreach ($groupedProducts as $category => $products)
                                        <li class="font-bold text-gray-900 dark:text-white p-2 border-b border-gray-200 dark:border-gray-600">
                                            {{ $category }}
                                        </li>
                                        @foreach ($products as $product)
                                            <li class="flex items-center p-2 hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200">
                                                <input id="product-{{ $product->id }}" type="checkbox" name="product_ids[]" value="{{ $product->id }}" 
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded dark:bg-gray-600 dark:border-gray-500" 
                                                    {{ in_array($product->id, old('product_ids', [])) ? 'checked' : '' }}>
                                                <label for="product-{{ $product->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                    {{ $product->brand->name }} - {{ $product->name }}
                                                </label>
                                                <input type="number" name="quantities[{{ $product->id }}]" min="0" placeholder="Optional" class="ml-1 w-12 text-gray-900 dark:text-gray-300" 
                                                    value="{{ old('quantities.' . $product->id) }}">
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </details>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-between mt-4">
                        <a href="{{ route('shoppinglist.index') }}" 
                            class="flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow transition">
                            Go Back
                        </a>
                        <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                            Create Shopping List
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>








