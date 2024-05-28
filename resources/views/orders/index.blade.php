<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<x-layout>
    <div class="max-w-5xl mx-auto p-3 mt-22">
        <div class="flex justify-between mt-5">
            <div class="flex space-x-5">
                <a href="{{ route('orders.index') }}">
                    <button class="hover:bg-gray-200 hover:text-black transition w-28 bg-gray-800 rounded h-8 px-2 text-white">
                        All
                    </button>
                </a>
                <a href="{{ route('orders.create') }}">
                    <button class="hover:bg-gray-200 hover:text-black transition w-28 bg-gray-800 rounded h-8 px-2 text-white">
                        Create Order
                    </button>
                </a>
            </div>
            <div class="flex space-x-5">
                <a href="{{ route('products.viewMonthly') }}">
                    <button class="bg-green-500 hover:bg-green-700 transition text-right w-50 bg-gray-800 rounded h-8 px-2 text-white">
                       <i class="fas fa-download mr-2"></i> Download Daily Orders
                    </button>
                </a>
            </div>
        </div>
        <x-splade-table :for="$orders" class="mt-5" striped>
            @cell('action', $order)
                <div class="flex space-x-2">
                    <Link href="{{ route('orders.edit', $order->id) }}"
                        class="font-semibold text-white hover:text-white hover:bg-blue-500 bg-blue-500 py-1 px-1 rounded w-11">
                    Edit
                    </Link>
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
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
