<x-layout>
<div class="max-w-5xl mx-auto p-3 mt-22 md:w-8/12">
    <div class="card bg-white shadow-md rounded-lg">
        <div class="card-body p-6">
        <h1 class="text-xl font-semibold text-center">Create Supplier</h1>
            <x-splade-form :action="route('suppliers.store')" class="justify-center w-full px-5 py-5 mx-auto space-y-4 bg-white md:w-4/12">
                <x-splade-input name="name" label="Name" />
                <x-splade-input name="email" label="Email" />
                <x-splade-input name="phone" label="Phone" />
                <x-splade-input name="address" label="Address" />
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create</button>
                </div>
            </x-splade-form>
        </div>
    </div>
</div>
</x-layout>