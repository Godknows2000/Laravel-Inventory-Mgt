<x-layout>
    <div class="flex justify-center">
        <div class="w-full md:w-2/3 lg:w-1/2 xl:w-1/3">
            <x-splade-form :action="route('roles.store')" class="mt-16 space-y-4 px-5 py-5 bg-white">
                <h1 class="text-xl font-semibold text-center">Create Role</h1>
                <x-splade-input type="text" name="name" label="Role Name" class="w-full" />
                <x-splade-select name="permissions[]" label="Select Permissions" placeholder="Select Permissions" multiple choices
                    realation>
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->name }}">
                            {{ $permission->name }}
                        </option>
                    @endforeach
                </x-splade-select>
                <x-splade-submit
                    class="mt-5 hover:bg-gray-200 hover:text-black transition w-full md:w-28 bg-gray-800
                     h-10 px-2 text-white font-semibold rounded font-sans"
                    :spinner="true" />
            </x-splade-form>
        </div>
    </div>
</x-layout>
