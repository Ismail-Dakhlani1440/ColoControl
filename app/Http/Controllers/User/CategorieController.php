<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Categorie;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flatShare = Auth::user()->activeFlatShare()->first();

        abort_if(!$flatShare || $flatShare->owner_id !== Auth::id(), 403);

        $categories = $flatShare->categories()->withCount('expenses')->get();

        return view('categories.index', compact('categories', 'flatShare'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $flatShare = Auth::user()->activeFlatShare()->first();

        abort_if(!$flatShare || $flatShare->owner_id !== Auth::id(), 403);

        return view('categories.create', compact('flatShare'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $flatShare = Auth::user()->activeFlatShare()->first();

        abort_if(!$flatShare || $flatShare->owner_id !== Auth::id(), 403);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $flatShare->categories()->create($request->only('title', 'color'));

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
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
    public function edit(Categorie $category)
    {
        $flatShare = Auth::user()->activeFlatShare()->first();

        abort_if(!$flatShare || $flatShare->owner_id !== Auth::id(), 403);
        abort_if($category->flat_share_id !== $flatShare->id, 403);

        return view('categories.edit', compact('category', 'flatShare'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $category)
    {
        $flatShare = Auth::user()->activeFlatShare()->first();

        abort_if(!$flatShare || $flatShare->owner_id !== Auth::id(), 403);
        abort_if($category->flat_share_id !== $flatShare->id, 403);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $category->update($request->only('title', 'color'));

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $category)
    {
        $flatShare = Auth::user()->activeFlatShare()->first();

        abort_if(!$flatShare || $flatShare->owner_id !== Auth::id(), 403);
        abort_if($category->flat_share_id !== $flatShare->id, 403);

        if ($category->expenses()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete a category that is used in expenses.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted.');
    }
}
