<x-app-layout>
    <h3 class="text-2xl font-medium text-yellow mb-4 text-center">Shopping Lists</h3>

    @if($shoppinglists->isEmpty())
        <div class="max-w-xl mx-auto mt-4">
            <!-- Notification for no shopping lists -->
            <div role="alert" id="notification" class="rounded-xl bg-white p-4 dark:bg-gray-900">
                <div class="flex items-start gap-4">
                    <span class="text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <strong class="block font-medium text-gray-900 dark:text-white">No shopping lists available</strong>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-200">
                            You haven't created any shopping lists yet. Click below to create one!
                        </p>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('shoppinglist.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                                <span class="text-sm">Create a new list</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <button onclick="dismissNotification()" class="text-gray-500 transition hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-500">
                        <span class="sr-only">Dismiss popup</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @else
        <!-- Expandable product categories when shopping lists exist -->
        <article class="rounded-xl border border-gray-700 bg-gray-800 p-6 max-w-xl mx-auto mt-4">
            <ul class="space-y-2 mt-4">
                @foreach ($shoppinglists as $shoppinglist)
                    <li class="list-item">
                        <div class="bg-gray-700 rounded-t p-4 transition-all duration-300 ease-in-out">
                            <div class="flex justify-between items-center">
                                <a href="#" class="flex-grow" onclick="toggleProducts(event)">
                                    <strong class="font-medium text-white text-lg">{{ $shoppinglist->name }}</strong>
                                </a>
                            </div>
                        </div>
                        <div class="products rounded-b bg-gray-600 p-2 overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 0; opacity: 0;">
                            <div class="space-y-1 mt-1">
                                @foreach ($shoppinglist->products as $product)
                                    <div class="flex justify-between border-b border-gray-500 pb-2 mb-2">
                                        <p class="text-white">{{ $product->name }}</p>
                                        <span class="text-gray-400">{{ $product->pivot->quantity }} {{ $product->unit }}</span> <!-- Assuming you have a unit field in your Product model -->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </article>
    @endif
</x-app-layout>





