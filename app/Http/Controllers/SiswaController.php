<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data masuk
        $request->validate([
            'type' => 'required|in:top_up,withdraw,transfer',
            'amount' => 'required|numeric|min:1000',
            'recipient_name' => 'required_if:type,transfer|string|exists:users,name',  // Validasi penerima
        ]);
    
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
    
        /** @var \App\Models\User $user */
        $user = Auth::user();  // Ambil user yang sedang login
        $type = $request->type;
        $amount = $request->amount;
    
        DB::beginTransaction();
    
        try {
            if ($type === 'top_up') {
                // Proses top-up
                $user->balance += $amount;
                $user->save();
    
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'top_up',
                    'amount' => $amount,
                    'status' => 'success',
                    'description' => 'Top-up sebesar Rp ' . number_format($amount, 0, ',', '.'),
                ]);
    
            } elseif ($type === 'withdraw') {
                // Cek saldo
                if ($user->balance < $amount) {
                    return back()->with('error', 'Saldo tidak mencukupi untuk tarik tunai.');
                }
    
                $user->balance -= $amount;
                $user->save();
    
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'withdraw',
                    'amount' => $amount,
                    'status' => 'success',
                    'description' => 'Tarik tunai sebesar Rp ' . number_format($amount, 0, ',', '.'),
                ]);
    
            } elseif ($type === 'transfer') {
                // Proses transfer
                $recipientName = $request->recipient_name;
                $recipient = User::where('name', $recipientName)->first();
    
                if (!$recipient) {
                    return back()->with('error', 'Penerima tidak ditemukan.');
                }
    
                if ($user->id === $recipient->id) {
                    return back()->with('error', 'Tidak bisa transfer ke diri sendiri.');
                }
    
                if ($user->balance < $amount) {
                    return back()->with('error', 'Saldo tidak mencukupi untuk transfer.');
                }
    
                // Mengurangi saldo dari pengirim
                $user->balance -= $amount;
                $user->save();
    
                // Menambahkan saldo ke penerima
                $recipient->balance += $amount;
                $recipient->save();
    
                // Mencatat transaksi untuk pengirim
                Transaction::create([
                    'user_id' => $user->id,
                    'recipient_id' => $recipient->id,
                    'type' => 'transfer',
                    'amount' => $amount,
                    'status' => 'success',
                    'description' => 'Transfer ke ' . $recipient->name . ' sebesar Rp ' . number_format($amount, 0, ',', '.'),
                ]);
    
                // Mencatat transaksi untuk penerima
                Transaction::create([
                    'user_id' => $recipient->id,
                    'recipient_id' => $user->id,
                    'type' => 'transfer',
                    'amount' => $amount,
                    'status' => 'success',
                    'description' => 'Diterima Rp ' . number_format($amount, 0, ',', '.') . ' dari ' . $user->name,
                ]);
            }
    
            DB::commit();
            return back()->with('success', 'Transaksi berhasil!');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
}
