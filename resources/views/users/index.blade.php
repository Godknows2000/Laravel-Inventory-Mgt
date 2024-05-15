<x-layout>
    <div class="max-w-7xl max-auto p-8 mx-auto justify-center mb-5">
        <div class="flex space-x-2">
            <a href="{{ route('users.index') }}">
                <button
                    class="hover:bg-gray-200 hover:text-black transition w-28 bg-gray-800 rounded h-8 px-2 text-white">
                    All Users
                </button>
            </a>
            <a href="{{ route('users.create') }}">
                <button
                    class="hover:bg-gray-200 hover:text-black transition w-28 bg-gray-800 rounded h-8 px-2 text-white">
                    Create User
                </button>
            </a>
        </div>
        <x-splade-table :for="$users" class="mt-5" striped>

            @cell('role', $user)
            @foreach ($user->roles as $role)
                <span class="text-white bg-blue-500 rounded px-2 mr-1">
                        {{ $role->name }}
                    </span>
            @endforeach
            @endcell

            @cell('action', $user)
            <div class="flex space-x-4">
                <Link href="{{ route('users.edit', $user->id) }}"
                      class="font-semibold text-white hover:text-white hover:bg-blue-800 bg-blue-500 py-1 px-1 rounded w-11">
                    Edit
                </Link>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this user?')">
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
