<?php

namespace App\Http\Controllers;

use App\Models\OrderNote;
use App\Http\Requests\StoreOrderNoteRequest;
use App\Http\Requests\UpdateOrderNoteRequest;
use ProtoneMedia\Splade\Facades\Toast;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use ProtoneMedia\Splade\SpladeTable;

class OrderNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query->orWhere('ordernote_number', 'LIKE', "%$value%");
                    $query->orWhere('branch_id', 'LIKE', "%$value%");
                    $query->orWhere('created_by', 'LIKE', "%$value%");
                });
            });
        });
    
        $orderNotes = QueryBuilder::for(OrderNote::class)
            ->allowedFilters(['ordernote_number', 'branch_id', 'created_by', 'status', 'created_at', $globalSearch])
            ->allowedSorts(['ordernote_number', 'branch_id', 'created_by', 'status', 'created_at'])
            ->paginate()
            ->withQueryString();
    
        return view('order-notes.index', [
            'orderNotes' => SpladeTable::for($orderNotes)
                ->withGlobalSearch()
                ->column(
                    'ordernote_number',
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
                    'created_by',
                    canBeHidden: false,
                    sortable: true,
                    searchable: true
                )
                ->column(
                    'status',
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
        return view('order-notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderNoteRequest $request)
    {
        $orderNote = OrderNote::create($request->validated());
        Toast::title('Success')->message('Order note created successfully!')->success();
        return redirect()->route('order-notes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderNote $orderNote)
    {
        return view('order-notes.show', compact('orderNote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderNote $orderNote)
    {
        return view('order-notes.edit', compact('ordernote'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderNoteRequest $request, OrderNote $orderNote)
    {
        $orderNote->update($request->validated());
        Toast::title('Success')->message('Order note updated successfully!')->success();
        return redirect()->route('order-notes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderNote $orderNote)
    {
        $orderNote->delete();
        Toast::title('Success')->message('Order note deleted successfully!')->success();
        return redirect()->route('order-notes.index');
    }
}
