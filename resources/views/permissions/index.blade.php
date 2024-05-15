<x-layout>
    <div class="max-w-7xl max-auto p-8 mx-auto justify-center mb-5">
        <div class="flex space-x-2">
            <a href="{{ route('permissions.index') }}">
                <button
                    class="hover:bg-gray-200 hover:text-black transition w-40 bg-gray-800 rounded h-8 px-2 text-white">
                    All Permissions
                </button>
            </a>
            <a href="{{ route('permissions.create') }}">
                <button
                    class="hover:bg-gray-200 hover:text-black transition w-40 bg-gray-800 rounded h-8 px-2 text-white">
                    Create Permission
                </button>
            </a>
        </div>
        <x-splade-table :for="$permissions" class="mt-5" striped>
            @cell('action', $permission)
                <div class="flex space-x-2">
                    <Link href="{{ route('permissions.edit', $permission->id) }}"
                        class="font-semibold text-white hover:text-white hover:bg-blue-500 bg-blue-500 py-1 px-1 rounded w-11">
                    Edit
                    </Link>
                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this permission?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="font-semibold text-white hover:text-white hover:bg-gray-900 bg-red-500 py-1 px-1 rounded">
                            Delete
                        </button>
                    </form>
                </div>
            @endcell
        </x-splade-table>
    </div>
</x-layout>
