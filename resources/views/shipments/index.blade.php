<x-layout>
    <div class="max-w-5xl mx-auto p-3 mt-22">
        <div class="flex space-x-5 mt-5">
            <a href="{{ route('shipments.index') }}">
                <button class="hover:bg-gray-200 hover:text-black transition w-28 bg-gray-800 rounded h-8 px-2 text-white">
                    All
                </button>
            </a>
            <a href="{{ route('shipments.create') }}">
                <button class="hover:bg-gray-200 hover:text-black transition w-40 bg-gray-800 rounded h-8 px-2 text-white">
                    Create Shipment
                </button>
            </a>
        </div>
        <x-splade-table :for="$shipments" class="mt-5" striped>
            @cell('action', $shipment)
                <div class="flex space-x-2">
                    <Link href="{{ route('shipments.edit', $shipment->id) }}"
                        class="font-semibold text-white hover:text-white hover:bg-blue-500 bg-blue-500 py-1 px-1 rounded w-11">
                    Edit
                    </Link>
                    <form action="{{ route('shipments.destroy', $shipment->id) }}" method="POST"
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
