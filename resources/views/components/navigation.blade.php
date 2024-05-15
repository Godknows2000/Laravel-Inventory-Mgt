<x-splade-data default="{ open: false, sidebarOpen: true }">
    <!-- Main content area -->
    <main class="flex-1 bg-gray-100">
    <nav class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <img class="mx-auto h-12 w-12 rounded-full" src="{{asset('images/logo.png')}}" alt="Workflow">
                        <x-nav-link class="text-black text-3xl uppercase" href="{{ route('suppliers.index') }}" :active="request()->routeIs('suppliers')">
                            {{ __('Inventory Stock Management') }}
                        </x-nav-link>
                    </div>

                    <!-- Navigation Links -->
                    <!-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link class="text-white" href="{{ route('suppliers.index') }}" :active="request()->routeIs('suppliers')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link class="text-white" href="{{ route('products.index') }}" :active="request()->routeIs('suppliers')">
                            {{ __('Products') }}
                        </x-nav-link>

                        <x-nav-link class="text-white" href="{{ route('suppliers.index') }}" :active="request()->routeIs('suppliers')">
                            {{ __('Branches') }}
                        </x-nav-link>

                        <x-nav-link class="text-white" href="{{ route('suppliers.index') }}" :active="request()->routeIs('suppliers')">
                            {{ __('Orders') }}
                        </x-nav-link>

                        <x-nav-link class="text-white" href="{{ route('suppliers.index') }}" :active="request()->routeIs('suppliers')">
                            {{ __('Stock') }}
                        </x-nav-link>

                        <x-nav-link class="text-white" href="{{ route('suppliers.index') }}" :active="request()->routeIs('suppliers')">
                            {{ __('Suppliers') }}
                        </x-nav-link>

                        <x-nav-link class="text-white" href="{{ route('categories.index') }}" :active="request()->routeIs('categories')">
                            {{ __('Category') }}
                        </x-nav-link>

                        <x-nav-link class="text-white" href="{{ route('roles.index') }}" :active="request()->routeIs('suppliers')">
                            {{ __('Roles') }}
                        </x-nav-link>

                        <x-nav-link class="text-white" href="{{ route('permissions.index') }}" :active="request()->routeIs('suppliers')">
                            {{ __('Permissions') }}
                        </x-nav-link>

                        <x-nav-link class="text-white" href="{{ route('users.index') }}" :active="request()->routeIs('suppliers')">
                            {{ __('Users') }}
                        </x-nav-link>
                    </div> -->
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div class="mt-4 text-red">
                        <x-dropdown-link as="a" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </div>
                </form>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="data.open = ! data.open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path v-bind:class="{'hidden': data.open, 'inline-flex': ! data.open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-bind:class="{'hidden': ! data.open, 'inline-flex': data.open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div v-bind:class="{'block': data.open, 'hidden': ! data.open }" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>

               
            </div>
        </div>
    </nav>
    </main>
</x-splade-data>
