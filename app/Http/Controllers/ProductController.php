<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Branch;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BranchController;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\SpladeTable;

class ProductController extends Controller
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
    
        $products = QueryBuilder::for(Product::class)
            ->allowedFilters(['id', 'name', 'price', 'quantity', 'size', 'category', 'created_at', $globalSearch])
            ->allowedSorts(['id', 'name', 'price', 'quantity', 'size', 'category', 'created_at'])
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('branches', 'products.branch_id', '=', 'branches.id')
            ->select('products.*', 'categories.name as category', 'branches.name as branch')
            ->paginate()
            ->withQueryString();
    
        return view('products.index', [
            'products' => SpladeTable::for($products)
                ->withGlobalSearch()
                ->column('id', sortable: true, searchable: true)
                ->column(
                    'name',
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
                    'category',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    'size',
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
                    'quantity',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column('created_at', sortable: true, searchable: true)
                ->column('action'),
        ]);
    }

    public function viewMonthlyStocks()
    {
        $stocks = Product::selectRaw('MONTH(created_at) as month, SUM(quantity) as total_quantity')
            ->groupBy('month')
            ->get();

        return view('products.monthly', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $branches = Branch::all();
        return view('products.create', compact('categories', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());
        Toast::title('Success')->message('Product created successfully!')->success();
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        Toast::title('Success')->message('Product updated successfully!')->success();
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Toast::title('Success')->message('Product deleted successfully!')->success();
        return redirect()->route('products.index');
    }
}
