
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna | PingPong Mania</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 30px; font-family: Arial, sans-serif; background: #f1f5f9; color: #1e293b; }
        .container { max-width: 1100px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 25px; }
        h1 { margin: 0 0 8px; }
        .muted { color: #64748b; font-size: 14px; }
        .btn { display: inline-block; padding: 11px 15px; background: #2563eb; color: white; text-decoration: none; border-radius: 8px; }
        .panel { background: white; border-radius: 12px; padding: 22px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 500px; }
        th, td { padding: 15px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        th { color: #64748b; background: #f8fafc; }
        .badge { display: inline-block; padding: 5px 10px; border-radius: 20px; font-size: 12px; background: #dbeafe; color: #1d4ed8; }
        .pagination { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Manajemen Pengguna</h1>
                <div class="muted">Daftar akun yang terdaftar di PingPong Mania.</div>
            </div>
            <a class="btn" href="{{ route('admin.dashboard') }}">← Dashboard</a>
        </div>

        <div class="panel">
	
<div class="panel">

    {{-- TEMPEL NOTIFIKASI DI SINI --}}
    @if (session('success'))
        <p style="padding:12px; background:#dcfce7; color:#166534; border-radius:8px;">
            {{ session('success') }}
        </p>
    @endif

    @if (session('error'))
        <p style="padding:12px; background:#fee2e2; color:#991b1b; border-radius:8px;">
            {{ session('error') }}
        </p>
    @endif

    {{-- FORM PENCARIAN LAMA TETAP DI SINI --}}
    <form method="GET" action="{{ route('admin.users') }}">
        {{-- Jangan hapus isi form pencarianmu --}}
    </form>

    {{-- TABEL PENGGUNA TETAP DI BAWAH --}}
</div>

    <form method="GET" action="{{ route('admin.users') }}"
          style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">

        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="Cari nama atau email..."
            style="padding:12px; border:1px solid #cbd5e1; border-radius:8px; flex:1; min-width:200px;"
        >

        <button type="submit"
                style="padding:12px 18px; background:#2563eb; color:white; border:0; border-radius:8px; cursor:pointer;">
            Cari
        </button>

        <a href="{{ route('admin.users') }}"
           style="padding:12px 18px; background:#e2e8f0; color:#1e293b; border-radius:8px; text-decoration:none;">
            Reset
        </a>
    </form>

    <p class="muted">
        Hasil pencarian: {{ $users->total() }} akun
    </p>

            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
			<th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
<tbody>
    @forelse ($users as $user)
        <tr>
            <td>{{ $users->firstItem() + $loop->index }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <span class="badge">{{ $user->role ?: 'user' }}</span>
            </td>
            <td>
                @if ($user->id != auth()->id())
                    <form method="POST"
                          action="{{ route('admin.users.role', $user->id) }}"
                          style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                        @csrf

                        <select name="role"
                                style="padding:8px; border:1px solid #cbd5e1; border-radius:6px;">
                            <option value="user"
                                {{ $user->role == 'user' ? 'selected' : '' }}>
                                User
                            </option>

                            <option value="admin"
                                {{ $user->role == 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                        </select>

                        <button type="submit"
                                style="padding:8px 12px; background:#2563eb; color:white; border:0; border-radius:6px; cursor:pointer;">
                            Simpan
                        </button>
                    </form>
                @else
                    <span>Akun Anda</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">Belum ada pengguna terdaftar.</td>
        </tr>
    @endforelse
</tbody>
              
  </tbody>
            </table>

            <div class="pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</body>
</html>
