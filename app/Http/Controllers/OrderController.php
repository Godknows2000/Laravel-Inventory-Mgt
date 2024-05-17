<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Student;
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
            ->leftJoin('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('students', 'orders.student_id', '=', 'students.id')
            ->select('orders.*', 'products.name as product', 'students.name as customer')
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
                ->column('created_at', sortable: true, searchable: true)
                ->column('action'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $students = Student::all();
        return view('orders.create', compact('products', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'student_id' => 'required|exists:students,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'student_id' => $validatedData['student_id'],
            ]);

            foreach ($validatedData['products'] as $key => $productId) {
                $product = Product::findOrFail($productId);
                $quantity = $validatedData['quantities'][$key];

                // Decrement product quantity
                $product->decrement('quantity', $quantity);

                // Attach product to the order with quantity
                $order->products()->attach($productId, ['quantity' => $quantity]);
            }

            DB::commit();

            // Generate PDF receipt
            $pdf = PDF::loadView('receipt', ['order' => $order]);
            $pdf->save(public_path('receipts/order_'.$order->id.'.pdf'));

            Toast::title('Success')->message('Order created successfully!')->success();
            return redirect()->route('orders.index');

            return response()->json([
                'message' => 'Order created successfully',
                'order_id' => $order->id,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create the order.'], 500);
        }
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
    public function update(UpdateOrderRequest $request, Order $order)
    {
        // Validate the request data
        $validatedData = $request->validated();

        // Check if the order is being marked as completed
        if ($validatedData['status'] === 'completed' && $order->status !== 'completed') {
            // Subtract the quantity from the product
            $product = $order->product;
            $product->quantity -= $order->quantity;
            $product->save();
        }

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
