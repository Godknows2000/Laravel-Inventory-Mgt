<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Student;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use DB;
use PDF;
use Collection;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\SpladeTable;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
        $query->where(function ($query) use ($value) {
            Collection::wrap($value)->each(function ($value) use ($query) {
                $query->orWhere('orders.id', 'LIKE', "%$value%");
                $query->orWhere('products.name', 'LIKE', "%$value%");
                $query->orWhere('students.name', 'LIKE', "%$value%");
            });
        });
    });

    $orders = QueryBuilder::for(Order::class)
        ->allowedFilters(['id', 'product', 'student', 'quantity', 'created_at', $globalSearch])
        ->allowedSorts(['id', 'name', 'price', 'quantity', 'created_at'])
        ->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id')
        ->leftJoin('products', 'order_product.product_id', '=', 'products.id')
        ->leftJoin('students', 'orders.student_id', '=', 'students.id')
        ->select('orders.*', 'products.name as product', 'students.name as customer', 'order_product.quantity', 'order_product.price')
        ->paginate()
        ->withQueryString();

    return view('orders.index', [
        'orders' => SpladeTable::for($orders)
            ->withGlobalSearch()
            ->column('id', sortable: true, searchable: true)
            ->column(
                'product',
                canBeHidden: false,
                sortable: true,
                searchable: true
            )
            ->column(
                'customer',
                canBeHidden: false,
                sortable: true,
                searchable: true
            )
            ->column(
                'quantity',
                canBeHidden: false,
                sortable: true,
                searchable: true
            )
            ->column(
                'price',
                canBeHidden: false,
                sortable: true,
                searchable: true
            )
            ->column(
                'total_price',
                canBeHidden: false,
                sortable: true,
                searchable: true
            )
            ->column('created_at', sortable: true, searchable: true)
            ->column('action'),
    ]);
}

    
    public function downloadDailySales()
    {
        $today = Carbon::today();
        $orders = Order::whereDate('created_at', $today)->get();

        $pdf = PDF::loadView('pdf.daily-sales', compact('orders'));

        return $pdf->download('daily-sales-' . $today->format('Y-m-d') . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $students = Student::all();
        return view('orders.create', compact('branches', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();
    
        // Begin a database transaction
        DB::beginTransaction();
    
        try {
            // Create the order
            $order = Order::create([
                'branch_id' => $validated['branch_id'],
                'student_id' => $validated['student_id'],
                'total' => $this->calculateTotal($validated['products'], $validated['quantities']),
                'status' => 'completed', // Assuming a default status
            ]);
    
            $products = [];
            foreach ($validated['products'] as $index => $productId) {
                $quantity = $validated['quantities'][$index];
                $price = $this->getProductPrice($productId);
    
                // Update product quantity
                $product = Product::findOrFail($productId);
                if ($product->quantity < $quantity) {
                    // Rollback transaction if there's not enough stock
                    DB::rollBack();
                    return redirect()->back()->withErrors(['error' => 'Not enough stock for product: ' . $product->name]);
                }
    
                // Subtract the ordered quantity from the available stock
                $product->quantity -= $quantity;
                $product->save();
    
                $products[$productId] = ['quantity' => $quantity, 'price' => $price];
            }
    
            // Attach products to the order
            $order->products()->attach($products);
    
            // Commit the transaction
            DB::commit();
    
            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of any error
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'An error occurred while creating the order.']);
        }
    }    

    private function calculateTotal(array $productIds, array $quantities)
    {
        $total = 0;
        foreach ($productIds as $index => $productId) {
            $total += $this->getProductPrice($productId) * $quantities[$index];
        }
        return $total;
    }

    private function getProductPrice($productId)
    {
        $product = Product::findOrFail($productId);
        return $product->price;
    }

    /**
     * API endpoint to get products based on branch
     */
    public function getProductsByBranch(Request $request)
    {
        $branchId = $request->query('branch_id');
        $products = Product::where('branch_id', $branchId)->get();
        return response()->json($products);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);

        // Update the order
        $order->update($validatedData);

        return response()->json($order, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
