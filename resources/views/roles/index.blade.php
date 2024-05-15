<x-layout>
    <div class="max-w-7xl max-auto p-8 mx-auto justify-center mb-5">
        <div class="flex space-x-2">
            <a href="{{ route('roles.index') }}">
                <button
                    class="hover:bg-gray-200 hover:text-black transition w-28 bg-gray-800 rounded h-8 px-2 text-white">
                    All Roles
                </button>
            </a>
            <a href="{{ route('roles.create') }}">
                <button
                    class="hover:bg-gray-200 hover:text-black transition w-28 bg-gray-800 rounded h-8 px-2 text-white">
                    Create Role
                </button>
            </a>
        </div>
        <x-splade-table :for="$roles" class="mt-5" striped>
            @cell('action', $role)
                <div class="flex space-x-2">
                    <Link href="{{ route('roles.edit', $role->id) }}"
                        class="font-semibold text-white hover:text-white hover:bg-blue-500 bg-blue-500 py-1 px-1 rounded w-11">
                    Edit
                    </Link>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this role?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="font-semibold text-white hover:text-white hover:bg-gray-900 bg-red-500 py-1 px-1 rounded">
                            Delete
                        </button>
                    </form>
                </div>
            @endcell
            @cell('permission', $role)
                @foreach ($role->permissions as $permission)
                    <span class="text-white bg-blue-500 rounded px-2 mr-1">
                        {{ $permission->name }}
                    </span>
                @endforeach
            @endcell
        </x-splade-table>
    </div>
</x-layout>
