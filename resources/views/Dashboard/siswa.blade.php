<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Siswa Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 text-blue-900 font-sans">
  <div class="flex min-h-screen">
    <aside class="w-64 bg-white shadow-sm border-r border-blue-100 p-6">
      <h2 class="text-xl font-semibold mb-8 text-blue-700">Siswa Panel</h2>
      <form action="{{ url('/logout') }}" method="POST" class="mt-8">
        @csrf
        <button type="submit" class="w-full bg-blue-300 text-white py-2 rounded-lg hover:bg-blue-400 transition">Logout</button>
      </form>
    </aside>
    <main class="flex-1 p-6 space-y-8">
      <div class="mb-6">
        <h1 class="text-2xl font-semibold text-blue-700">Selamat Datang, Siswa</h1>
        <p class="text-sm text-blue-600 mt-1">Kelola keuangan sekolahmu dengan mudah dan aman.</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-100">
          <h3 class="text-lg font-semibold text-blue-700 mb-2">Saldo Anda</h3>
          <p class="text-xl font-bold text-blue-500">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</p>
        </div>
      
          <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-100">
          <h3 class="text-lg font-semibold text-blue-700 mb-2">Transaksi Terakhir</h3>
          <p class="text-xl font-bold text-blue-500">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</p>
          <span class="text-sm text-blue-400">04 April 2025</span>
        </div>
      </div>

      <div class="space-y-10">
        
        <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-100">
          <h2 class="text-lg font-semibold text-blue-700 mb-4">Top Up Saldo</h2>
          <form method="POST" action="{{ route('siswa.transaction.store') }}">
            @csrf
            <input type="hidden" name="type" value="top_up">
            <div class="mb-4">
              <label class="block text-sm mb-1">Jumlah Top Up</label>
              <input type="number" name="amount" placeholder="Masukkan Jumlah Top Up" class="w-full px-4 py-2 border border-blue-200 rounded-lg text-sm" required />
            </div>
            <button type="submit" class="bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition">Top Up</button>
          </form>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-100">
          <h2 class="text-lg font-semibold text-blue-700 mb-4">Tarik Saldo</h2>
          <form method="POST" action="{{ route('siswa.transaction.store') }}">
            @csrf
            <input type="hidden" name="type" value="withdraw">
            <div class="mb-4">
              <label class="block text-sm mb-1">Jumlah Penarikan</label>
              <input type="number" name="amount" placeholder="Masukkan Jumlah Penarikan" class="w-full px-4 py-2 border border-blue-200 rounded-lg text-sm" required />
            </div>
            <button type="submit" class="bg-red-400 text-white px-4 py-2 rounded-lg hover:bg-red-500 transition">Tarik Saldo</button>
          </form>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-100">
          <h2 class="text-lg font-semibold text-blue-700 mb-4">Transfer ke Siswa Lain</h2>
          <form method="POST" action="{{ route('siswa.transaction.store') }}">
            @csrf
            <input type="hidden" name="type" value="transfer">
            <div class="mb-4">
              <label class="block text-sm mb-1">Nama Penerima</label>
              <input type="text" name="recipient_name" placeholder="Masukkan Nama Penerima" class="w-full px-4 py-2 border border-blue-200 rounded-lg text-sm" required />
            </div>
            <div class="mb-4">
              <label class="block text-sm mb-1">Jumlah Transfer</label>
              <input type="number" name="amount" placeholder="Masukkan Jumlah Transfer" class="w-full px-4 py-2 border border-blue-200 rounded-lg text-sm" required />
            </div>
            <button type="submit" class="bg-green-400 text-white px-4 py-2 rounded-lg hover:bg-green-500 transition">Transfer</button>
          </form>
        </div>
        
      </div>
    
      <div>
        <h2 class="text-lg font-semibold text-blue-700 mb-4">Riwayat Transaksi</h2>
          
        <div class="text-left mb-4">
          <button
            onclick="window.print()"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          >
            🖨️ Cetak Transaksi
          </button>
        </div>
          
        <div id="printArea" class="bg-white p-4 rounded-lg shadow-sm border border-blue-100">
          <table class="min-w-full table-auto text-sm">
            <thead class="bg-blue-100 text-blue-700 text-xs">
              <tr>
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Jenis Transaksi</th>
                <th class="px-4 py-2">Jumlah</th>
                <th class="px-4 py-2">Nama Penerima</th>
                <th class="px-4 py-2">Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @foreach(Auth::user()->transactions()->latest()->get() as $i => $trx)
                <tr class="hover:bg-blue-50">
                  <td class="px-4 py-2 border-t">{{ $i + 1 }}</td>
                  <td class="px-4 py-2 border-t">{{ ucfirst($trx->type) }}</td>
                  <td class="px-4 py-2 border-t">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                  <td class="px-4 py-2 border-t">
                    {{ $trx->recipient_id ? \App\Models\User::find($trx->recipient_id)->name : '-' }}
                  </td>
                  <td class="px-4 py-2 border-t">{{ $trx->created_at->format('d M Y') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <style>
        @media print {
          body * {
            visibility: hidden;
          }
          #printArea, #printArea * {
            visibility: visible;
          }
          #printArea {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
          }
        }
      </style>      
    </main>
  </div>
</body>
</html>
