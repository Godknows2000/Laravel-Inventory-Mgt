<x-layout>
    <div class="max-w-5xl p-3 mx-auto mt-22">
        <div class="flex space-x-5 mt-5">
            <a href="{{ route('students.index') }}">
                <button class="hover:bg-gray-200 hover:text-black transition w-28 bg-gray-800 rounded h-8 px-2 text-white">
                    All
                </button>
            </a>
            <a href="{{ route('students.create') }}">
                <button class="hover:bg-gray-200 hover:text-black transition w-28 bg-gray-800 rounded h-8 px-2 text-white">
                    Create
                </button>
            </a>
        </div>
        <x-splade-table :for="$students" class="mt-5" striped>
            @cell('action', $student)
                <div class="flex space-x-2">
                    <Link href="{{ route('students.edit', $student->id) }}"
                        class="font-semibold text-white hover:text-white hover:bg-blue-500 bg-blue-500 py-1 px-1 rounded w-11">
                    Edit
                    </Link>
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST"
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
