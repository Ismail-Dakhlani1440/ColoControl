<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FlatShare;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreFlatShareRequest;

class FlatShareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user      = Auth::user();
        $flatShare = $user->activeFlatShare()->first();
        $stats     = null;

        if ($flatShare) {
            $flatShare->load(['owner', 'activeUsers']);

            $activeMembers = $flatShare->activeUsers;
            $memberCount   = $activeMembers->count();
            $expenses      = $flatShare->expenses()->with('payments')->get();

            $roommates = $activeMembers->map(function ($member) use ($flatShare, $expenses) {
                $fairShare = $expenses->sum(function ($expense) use ($member) {
                    $isIncluded = $expense->payments->where('user_id', $member->id)->isNotEmpty();
                    return $isIncluded ? $expense->getSplitAmount() : 0;
                });

                return [
                    'id'          => $member->id,
                    'name'        => $member->name,
                    'reputation'  => $member->reputation,
                    'joined_date' => $member->pivot->joined_at,
                    'badge'       => $member->id === $flatShare->owner_id ? 'owner' : 'member',
                    'balance'     => $member->balanceInFlatShare($flatShare),
                    'fair_share'  => $fairShare,
                ];
            });

            $stats = [
                'total_spent'    => $flatShare->expenses()->sum('ammount') ?? 0,
                'fair_share'     => $roommates->firstWhere('id', $user->id)['fair_share'] ?? 0,
                'user_balance'   => $user->balanceInFlatShare($flatShare) ?? 0,
                'amount_owed'    => $user->amountOwedInFlatShare($flatShare) ?? 0,
                'amount_owes'    => $user->amountOwingInFlatShare($flatShare) ?? 0,
                'roommate_count' => $memberCount ?? 0,
                'roommates'      => $roommates,
            ];
        }

        return view('flatshares.index', compact('flatShare', 'stats'));
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

        return redirect()->route('flatshares.index')
            ->with('success', 'Colocation créée avec succès !');

    }

    /**
     * Current user voluntarily leaves their flatshare.
     * Reputation adjusts based on their debt status.
     */
    public function leave()
    {
        $user      = Auth::user();
        $flatShare = $user->activeFlatShare()->first();

        abort_if(!$flatShare, 403);
        abort_if($flatShare->owner_id === $user->id, 403, 'Owner cannot leave — cancel the flatshare instead.');

        $user->adjustReputationOnLeave($flatShare);
        $flatShare->removeMember($user);

        return redirect()->route('flatshares.index')
            ->with('success', 'You have left the colocation.');
    }

    /**
     * Owner removes a specific member from the flatshare.
     * No reputation change when owner kicks someone.
     */
    public function removeMember(User $member)
    {
        $user      = Auth::user();
        $flatShare = $user->activeFlatShare()->first();

        abort_if(!$flatShare, 403);
        abort_if($flatShare->owner_id !== $user->id, 403);
        abort_if($member->id === $user->id, 403);

        $flatShare->removeMember($member);

        return back()->with('success', "{$member->name} has been removed.");
    }

    /**
     * Owner cancels the flatshare — removes all members and marks it cancelled.
     */
    public function cancel()
    {
        $user      = Auth::user();
        $flatShare = $user->activeFlatShare()->first();

        abort_if(!$flatShare, 403);
        abort_if($flatShare->owner_id !== $user->id, 403);

        $flatShare->cancelAndRemoveAll();

        return redirect()->route('flatshares.index')
            ->with('success', 'The colocation has been cancelled.');
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