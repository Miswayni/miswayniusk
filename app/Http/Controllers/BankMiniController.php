<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class BankMiniController extends Controller
{
    public function index()
    {
        // Ambil semua user
        $users = User::all();

        // Ambil semua transaksi beserta relasi user dan recipient
        $transactions = Transaction::with('user', 'recipient')->latest()->get();

        return view('dashboard.bankmini', compact('users', 'transactions'));
    }
}
