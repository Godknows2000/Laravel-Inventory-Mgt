<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function (
            $query,
            $value
        ) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query->orWhere('name', 'LIKE', "%$value%");
                    $query->orWhere('id', 'LIKE', "%$value%");
                });
            });
        });

        $permissions = QueryBuilder::for(Permission::class)
            ->allowedFilters(['id', 'name', 'created_at', $globalSearch])
            ->allowedSorts(['id', 'name', 'created_at'])
            ->paginate()
            ->withQueryString();

        return view('permissions.index', [
            'permissions' => SpladeTable::for($permissions)
                ->withGlobalSearch()
                ->column('id', sortable: true, searchable: true)
                ->column(
                    'name',
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
        return view('permissions.create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permission = Permission::create(['name' => $request->name]);

        Toast::title('Success!')
            ->message('Permission Created Successfully!')
            ->success()
            ->info()
            ->leftTop()
            ->backdrop()
            ->autoDismiss(3);

        return redirect()->route('permissions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $permission->update(['name' => $request->name]);

        Toast::title('Success!')
            ->message('Permission Updated Successfully!')
            ->success()
            ->info()
            ->leftTop()
            ->backdrop()
            ->autoDismiss(3);

        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        Toast::title('Success!')
            ->message('Permission Deleted Successfully!')
            ->warning()
            ->info()
            ->leftTop()
            ->backdrop()
            ->autoDismiss(3);

        return redirect()->route('permissions.index');
    }
}
