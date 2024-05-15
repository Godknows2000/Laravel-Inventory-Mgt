<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Branch;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Controllers\BranchController;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\SpladeTable;

class StudentController extends Controller
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
    
        $students = QueryBuilder::for(Student::class)
            ->allowedFilters(['id', 'name',  'phone', 'email', 'address', 'branch', 'created_at', $globalSearch])
            ->allowedSorts(['id', 'name', 'phone', 'email', 'address', 'branch', 'created_at'])
            ->leftJoin('branches', 'students.branch_id', '=', 'students.id')
            ->select('students.*', 'branches.name as branch_name')
            ->paginate()
            ->withQueryString();
    
        return view('students.index', [
            'students' => SpladeTable::for($students)
                ->withGlobalSearch()
                ->column('id', sortable: true, searchable: true)
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
                ->column(
                    'branch_name',
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
        return view('students.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        Student::create($request->validated());
        Toast::title('Success')->message('Student created successfully!')->success();
        return redirect()->route('students.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $branch->update($request->validated());
        Toast::title('Success')->message('Student updated successfully!')->success();
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $branch->delete();
        Toast::title('Success')->message('Student deleted successfully!')->success();
        return redirect()->route('branches.index');
    }
}
