<x-layout>
    <x-splade-form :action="route('products.store')" class="justify-center w-full px-5 py-5 mx-auto mt-16 space-y-4 bg-white md:w-6/12">
        <h1 class="text-xl font-semibold text-center">Create Product</h1>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-splade-input type="text" name="name" label="Name" class="w-full" />
        <!-- Category Dropdown -->
        <x-splade-select name="branch_id" label="Branch" class="w-full">
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
            @endforeach
        </x-splade-select>
        <!-- Category Dropdown -->
        <x-splade-select name="category_id" label="Category" class="w-full">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </x-splade-select>
        <x-splade-input type="text" name="quantity" label="Qty" class="w-full" />
        <x-splade-input type="text" name="price" label="Price" class="w-full" />
        <x-splade-input type="text" name="size" label="Size" class="w-full" />
        <x-splade-input type="text" name="type" label="Type" class="w-full" />
        <x-splade-input type="text" name="description" label="Description" class="w-full" /> <!-- Corrected the name attribute -->
        <x-splade-submit
            class="w-full h-10 px-2 mt-5 font-sans font-semibold text-white transition bg-gray-800 rounded hover:bg-gray-200 hover:text-black md:w-28"
            :spinner="true" />
    </x-splade-form>
</x-layout>
