<x-app-layout>
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Create Shopping List</h2>

                @if ($errors->any())
                    <div class="mb-4 p-4 text-red-600 bg-red-100 border border-red-300 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('shoppinglist.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Title Input --}}
                    <div class="mb-4">
                        <label for="name" class="block text-lg font-semibold text-gray-900 dark:text-white">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            required>
                    </div>

                    {{-- Product Selection --}}
                    <div class="mb-4">
                        <label class="block text-lg font-semibold text-gray-900 dark:text-white">Select Products</label>
                        <div class="mt-2 max-h-48 overflow-y-auto bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                            @if($products->isEmpty())
                                <div class="p-4 text-gray-500 text-sm text-center dark:text-gray-400">
                                    No products available. Please check back later.
                                </div>
                            @else
                                <ul class="space-y-2 p-2">
                                
                                    @foreach($products as $product)
                                        <li class="flex items-center justify-between p-3 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                            <div class="flex items-center">
                                                <input id="checkbox-item-{{ $product->id }}" type="checkbox" name="product_ids[]" value="{{ $product->id }}" 
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:bg-gray-600 dark:border-gray-500" 
                                                    {{ in_array($product->id, old('product_ids', [])) ? 'checked' : '' }}>
                                                <label for="checkbox-item-{{ $product->id }}" 
                                                    class="ml-2 text-lg font-medium text-gray-900 dark:text-gray-300">{{ $product->name }}</label>
                                            </div>
                                            <input type="number" name="quantities[{{ $product->id }}]" min="1" value="{{ old('quantities.' . $product->id, 1) }}" 
                                                class="mt-1 w-16 border border-gray-300 rounded-md p-1 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                                placeholder="Qty" {{ in_array($product->id, old('product_ids', [])) ? '' : 'disabled' }}>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                   

                    {{-- Buttons --}}
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('shoppinglist.index') }}" 
                            class="flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow transition">
                            <svg fill="#000000" height="24px" width="24px" viewBox="0 0 26.676 26.676" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                                <path d="M26.105,21.891c-0.229,0-0.439-0.131-0.529-0.346l0,0c-0.066-0.156-1.716-3.857-7.885-4.59c-1.285-0.156-2.824-0.236-4.693-0.25v4.613c0,0.213-0.115,0.406-0.304,0.508c-0.188,0.098-0.413,0.084-0.588-0.033L0.254,13.815C0.094,13.708,0,13.528,0,13.339c0-0.191,0.094-0.365,0.254-0.477l11.857-7.979c0.175-0.121,0.398-0.129,0.588-0.029c0.19,0.102,0.303,0.295,0.303,0.502v4.293c2.578,0.336,13.674,2.33,13.674,11.674c0,0.271-0.191,0.508-0.459,0.562C26.18,21.891,26.141,21.891,26.105,21.891z"/>
                            </svg>
                            <span class="ml-2">Go Back</span>
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




