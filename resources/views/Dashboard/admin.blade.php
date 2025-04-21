<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 text-gray-800">

  <header class="bg-blue-100 px-4 py-3 shadow-sm">
    <h1 class="text-lg font-semibold text-blue-600">Dashboard</h1>
  </header>

  <div class="flex flex-col md:flex-row">

    <aside class="md:w-60 bg-white border-r border-blue-100 p-4">
      <form action="{{ url('/logout') }}" method="POST" class="mb-4">
        @csrf
        <button class="w-full bg-blue-200 hover:bg-blue-300 text-sm text-blue-800 px-3 py-2 rounded">
          Logout
        </button>
      </form>

    </aside>

    <main class="flex-1 p-4 space-y-8">

      <section>
        <h2 class="text-base font-semibold text-blue-700 mb-2">Tambah User</h2>
        @if (session('success'))
          <div class="bg-green-100 text-green-800 p-2 rounded text-sm border border-green-200 mb-2">
            {{ session('success') }}
          </div>
        @endif
        <form action="{{ route('admin.tambah.user') }}" method="POST" class="bg-white p-4 border border-blue-100 rounded space-y-3">
          @csrf
          <div>
            <label class="block text-sm mb-1">Nama</label>
            <input type="text" name="name" class="w-full px-3 py-2 border border-blue-100 rounded text-sm" required>
          </div>
          <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" class="w-full px-3 py-2 border border-blue-100 rounded text-sm" required>
          </div>
          <div>
            <label class="block text-sm mb-1">Password</label>
            <input type="password" name="password" class="w-full px-3 py-2 border border-blue-100 rounded text-sm" required>
          </div>
          <div>
            <label class="block text-sm mb-1">Role</label>
            <select name="role" class="w-full px-3 py-2 border border-blue-100 rounded text-sm" required>
              <option value="bank_mini">Bank Mini</option>
              <option value="siswa">Siswa</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <button type="submit" class="bg-blue-300 hover:bg-blue-400 text-white px-4 py-2 rounded text-sm">
            Tambah
          </button>
        </form>
      </section>
        
      <section>
        <h2 class="text-base font-semibold text-blue-700 mb-2">Data User</h2>      
        <div class="mb-4 text-left">
          <button
            onclick="window.print()"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          >
            🖨️ Cetak Data User
          </button>
        </div>
          
        <div id="printArea" class="overflow-x-auto">
          <table class="min-w-full bg-white text-sm border border-blue-100 rounded">
            <thead class="bg-blue-100 text-blue-800">
              <tr>
                <th class="text-left px-4 py-2 border-b">ID</th>
                <th class="text-left px-4 py-2 border-b">Nama</th>
                <th class="text-left px-4 py-2 border-b">Role</th>
                <th class="text-left px-4 py-2 border-b">Saldo</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
                <tr class="hover:bg-blue-50">
                  <td class="px-4 py-2 border-t">{{ $user->id }}</td>
                  <td class="px-4 py-2 border-t">{{ $user->name }}</td>
                  <td class="px-4 py-2 border-t">{{ $user->role }}</td>
                  <td class="px-4 py-2 border-t">
                    Rp {{ number_format($user->balance, 0, ',', '.') }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>
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
