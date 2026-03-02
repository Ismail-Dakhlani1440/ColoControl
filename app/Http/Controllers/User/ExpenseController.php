<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Http\Requests\StoreExpenseRequest;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user      = Auth::user();
        $flatShare = $user->activeFlatShare()->first();

        abort_if(!$flatShare, 403);

        $month = $request->input('month', null);

        $expenses = $flatShare->expenses()
            ->with(['payer', 'creator', 'categorie', 'payments.user'])
            ->when($month, fn($q) => $q->whereYear('date', substr($month, 0, 4))
                                       ->whereMonth('date', substr($month, 5, 2)))
            ->latest('date')
            ->get();

        return view('expenses.index', compact('expenses', 'flatShare', 'month'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user      = Auth::user();
        $flatShare = $user->activeFlatShare()->first();

        abort_if(!$flatShare, 403);

        $members    = $flatShare->activeUsers()->get();
        $categories = $flatShare->categories()->get();

        return view('expenses.create', compact('flatShare', 'members', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        $user      = Auth::user();
        $flatShare = $user->activeFlatShare()->first();

        $expense = $flatShare->expenses()->create([
            'title'       => $request->title,
            'description' => $request->description,
            'ammount'     => $request->ammount,
            'date'        => $request->date,
            'payer_id'    => $request->payer_id,
            'creator_id'  => $user->id,
            'category_id' => $request->category_id,
        ]);

        $expense->initializePayments();

        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Expense created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $user      = Auth::user();
        $flatShare = $user->activeFlatShare()->first();

        abort_if(!$flatShare || $expense->flat_share_id !== $flatShare->id, 403);

        $expense->load(['payer', 'creator', 'categorie', 'payments.user']);

        $isOwner = $flatShare->owner_id === $user->id;

        return view('expenses.show', compact('expense', 'flatShare', 'isOwner'));
    }

    public function markPaid(Request $request, Expense $expense)
    {
        $user      = Auth::user();
        $flatShare = $user->activeFlatShare()->first();

        abort_if(!$flatShare || $expense->flat_share_id !== $flatShare->id, 403);

        $targetUserId = $request->input('user_id');
        $isOwner      = $flatShare->owner_id === $user->id;

        if (!$isOwner && $targetUserId != $user->id) {
            abort(403);
        }

        $expense->users()->updateExistingPivot($targetUserId, ['payed' => true]);

        return back()->with('success', 'Payment marked as paid.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
