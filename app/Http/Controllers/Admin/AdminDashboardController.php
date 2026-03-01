<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\FlatShare;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'banned_users' => User::where('is_banned', true)->count(),
            'total_flatshares' => FlatShare::count(),
            'active_flatshares' => FlatShare::where('status', 'active')->count(),
            'total_expenses' => Expense::count(),
            'total_amount' => Expense::sum('ammount'),
        ];

        return view('admin.dashboard',compact('stats'));
    }
}
