<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Http\Requests\StoreShipmentRequest;
use App\Http\Requests\UpdateShipmentRequest;

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
    
        $suppliers = QueryBuilder::for(Supplier::class)
            ->allowedFilters(['id', 'product_id', 'branch_id', 'supplier_id', 'quantity', 'total', 'created_at', $globalSearch])
            ->allowedSorts(['id', 'product_id', 'branch_id', 'supplier_id', 'quantity', 'total', 'created_at'])
            ->paginate()
            ->withQueryString();
    
        return view('shipments.index', [
            'suppliers' => SpladeTable::for($shipments)
                ->withGlobalSearch()
                ->column(
                    'product_id',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    'branch_id',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    'supplier_id',
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShipmentRequest $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShipmentRequest $request, Shipment $shipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment)
    {
        //
    }
}
