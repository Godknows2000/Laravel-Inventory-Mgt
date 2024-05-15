<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Branch;
use App\Models\Supplier;
use App\Models\Product;
use App\Http\Requests\StoreShipmentRequest;
use App\Http\Requests\UpdateShipmentRequest;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\SpladeTable;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query->orWhere('name', 'LIKE', "%$value%");
                    $query->orWhere('id', 'LIKE', "%$value%");
                });
            });
        });
    
        $shipments = QueryBuilder::for(Shipment::class)
            ->allowedFilters(['id', 'product_id', 'branch_id', 'supplier_id', 'quantity', 'total', 'created_at', $globalSearch])
            ->allowedSorts(['id', 'product_id', 'branch_id', 'supplier_id', 'quantity', 'total', 'created_at'])
            ->leftJoin('products', 'shipments.product_id', '=', 'products.id')
            ->leftJoin('branches', 'shipments.branch_id', '=', 'branches.id')
            ->leftJoin('suppliers', 'shipments.supplier_id', '=', 'suppliers.id')
            ->select('shipments.*', 'products.name as product', 'branches.name as branch', 'suppliers.name as supplier')
            ->paginate()
            ->withQueryString();
    
        return view('shipments.index', [
            'shipments' => SpladeTable::for($shipments)
                ->withGlobalSearch()
                ->column(
                    'product',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    'branch',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    'supplier',
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
                    'total',
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
        $branches = Branch::all();
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('shipments.create', compact('branches', 'suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShipmentRequest $request)
    {
        // Retrieve the product
        $product = Product::findOrFail($request->product_id);

        // Calculate the total based on the requested quantity
        $total = $product->price * $request->quantity;

        // Create the shipment
        $shipment = Shipment::create([
            'product_id' => $request->product_id,
            'supplier_id' => $request->supplier_id,
            'branch_id' => $request->branch_id,
            'quantity' => $request->quantity,
            'total' => $total,
        ]);

        // Increase the product quantity
        $product->increment('quantity', $request->quantity);

        // Toast success message
        Toast::title('Success')->message('Shipment created successfully!')->success();

        // Redirect to the index page
        return redirect()->route('shipments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment)
    {
        return view('shipments.edit', compact('shipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShipmentRequest $request, Shipment $shipment)
    {
        $shipment->update($request->validated());
        Toast::title('Success')->message('Shipment updated successfully!')->success();
        return redirect()->route('shipments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment)
    {
        //
    }
}
