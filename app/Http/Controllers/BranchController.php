<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\SpladeTable;

class BranchController extends Controller
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
    
        $branches = QueryBuilder::for(Branch::class)
            ->allowedFilters(['id', 'name', 'phone', 'email', 'address', 'created_at', $globalSearch])
            ->allowedSorts(['id', 'name', 'phone', 'email', 'address', 'created_at'])
            ->paginate()
            ->withQueryString();
    
        return view('branches.index', [
            'branches' => SpladeTable::for($branches)
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
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request)
    {
        Branch::create($request->validated());
        Toast::title('Success')->message('Product created successfully!')->success();
        return redirect()->route('branches.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $product->update($request->validated());
        Toast::title('Success')->message('Product updated successfully!')->success();
        return redirect()->route('branches.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $product->delete();
        Toast::title('Success')->message('Product deleted successfully!')->success();
        return redirect()->route('branches.index');
    }
}
