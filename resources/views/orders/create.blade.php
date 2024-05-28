<x-layout>
    <div class="max-w-5xl mx-auto p-8 mt-10 md:w-10/12">
        <div class="card bg-white shadow-md rounded-lg">
            <form action="{{ route('orders.store') }}" method="POST" id="order-form">
                    @csrf
                <div class="card-body p-6">
                    <h2 class="text-xl font-semibold mb-5">Create New Order</h2>

                        <div class="mb-4">
                            <label for="branch" class="block text-gray-700 font-bold mb-2">Select Branch:</label>
                            <select name="branch_id" id="branch" class="border border-gray-300 rounded px-3 py-2 w-full" onchange="filterProductsByBranch()">
                                <option value="">-- Select Branch --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="product-rows-container" class="mb-4">
                            <div class="product-row flex items-center mb-2">
                                <select name="products[]" class="border border-gray-300 rounded px-3 py-2 w-1/2" onchange="updateProductDetails(this)">
                                    <option value="">-- Select Product --</option>
                                    <!-- Options will be dynamically populated based on the selected branch -->
                                </select>
                                <input type="hidden" name="product_ids[]" value="">
                                <input type="number" name="quantities[]" class="border border-gray-300 rounded px-3 py-2 w-1/4 mx-2" min="1" value="1" onchange="calculateTotalAmount(this)">
                                <span class="product-price w-1/4">$0.00</span>
                                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2" onclick="removeProductRow(this)">Remove</button>
                            </div>
                        </div>

                        <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4" onclick="addProductRow()"><i class="fa fa-plus mr-2"></i> Add Product</button>

                        <div class="mt-4">
                            <label for="total-amount" class="block text-gray-700 font-bold mb-2">Total Amount:</label>
                            <input type="text" id="total-amount" class="border border-gray-300 rounded px-3 py-2 w-full" readonly>
                        </div>

                        <div class="mt-4">
                            <label for="student" class="block text-gray-700 font-bold mb-2">Select Customer:</label>
                            <select name="student_id" id="student" class="border border-gray-300 rounded px-3 py-2 w-full">
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="card-footer bg-gray-100 text-right py-2 p-2 mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Order
                    </button>
                </div>
            </form> <!-- Close form -->
        </div>
    </div>

    <script>
        let productList = [];

        function filterProductsByBranch() {
            const branchId = document.getElementById('branch').value;

            if (branchId) {
                fetch(`/api/products?branch_id=${branchId}`)
                    .then(response => response.json())
                    .then(products => {
                        productList = products;
                        updateProductDropdowns();
                    });
            } else {
                productList = [];
                updateProductDropdowns();
            }
        }

        function updateProductDropdowns() {
            const productRows = document.querySelectorAll('.product-row select');
            productRows.forEach(select => {
                const selectedValue = select.value;
                select.innerHTML = '<option value="">-- Select Product --</option>';
                productList.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.id;
                    option.textContent = product.name;
                    select.appendChild(option);
                });
                select.value = selectedValue;
            });
        }

        function addProductRow() {
            const container = document.getElementById('product-rows-container');
            const row = document.createElement('div');
            row.className = 'product-row flex items-center mb-2';
            row.innerHTML = `
                <select name="products[]" class="border border-gray-300 rounded px-3 py-2 w-1/2" onchange="updateProductDetails(this)">
                    <option value="">-- Select Product --</option>
                    ${productList.map(product => `<option value="${product.id}">${product.name}</option>`).join('')}
                </select>
                <input type="number" name="quantities[]" class="border border-gray-300 rounded px-3 py-2 w-1/4 mx-2" min="1" value="0" onchange="calculateTotalAmount()">
                <span class="product-price w-1/4">$0.00</span>
                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2" onclick="removeProductRow(this)">Remove</button>
            `;
            container.appendChild(row);
        }

        function removeProductRow(button) {
            const row = button.closest('.product-row');
            row.remove();
            calculateTotalAmount();
        }

        function updateProductDetails(select) {
            const row = select.closest('.product-row');
            const productIdInput = row.querySelector('input[name="product_ids[]"]');
            const quantityInput = row.querySelector('input[name="quantities[]"]');
            const priceSpan = row.querySelector('.product-price');
            const productId = select.value;

            // Set the value of the hidden input field to the selected product's ID
            productIdInput.value = productId;

            const product = productList.find(p => p.id == productId);
            if (product) {
                priceSpan.textContent = `$${(product.price * quantityInput.value).toFixed(2)}`;
            } else {
                priceSpan.textContent = '$0.00';
            }

            calculateTotalAmount();
        }

        function calculateTotalAmount() {
            let totalAmount = 0;
            document.querySelectorAll('.product-row').forEach(row => {
                const select = row.querySelector('select');
                const quantityInput = row.querySelector('input[name="quantities[]"]');
                const product = productList.find(p => p.id == select.value);
                if (product) {
                    totalAmount += product.price * quantityInput.value;
                }
            });
            document.getElementById('total-amount').value = `$${totalAmount.toFixed(2)}`;
        }

        function downloadDailySales() {
            window.location.href = "{{ route('orders.downloadDailySales') }}";
        }
    </script>
</x-layout>
