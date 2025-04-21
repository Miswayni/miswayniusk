<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class BankMiniController extends Controller
{
    public function index()
    {
        $users = User::all();

        $transactions = Transaction::with('user', 'recipient')->latest()->get();

        return view('dashboard.bankmini', compact('users', 'transactions'));
    }
}
