<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex items-center justify-between p-4 mx-auto">
        <!-- Logo on the left -->
        <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('images/icon2.png') }}" class="h-8" alt="Flowbite Logo"/>
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-darkblue">ShopMate</span>
        </a>

        <!-- Centered navigation links -->
        <div class="flex-grow flex justify-center mr-negative-16">
            <ul class="flex space-x-6 font-medium">
                <li>
                    <a href="/" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="/products" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">Products</a>
                </li>
                <li>
                    <a href="/lists" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">Lists</a>
                </li>
            </ul>
        </div>

        <!-- Search bar on the right -->
        <form action="{{ route('products.index') }}" method="GET" class="relative hidden md:block">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search icon</span>
            </div>
            <input type="text" name="search" id="search-navbar" class="block w-full p-2 pl-10 text-sm text-black border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search..." value="{{ request('search') }}">
        </form>

        <!-- Search button for mobile -->
        <div class="flex md:hidden">
            <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search" aria-expanded="false" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search</span>
            </button>
        </div>

        <!-- User dropdown or login link -->
        <div class="relative flex items-center z-50">
            @if(Auth::check())
                <!-- If user is logged in, show the user dropdown -->
                <button id="user-menu-button" data-dropdown-toggle="user-dropdown" class="flex items-center text-sm text-gray-500 rounded-full md:focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700" type="button" aria-expanded="false" aria-haspopup="true">
                    <img class="w-8 h-8 rounded-full" src="{{ asset('images/user.png') }}">
                    <span class="hidden md:inline-flex ml-2">{{ Auth::user()->name }}</span>
                </button>
                <div class="hidden z-50 my-0 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                        <span class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <!-- If user is not logged in, show the login link -->
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-blue-700 dark:text-gray-200 dark:hover:text-white">Login</a>
            @endif
        </div>
    </div>
</nav>
