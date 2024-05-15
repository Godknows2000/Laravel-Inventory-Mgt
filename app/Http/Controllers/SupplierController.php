<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\Facades\Toast;

class SupplierController extends Controller
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
            ->allowedFilters(['id', 'name', 'phone', 'email', 'address', 'created_at', $globalSearch])
            ->allowedSorts(['id', 'name', 'phone', 'email', 'address', 'created_at'])
            ->paginate()
            ->withQueryString();
    
        return view('suppliers.index', [
            'suppliers' => SpladeTable::for($suppliers)
                ->withGlobalSearch()
                ->column(
                    'name',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    'phone',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    'email',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    'address',
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
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        Supplier::create($request->validated());
        Toast::title('Success')->message('Supplier created successfully!')->success();
        return redirect()->route('suppliers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());
        Toast::title('Success')->message('Supplier updated successfully!')->success();
        return redirect()->route('suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        Toast::title('Success')->message('Supplier deleted successfully!')->success();
        return redirect()->route('suppliers.index');
    }
}
