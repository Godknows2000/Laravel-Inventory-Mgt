<x-layout>
    <x-splade-form :action="route('users.store')" class="justify-center w-full px-5 py-5 mx-auto mt-16 space-y-4 bg-white md:w-4/12">
        <h1 class="text-xl font-semibold text-center">Create User</h1>
        <x-splade-input type="text" name="name" label="Full Name" class="w-full" />
        <x-splade-input name="email" type="text" label="Email" class="w-full" />
        <x-splade-input type="password" name="password" label="Password" class="w-full" />
        <x-splade-input type="password" name="password_confirmation" label="Confirm Password" class="w-full" />
        <x-splade-select name="roles[]" label="Roles" :options="$roles" option-label="name" option-value="name" />
        <x-splade-submit
            class="w-full h-10 px-2 mt-5 font-sans font-semibold text-white transition bg-gray-800 rounded hover:bg-gray-200 hover:text-black md:w-28"
            :spinner="true" />
    </x-splade-form>
</x-layout>
