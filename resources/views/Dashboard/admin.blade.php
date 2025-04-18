<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 text-gray-800">

  <!-- Header -->
  <header class="bg-blue-100 shadow px-6 py-4 flex justify-between items-center fixed w-full z-10">
    <h1 class="text-2xl font-bold text-blue-600">Admin Dashboard</h1>
    <form action="{{ url('/logout') }}" method="POST">
      @csrf
      <button class="bg-blue-300 hover:bg-blue-400 text-white px-4 py-2 rounded transition">Logout</button>
    </form>
  </header>

  <!-- Layout -->
  <div class="flex pt-20">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-blue-100 min-h-screen p-6 shadow-md">
      <nav class="space-y-3">
        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-100 transition font-medium text-blue-700">
          👤 Tambah User
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-100 transition font-medium text-blue-700">
          📄 Riwayat Transaksi
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 space-y-10">

      <!-- Form Tambah User -->
      <section>
        <h2 class="text-xl font-semibold text-blue-700 mb-4">Tambah User</h2>
        @if (session('success'))
          <div class="bg-green-100 text-green-800 p-3 rounded mb-4 border border-green-300">
            {{ session('success') }}
          </div>
        @endif
        <div class="bg-white shadow border border-blue-100 rounded-lg p-6">
          <form action="{{ route('admin.tambah.user') }}" method="POST" class="space-y-4">
            @csrf
            <div>
              <label class="block font-medium mb-1">Nama</label>
              <input type="text" name="name" class="w-full px-4 py-2 border border-blue-200 rounded focus:ring-2 focus:ring-blue-200" required>
            </div>
            <div>
              <label class="block font-medium mb-1">Email</label>
              <input type="email" name="email" class="w-full px-4 py-2 border border-blue-200 rounded focus:ring-2 focus:ring-blue-200" required>
            </div>
            <div>
              <label class="block font-medium mb-1">Password</label>
              <input type="password" name="password" class="w-full px-4 py-2 border border-blue-200 rounded focus:ring-2 focus:ring-blue-200" required>
            </div>
            <div>
              <label class="block font-medium mb-1">Role</label>
              <select name="role" class="w-full px-4 py-2 border border-blue-200 rounded focus:ring-2 focus:ring-blue-200" required>
                <option value="bank_mini">Bank Mini</option>
                <option value="siswa">Siswa</option>
                <option value="siswa">Admin</option>
              </select>
            </div>
            <button type="submit" class="bg-blue-400 text-white px-6 py-2 rounded hover:bg-blue-500 transition">
              Tambah
            </button>
          </form>
        </div>
      </section>

      <!-- Data User -->
<section>
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
          <td class="px-6 py-4 border-t">{{ $user->role }}</td>
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
