<x-layout>
    <x-splade-form :action="route('suppliers.store')" class="justify-center w-full px-5 py-5 mx-auto mt-16 space-y-4 bg-white md:w-4/12">
        <x-splade-input name="name" label="Name" />
        <x-splade-input name="email" label="Email" />
        <x-splade-input name="phone" label="Phone" />
        <x-splade-input name="address" label="Address" />
        <x-splade-button type="submit">Create</x-splade-button>
    </x-splade-form>
</x-layout>