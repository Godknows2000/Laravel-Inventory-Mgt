<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdaterequest;
use Illuminate\Support\Collection;
use App\Models\User;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class UsersController extends Controller
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
                    $query
                        ->orWhere('name', 'LIKE', "%$value%")
                        ->orWhere('email', 'LIKE', "%$value%");
                });
            });
        });

        $users = QueryBuilder::for(User::class)
            ->defaultSort('name')
            ->allowedFilters([
                'id',
                'name',
                'email',
                'created_at',
                'role',
                $globalSearch,
            ])
            ->allowedSorts(['id', 'name', 'email', 'created_at'])
            ->paginate()
            ->withQueryString();

        return view('users.index', [
            'users' => SpladeTable::for($users)
                ->defaultSort('name')
                ->withGlobalSearch()
                ->column('id', sortable: true, searchable: true)
                ->column(
                    'name',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column('email', sortable: true, searchable: true)
                ->column('role', sortable: true, searchable: true)
                ->column('created_at', sortable: true, searchable: true)
                ->column('action')
                ->rowLink(fn($user) => route('users.show', $user->id)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->validated());

        $user->syncRoles($request->roles, [

        ]);


        Toast::title('Success!')
            ->message('User Created Successfully!')
            ->success()
            ->info()
            ->leftTop()
            ->backdrop()
            ->autoDismiss(3);
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        $user->syncRoles($request->roles, []);


        Toast::title('Success!')
            ->message('User Updated Successfully!')
            ->success()
            ->leftTop()
            ->info()
            ->backdrop()
            ->autoDismiss(3);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user);

        //        $user->revokePermissionTo($user->permissions);

        Toast::title('warning!')
            ->message('User Deleted Successfully!')
            ->success()
            ->leftTop()
            ->backdrop()
            ->autoDismiss(3);
        return redirect()->route('users.index');
    }
}
