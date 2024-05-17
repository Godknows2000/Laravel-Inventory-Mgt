<x-layout>
    <div class="px-16 mt-6 to-black1 flex justify-between  space-x-5">
        @php
            $totalBranches = \App\Models\Branch::count();
        @endphp
        <div class="bg-blue1 w-3/12 rounded py-3 hover:bg-black1 transition">
            <p class="text-white text-center">
                Total Branches
            </p>
            <h1 class="text-white text-center text-2xl font-semi">
                {{ $totalBranches }}
            </h1>
        </div>

        @php
            $totalOrders = \App\Models\Order::count();
        @endphp
        <div class="bg-blue1 w-3/12 rounded py-3 hover:bg-black1 transition">
            <p class="text-white text-center">
                Total Orders
            </p>
            <h1 class="text-white text-center text-2xl font-semi">
                {{ $totalOrders }}
            </h1>
        </div>

        @php
            $totalCategories = \App\Models\Category::count();
        @endphp
        <div class="bg-blue1 w-3/12 rounded py-3 hover:bg-black1 transition">
            <p class="text-white text-center">
                Total Categories
            </p>
            <h1 class="text-white text-center text-2xl font-semi">
                {{ $totalOrders }}
            </h1>
        </div>

        @php
            $totalProducts = \App\Models\Product::count();
        @endphp
        <div class="bg-blue1 w-3/12 rounded py-3 hover:bg-black1 transition">
            <p class="text-white text-center">
                Total Products
            </p>
            <h1 class="text-white text-center text-2xl font-semi">
                {{ $totalProducts }}
            </h1>
        </div>
    </div>

    <div
        class="flex flex-col items-center w-11/12 p-6 pb-6 bg-white rounded-lg shadow-xl justify-center mx-auto mt-10 px-20 border">
        <h2 class="text-xl font-bold">Monthly Products</h2>
        <span class="text-sm font-semibold text-gray-500">2024</span>
        <div class="flex items-end flex-grow w-full mt-2 space-x-2 sm:space-x-3">
            @foreach ($products as $product)
                <div class="relative flex flex-col items-center flex-grow pb-5 group">
                         <span class="absolute top-0 hidden -mt-6 text-xs font-bold group-hover:block">
                             {{ $product->count() }}
                         </span>
                    <div class="relative flex justify-center w-full h-8">
                        <div class="h-full bg-indigo-200">{{ $product->name }}</div>
                        <div class="h-full bg-transparent border border-indigo-400">{{ $product->id }}</div>
                    </div>
                    <span class="absolute bottom-0 text-xs font-bold">{{ $product->created_at }}</span>
                </div>
            @endforeach
        </div>
        <div class="flex w-full mt-3">
            <div class="flex items-center ml-auto">
                <span class="block w-4 h-4 bg-indigo-400"></span>
                <span class="ml-1 text-xs font-medium">All</span>
            </div>
        </div>
    </div>

</x-layout>
