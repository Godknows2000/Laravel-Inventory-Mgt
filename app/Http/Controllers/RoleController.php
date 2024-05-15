<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\Permission\Models\Permission;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends Controller
{
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
        $roles = QueryBuilder::for(Role::class)
            ->defaultSort('name')
            ->allowedFilters(['id', 'name', 'created_at', $globalSearch])
            ->allowedSorts(['id', 'name', 'email', 'created_at'])
            ->paginate()
            ->withQueryString();

        return view('roles.index', [
            'roles' => SpladeTable::for($roles)
                ->defaultSort('name')
                ->withGlobalSearch()
                ->column('id', sortable: true, searchable: true)
                ->column(
                    'name',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column('created_at', sortable: true, searchable: true)
                ->column('permission')
                ->column('action'),
        ]);
    }

    public function create()
    {
        $permissions = Permission::all();
        $roles = Role::all();

        return view('roles.create', [
            'permissions' => $permissions,
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);

        $role->syncPermissions($request->permissions);

        Toast::title('Success!')
            ->message('Role Created Successfully!')
            ->success()
            ->info()
            ->leftTop()
            ->backdrop()
            ->autoDismiss(3);

        return redirect()->route('roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update([
            'name' => $request->name,
        ]);

        $role->syncPermissions($request->permissions);

        Toast::title('Success!')
            ->message('Role Updated Successfully!')
            ->success()
            ->info()
            ->leftTop()
            ->backdrop()
            ->autoDismiss(3);

        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        Toast::title('Success!')
            ->message('Role Deleted Successfully!')
            ->success()
            ->info()
            ->leftTop()
            ->backdrop()
            ->autoDismiss(3);

        return redirect()->route('roles.index');
    }
}
