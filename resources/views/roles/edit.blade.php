<x-layout>
    <x-splade-form :default="$role" :action="route('roles.update', $role)" method="PUT"
        class="w-full md:w-4/12 justify-center mx-auto mt-16 space-y-4 px-5 py-5 bg-white">
        <h1 class="text-xl font-semibold text-center">Edit Role</h1>
        <x-splade-input type="text" name="name" label="Role Name" class="w-full" />

        <x-splade-select name="permissions[]" label="Select Permissions" placeholder="Select Permissions" multiple choices
            relation>
            @foreach ($permissions as $permission)
                <option value="{{ $permission->id }}" @if ($role->permissions->contains($permission)) selected @endif>
                    {{ $permission->name }}
                </option>
            @endforeach
        </x-splade-select>

        <x-splade-submit
            class="mt-5 hover:bg-gray-200 hover:text-black transition w-full md:w-28 bg-gray-800
             h-10 px-2 text-white font-semibold rounded font-sans"
            :spinner="true" />
    </x-splade-form>
</x-layout>
