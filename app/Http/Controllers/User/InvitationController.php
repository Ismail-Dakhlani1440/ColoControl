<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invitation;


class InvitationController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Invitation::class);

        $user = $request->user();
        $flatShare = $user->activeFlatShare()->first();

        $invitation = $flatShare->createInvitation();

        return redirect()->route('invitations.show', $invitation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invitation $invitation)
    {
        $this->authorize('view', $invitation);

        return view('invitations.show', compact('invitation'));
    }

    public function accept(Request $request, Invitation $invitation)
    {
        $user = $request->user();

        if (!$invitation->isPending()) {
            return redirect()->route('flatshares.index')
                ->with('error', 'This invitation is no longer valid.');
        }

        if ($user->activeFlatShare()->exists()) {
            return redirect()->route('flatshares.index')
                ->with('error', 'You are already part of a flatshare.');
        }

        $flatShare = $invitation->flatShare;

        if (!$flatShare->hasAvailableSpace()) {
            $invitation->markAsExpired();
            return redirect()->route('flatshares.index')
                ->with('error', 'This flatshare is full.');
        }

        $flatShare->users()->attach($user->id, [
            'joined_at' => now(),
            'left_at'   => null,
        ]);

        $invitation->markAsExpired();

        return redirect()->route('flatshares.index')
            ->with('success', 'Welcome to ' . $flatShare->name . '!');
    }

    public function reject(Request $request, Invitation $invitation)
    {
        if (!$invitation->isPending()) {
            return redirect()->route('flatshares.index')
                ->with('error', 'This invitation is no longer valid.');
        }

        $invitation->markAsExpired();

        return redirect()->route('flatshares.index')
            ->with('success', 'Invitation declined.');
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
