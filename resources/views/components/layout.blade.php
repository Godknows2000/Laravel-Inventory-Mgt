<!-- <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" /> -->

<div class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <x-navigation />
    <div class="mx-auto my-auto flex flex-row flex-grow">
        <div class="flex flex-col w-56 bg-white overflow-hidden" style="background-color:#0056a7">
            <div class="flex items-center justify-center h-20 shadow-md">
                <h1 class="text-1xl text-white uppercase">Inventory Mgt</h1>
            </div>
            <ul class="flex flex-col py-4">
            <li>
                <a href="/" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-home"></i></span>
                <span class="text-sm text-white font-medium">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('products.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 {{ request()->routeIs('products.index') ? 'text-gray-800 font-semibold bg-black' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-music"></i></span>
                <span class="text-sm text-white font-medium">Products</span>
                </a>
            </li>
            <li>
                <a href="{{ route('order-notes.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 {{ request()->routeIs('order-notes.index') ? 'text-gray-800 font-semibold bg-black' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-drink"></i></span>
                <span class="text-sm text-white font-medium">Order note</span>
                </a>
            </li>
            <li>
                <a href="{{ route('suppliers.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 {{ request()->routeIs('suppliers.index') ? 'text-gray-800 font-semibold bg-black' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-shopping-bag"></i></span>
                <span class="text-sm text-white font-medium">Suppliers</span>
                </a>
            </li>

            <li>
                <a href="{{ route('students.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 {{ request()->routeIs('students.index') ? 'text-gray-800 font-semibold bg-black' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-white"><i class="bx bx-bell"></i></span>
                <span class="text-sm text-white font-medium">Students</span>
                </a>
            </li>
            @role('Admin')

            @endrole
            @role('Manager')

            @endrole
            <li>
                <a href="{{ route('orders.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 {{ request()->routeIs('orders.index') ? 'text-gray-800 font-semibold bg-black' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-chat"></i></span>
                <span class="text-sm text-white font-medium">Orders</span>
                </a>
            </li>
            <li>
                <a href="{{ route('shipments.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 {{ request()->routeIs('shipments.index') ? 'text-gray-800 font-semibold bg-black' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-user"></i></span>
                <span class="text-sm text-white font-medium">Shipments</span>
                </a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 {{ request()->routeIs('categories.index') ? 'text-gray-800 font-semibold bg-black' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-bell"></i></span>
                <span class="text-sm text-white font-medium">Category</span>
                </a>
            </li>
            <li>
                <a href="{{ route('branches.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 {{ request()->routeIs('branches.index') ? 'text-gray-800 font-semibold bg-black' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-log-out"></i></span>
                <span class="text-sm text-white font-medium">Branches</span>
                </a>
            </li>
            <li>
                <a href="{{ route('roles.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 {{ request()->routeIs('roles.index') ? 'text-gray-800 font-semibold bg-black' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-user"></i></span>
                <span class="text-sm text-white font-medium">Roles</span>
                </a>
            </li>
            <li>
                <a href="{{ route('permissions.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 {{ request()->routeIs('permissions.index') ? 'text-gray-800 font-semibold bg-black' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-white"><i class="bx bx-bell"></i></span>
                <span class="text-sm text-white font-medium">Permissions</span>
                </a>
            </li>
            <li>
                <a href="{{ route('users.index') }}" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 {{ request()->routeIs('users.index') ? 'text-gray-800 font-semibold bg-black' : 'text-gray-500 hover:text-gray-800' }}">
                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-log-out"></i></span>
                <span class="text-sm text-white font-medium">Users</span>
                </a>
            </li>
            </ul>
        </div>

        <!-- Page Heading and Content -->
        <div class="flex-grow mx-auto flex-col items-center justify-center">
            <!-- Page Heading -->
            @if(isset($header))
                <header class="bg-white shadow w-full">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>
        </div>
    </div>
</div>
