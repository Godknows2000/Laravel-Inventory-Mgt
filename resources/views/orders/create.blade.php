<x-layout>
    <div class="max-w-5xl mx-auto p-8 mt-10 md:w-6/12">
        <div class="card bg-white shadow-md rounded-lg">
            <div class="card-body p-6">
                <h2 class="text-xl font-semibold mb-5">Create New Order</h2>
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Select Products:</label>
                        @foreach ($products as $product)
                            <div class="flex items-center mb-2">
                                <input type="checkbox" name="products[]" id="product_{{ $product->id }}" value="{{ $product->id }}" class="mr-2">
                                <label for="product_{{ $product->id }}">{{ $product->name }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <label for="student" class="block text-gray-700 font-bold mb-2">Select Customer:</label>
                        <select name="student_id" id="student" class="border border-gray-300 rounded px-3 py-2 w-full">
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Quantities for each product:</label>
                        @foreach ($products as $product)
                            <div class="flex items-center mb-2">
                                <label for="quantity_{{ $product->id }}" class="mr-2">{{ $product->name }}:</label>
                                <div class="flex">
                                    <button type="button" class="bg-gray-200 text-gray-700 px-3 py-1 rounded-l" onclick="decrementQuantity('quantity_{{ $product->id }}')">-</button>
                                    <input type="number" name="quantities[{{ $product->id }}]" id="quantity_{{ $product->id }}" class="border border-gray-300 rounded px-3 py-2 w-16 text-center" min="1" value="1">
                                    <button type="button" class="bg-gray-200 text-gray-700 px-3 py-1 rounded-r" onclick="incrementQuantity('quantity_{{ $product->id }}')">+</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> <!-- Close card-body -->
                
                <div class="card-footer bg-gray-100 text-right py-2 p-2">
                    <button type="submit" onclick="console.log('Button clicked!')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Order
                    </button>
                </div>
            </form> <!-- Close form -->
        </div>
    </div>

    <script>
        function incrementQuantity(inputId) {
            var input = document.getElementById(inputId);
            input.stepUp();
        }

        function decrementQuantity(inputId) {
            var input = document.getElementById(inputId);
            input.stepDown();
        }
    </script>
</x-layout>
