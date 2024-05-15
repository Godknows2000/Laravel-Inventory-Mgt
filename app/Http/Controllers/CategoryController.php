<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\Facades\Toast;

class CategoryController extends Controller
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
    
        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters(['id', 'name', 'description', 'created_at', $globalSearch])
            ->allowedSorts(['id', 'name', 'description', 'created_at'])
            ->paginate()
            ->withQueryString();
    
        return view('categories.index', [
            'categories' => SpladeTable::for($categories)
                ->withGlobalSearch()
                ->column(
                    'name',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    'description',
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
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());
        Toast::title('Success')->message('Category created successfully!')->success();
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        Toast::title('Success')->message('Category updated successfully!')->success();
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        Toast::title('Success')->message('Category deleted successfully!')->success();
        return redirect()->route('categories.index');
    }
}
