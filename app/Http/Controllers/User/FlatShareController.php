<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FlatShare;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreFlatShareRequest;

class FlatShareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->activeFlatShare()->exists()) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous êtes déjà membre d\'une colocation active.');
        }
        
        return view('flatshares.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlatShareRequest $request)
    {
         $user = Auth::user();

         $flatShare = FlatShare::create([
            'name' => $request->name,
            'max_flatmate' => $request->max_flatmate,
            'token' => \Illuminate\Support\Str::random(32),
            'status' => 'active',
            'owner_id' => $user->id,
        ]);

        $flatShare->users()->attach($user->id, [
            'joined_at' => now(),
            'left_at' => null,
        ]);

        return redirect()->route('dashboard', $flatShare)
            ->with('success', 'Colocation créée avec succès !');

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
