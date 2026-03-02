<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\FlatShare;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers      = User::count();
        $bannedUsers     = User::where('is_banned', true)->count();
        $totalFlatShares = FlatShare::count();
        $totalExpenses   = Expense::count();
        $totalSpent      = Expense::sum('ammount');

        $users = User::with('role')
            ->withCount(['ownedFlatShares', 'createdExpenses'])
            ->latest()
            ->get();

        $roles = Role::all();

        $stats = compact(
            'totalUsers',
            'bannedUsers',
            'totalFlatShares',
            'totalExpenses',
            'totalSpent'
        );

        return view('admin.index', compact('users', 'roles', 'stats'));
    }

    public function ban(User $user)
    {
        abort_if($user->isAdmin(), 403);

        $user->update(['is_banned' => true]);

        return back()->with('success', "{$user->name} has been banned.");
    }

    public function unban(User $user)
    {
        $user->update(['is_banned' => false]);

        return back()->with('success', "{$user->name} has been unbanned.");
    }

    public function updateRole(Request $request, User $user)
    {
        abort_if($user->id === Auth::id(), 403);

        $request->validate(['role_id' => 'required|exists:roles,id']);

        $user->update(['role_id' => $request->role_id]);

        return back()->with('success', "{$user->name}'s role has been updated.");
    }
}
