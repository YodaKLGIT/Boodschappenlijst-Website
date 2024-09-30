<x-app-layout>
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-6 text-gray-900 dark:text-white">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('shoppinglist.store') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Title Input --}}
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-900 dark:text-white">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    </div>

                    {{-- Description Textarea --}}
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea id="description" name="description" cols="30" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 resize-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>{{ old('description') }}</textarea>
                    </div>

                    

                    {{-- Tag Select --}}
                    <div class="mb-4">
                        <label for="products_ids" class="block text-sm font-medium text-gray-900 dark:text-white">Tags (optional)</label>
                        <div id="productList" class="z-10 bg-white rounded-lg shadow w-full dark:bg-gray-700">
                            <ul class="max-h-24 overflow-y-auto text-sm text-gray-700 dark:text-gray-200 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                @foreach($products as $product)
                                    <li>
                                        <div class="flex items-center pl-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input id="checkbox-item-{{ $product->id }}" type="checkbox" name="tag_ids[]" value="{{ $product->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" {{ in_array($tag->id, old('product_ids', [])) ? 'checked' : '' }}>
                                            <label for="checkbox-item-{{ $product->id }}" class="w-full py-2 ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{ $product->title }}</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                   

                    {{-- Buttons --}}
                    <div class="flex justify-center mt-6">
                        <button type="button" onclick="window.history.back();" class="flex items-center justify-center bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mr-4">
                            <svg fill="#000000" height="24px" width="24px" viewBox="0 0 26.676 26.676" xmlns="http://www.w3.org/2000/svg">
                                <path d="M26.105,21.891c-0.229,0-0.439-0.131-0.529-0.346l0,0c-0.066-0.156-1.716-3.857-7.885-4.59c-1.285-0.156-2.824-0.236-4.693-0.25v4.613c0,0.213-0.115,0.406-0.304,0.508c-0.188,0.098-0.413,0.084-0.588-0.033L0.254,13.815C0.094,13.708,0,13.528,0,13.339c0-0.191,0.094-0.365,0.254-0.477l11.857-7.979c0.175-0.121,0.398-0.129,0.588-0.029c0.19,0.102,0.303,0.295,0.303,0.502v4.293c2.578,0.336,13.674,2.33,13.674,11.674c0,0.271-0.191,0.508-0.459,0.562C26.18,21.891,26.141,21.891,26.105,21.891z"/>
                            </svg>
                            <span class="ml-2">Go Back</span>
                        </button>
                        <button type="submit" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                            Create news
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>