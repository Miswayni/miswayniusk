<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;


class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $amount = $request->amount;
        $type = $request->type;

        if ($type == 'top_up') {
            $user->balance += $amount;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'top_up',
                'amount' => $amount,
                'status'=> 'success',
                'description' => 'Top-up sebesar Rp ' . number_format($amount, 0, ',', '.'),
            ]);
        } elseif ($type == 'withdraw') {
            if ($user->balance < $amount) {
                return back()->with('error', 'Saldo tidak mencukupi.');
            }

            $user->balance -= $amount;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdraw',
                'amount' => $amount,
                'status'=> 'success',
                'description' => 'Penarikan sebesar Rp ' . number_format($amount, 0, ',', '.'),
            ]);
        }

        return back()->with('success', 'Transaksi berhasil diproses.');
}
}
