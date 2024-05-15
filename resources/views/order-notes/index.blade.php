<x-layout>
    <div class="max-w-5xl mx-auto p-3 mt-22">
        <div class="flex space-x-5 mt-5">
            <a href="{{ route('order-notes.index') }}">
                <button class="hover:bg-gray-200 hover:text-black transition w-28 bg-gray-800 rounded h-8 px-2 text-white">
                    All
                </button>
            </a>
            <a href="{{ route('order-notes.create') }}">
                <button class="hover:bg-gray-200 hover:text-black transition w-40 bg-gray-800 rounded h-8 px-2 text-white">
                    Create Order Note
                </button>
            </a>
        </div>
        <x-splade-table :for="$orderNotes" class="mt-5" striped>
            @cell('action', $orderNote)
                <div class="flex space-x-2">
                    <a href="{{ route('order-notes.edit', $orderNote->id) }}"
                        class="font-semibold text-white hover:text-white hover:bg-blue-500 bg-blue-500 py-1 px-1 rounded w-11">
                        Edit
                    </a>
                    <form action="{{ route('order-notes.destroy', $orderNote->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this order note?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="font-semibold text-white hover:text-white hover:bg-gray-900 bg-red-500 py-1 px-1 rounded">
                            Delete
                        </button>
                    </form>
                </div>
            @endcell

            @cell('note', $orderNote)
                {{-- Display each line from the order note textarea on its own line --}}
                {!! nl2br(e($orderNote->note)) !!}
            @endcell

            @cell('status', $orderNote)
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $orderNote->status === 'pending' ? 'bg-yellow-400 text-white' : ($orderNote->status === 'approved' ? 'bg-green-400 text-white' : 'bg-red-400 text-white') }}">
                    {{ ucfirst($orderNote->status) }}
                </span>
            @endcell
        </x-splade-table>
    </div>
</x-layout>
