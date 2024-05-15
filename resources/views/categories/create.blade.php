<x-layout>
    <x-splade-form :action="route('categories.store')" class="justify-center w-full px-5 py-5 mx-auto mt-16 space-y-4 bg-white md:w-4/12">
        <x-splade-input name="name" label="Name" />
        <x-splade-input name="description" label="Description" />
        <x-splade-button type="submit">Create</x-splade-button>
    </x-splade-form>
</x-layout>