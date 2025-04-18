<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi dan memuat relasi user pengirim dan penerima
        $transactions = Transaction::with('user', 'recipient')->latest()->get();

        // Kirim data transaksi ke view
        return view('dashboard.bankmini', compact('transactions'));
    }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'type' => 'required|in:top_up,withdraw,transfer',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000',
        ]);

        DB::beginTransaction();

        try {
            // Proses transaksi sesuai jenisnya
            $type = $request->type;
            $amount = $request->amount;
            $sender = User::find($request->user_id);

            if (!$sender) {
                return back()->with('error', 'Pengirim tidak ditemukan.');
            }

            // Handle top-up
            if ($type === 'top_up') {
                $sender->balance += $amount;
                $sender->save();

                Transaction::create([
                    'user_id' => $sender->id,
                    'type' => 'top_up',
                    'amount' => $amount,
                    'status' => 'success',
                    'description' => 'Top-up sebesar Rp ' . number_format($amount, 0, ',', '.'),
                ]);
            }

            // Handle withdraw
            elseif ($type === 'withdraw') {
                if ($sender->balance < $amount) {
                    return back()->with('error', 'Saldo tidak mencukupi untuk tarik tunai.');
                }

                $sender->balance -= $amount;
                $sender->save();

                Transaction::create([
                    'user_id' => $sender->id,
                    'type' => 'withdraw',
                    'amount' => $amount,
                    'status' => 'success',
                    'description' => 'Tarik tunai sebesar Rp ' . number_format($amount, 0, ',', '.'),
                ]);
            }

            // Handle transfer
            elseif ($type === 'transfer') {
                $recipientName = $request->recipient_name;
                $recipient = User::where('name', $recipientName)->first();

                if (!$recipient) {
                    return back()->with('error', 'Penerima tidak ditemukan.');
                }

                if ($sender->balance < $amount) {
                    return back()->with('error', 'Saldo tidak mencukupi untuk transfer.');
                }

                // Reduce balance from sender
                $sender->balance -= $amount;
                $sender->save();

                // Add balance to recipient
                $recipient->balance += $amount;
                $recipient->save();

                // Create transfer transaction for sender
                Transaction::create([
                    'user_id' => $sender->id,
                    'type' => 'transfer',
                    'amount' => $amount,
                    'status' => 'success',
                    'description' => 'Transfer sebesar Rp ' . number_format($amount, 0, ',', '.') . ' ke ' . $recipient->name,
                ]);

                // Create transfer transaction for recipient
                Transaction::create([
                    'user_id' => $recipient->id,
                    'type' => 'transfer',
                    'amount' => $amount,
                    'status' => 'success',
                    'description' => 'Diterima Rp ' . number_format($amount, 0, ',', '.') . ' dari ' . $sender->name,
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
