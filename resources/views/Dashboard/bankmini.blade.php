<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bank Mini Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-50 text-blue-900">

  <div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-blue-100 p-6 shadow-md">
      <h2 class="text-2xl font-bold mb-8 text-blue-800">🏦 Bank Mini</h2>
      <form action="{{ url('/logout') }}" method="POST" class="mt-10">
        @csrf
        <button type="submit" class="w-full bg-blue-400 hover:bg-blue-500 text-white py-2 rounded-lg transition">Logout</button>
      </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
      <header class="mb-8">
        <h1 class="text-3xl font-semibold text-blue-800">Selamat Datang di Bank Mini</h1>
        <p class="text-sm text-blue-600 mt-1">Pantau aktivitas dan kelola keuangan dengan mudah</p>
      </header>

      <!-- Transaksi Bank Mini & Riwayat Transaksi dalam Satu Card -->
      <section class="mt-10 max-w-5xl mx-auto bg-white border border-blue-100 rounded-xl p-6 shadow-sm hover:shadow-md transition">
        <h3 class="text-xl font-semibold text-blue-700 mb-4">💳 Transaksi Bank Mini & Riwayat</h3>

        <!-- Form Top Up -->
        <form action="{{ route('admin.transaction.store') }}" method="POST" class="mb-8">
          @csrf
          <input type="hidden" name="type" value="top_up">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-blue-800">User ID</label>
              <input type="number" name="user_id" required placeholder="Masukkan ID Siswa"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" />
            </div>
            <div>
              <label class="block text-sm font-medium text-blue-800">Jumlah Top Up</label>
              <input type="number" name="amount" required placeholder="Contoh: 100000"
                class="w-full px-4 py-2 border border-blue-200 rounded-lg" />
            </div>
            <div class="col-span-2 text-right">
              <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                💰 Proses Top Up
              </button>
            </div>
          </div>
        </form>

        <!-- Form Withdraw -->
        <form action="{{ route('admin.transaction.store') }}" method="POST" class="mb-8">
          @csrf
          <input type="hidden" name="type" value="withdraw">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-blue-800">User ID</label>
              <input type="number" name="user_id" required placeholder="Masukkan ID Siswa"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" />
            </div>
            <div>
              <label class="block text-sm font-medium text-blue-800">Jumlah Withdraw</label>
              <input type="number" name="amount" required placeholder="Contoh: 100000"
                class="w-full px-4 py-2 border border-blue-200 rounded-lg" />
            </div>
            <div class="col-span-2 text-right">
              <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">
                🏧 Proses Withdraw
              </button>
            </div>
          </div>
        </form>

        <!-- Riwayat Transaksi -->
        <div class="mt-8">
          <h4 class="text-lg font-semibold text-blue-700 mb-4">📜 Riwayat Transaksi</h4>
          <div class="overflow-x-auto">
            <table class="min-w-full border border-blue-200 text-sm text-blue-800">
              <thead class="bg-blue-100 text-blue-900">
                <tr>
                  <th class="px-4 py-2 border">No</th>
                  <th class="px-4 py-2 border">Nama Pengirim</th>
                  <th class="px-4 py-2 border">Jenis Transaksi</th>
                  <th class="px-4 py-2 border">Jumlah</th>
                  <th class="px-4 py-2 border">Penerima</th>
                  <th class="px-4 py-2 border">Tanggal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($transactions as $index => $trx)
                <tr class="hover:bg-blue-50">
                  <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                  <td class="px-4 py-2 border">{{ $trx->user->name }}</td>
                  <td class="px-4 py-2 border">{{ ucfirst($trx->type) }}</td>
                  <td class="px-4 py-2 border">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                  <td class="px-4 py-2 border">
                    @if ($trx->recipient)
                    {{ $trx->recipient->name }}
                    @else
                    Bank Mini
                    @endif
                  </td>
                  <td class="px-4 py-2 border">{{ $trx->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Data User -->
      <section class="mt-10 max-w-5xl mx-auto">
  <h2 class="text-xl font-semibold text-blue-700 mb-4">Data User</h2>
  <div class="bg-white border border-blue-100 rounded-lg shadow overflow-x-auto">
    <table class="min-w-full table-auto text-sm">
      <thead class="bg-blue-200 text-blue-800 uppercase text-xs">
        <tr>
          <th class="px-6 py-3 text-left">ID</th>
          <th class="px-6 py-3 text-left">Nama</th>
          <th class="px-6 py-3 text-left">Role</th>
          <th class="px-6 py-3 text-left">Saldo</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
    @foreach($users as $user)
    <tr class="hover:bg-blue-50">
        <td class="px-6 py-4 border-t">{{ $user->id }}</td>
        <td class="px-6 py-4 border-t">{{ $user->name }}</td>
        <td class="px-6 py-4 border-t">{{ ucfirst($user->role) }}</td>
        <td class="px-6 py-4 border-t">Rp {{ number_format($user->balance, 0, ',', '.') }}</td>
    </tr>
    @endforeach
</tbody>
    </table>
  </div>
</section>
    </main>
  </div>
</body>
</html>
