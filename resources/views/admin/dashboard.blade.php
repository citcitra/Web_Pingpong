
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | PingPong Mania</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 245px;
            background: #172554;
            color: white;
            padding: 28px 18px;
        }
        .brand { font-size: 21px; font-weight: bold; margin-bottom: 8px; }
        .tagline { color: #bfdbfe; font-size: 12px; margin-bottom: 38px; }
        .nav-label {
            color: #94a3b8;
            font-size: 11px;
            margin: 24px 12px 10px;
            text-transform: uppercase;
        }
        .nav-link {
            display: block;
            color: #dbeafe;
            text-decoration: none;
            padding: 13px 12px;
            border-radius: 8px;
            margin: 5px 0;
        }
        .nav-link:hover, .nav-link.active { background: #2563eb; color: white; }
        .main { margin-left: 245px; padding: 32px; }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 32px;
        }
        h1 { margin: 0 0 8px; font-size: 27px; }
        .muted { color: #64748b; font-size: 14px; }
        .profile {
            background: white;
            border-radius: 10px;
            padding: 12px 16px;
            font-weight: bold;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }
        .card, .panel {
            background: white;
            padding: 23px;
            border-radius: 13px;
            box-shadow: 0 3px 12px #0f172a08;
        }
        .card-label { color: #64748b; font-size: 14px; }
        .number { font-size: 32px; font-weight: bold; margin: 15px 0 8px; }
        .icon {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 21px;
        }
        .panel h2 { margin-top: 0; font-size: 18px; }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 20px; }
        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
        }
        .btn.secondary { background: #e2e8f0; color: #1e293b; }
        .footer { color: #94a3b8; font-size: 12px; margin-top: 28px; }
        @media (max-width: 850px) {
            .sidebar { width: 190px; }
            .main { margin-left: 190px; padding: 22px; }
            .cards { grid-template-columns: 1fr; }
        }
        @media (max-width: 560px) {
            .sidebar { position: static; width: 100%; }
            .tagline { margin-bottom: 18px; }
            .main { margin-left: 0; padding: 18px; }
            .topbar { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="brand">🏓 PINGPONG MANIA</div>
        <div class="tagline">Every Launch Makes You Better.</div>

        <div class="nav-label">Menu Utama</div>
        <a class="nav-link active" href="{{ route('admin.dashboard') }}">▦ Dashboard</a>
        <a class="nav-link" href="{{ route('admin.users') }}">♙ Manajemen Pengguna</a>
        <a class="nav-link" href="{{ route('training.history') }}">◷ Riwayat Latihan</a>

        <div class="nav-label">Pengguna</div>
        <a class="nav-link" href="{{ route('user.dashboard') }}">↗ Dashboard Pengguna</a>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h1>Dashboard Admin</h1>
                <div class="muted">Pantau pengguna dan kelola sistem latihan.</div>
            </div>
            <div class="profile">
                {{ auth()->user()->name }} · Admin
            </div>
        </div>

        <section class="cards">
            <div class="card">
                <div class="icon">♙</div>
                <div class="number">{{ $totalUsers }}</div>
                <div class="card-label">Total Pengguna</div>
            </div>

            <div class="card">
                <div class="icon">⚙</div>
                <div class="number">{{ $totalAdmins }}</div>
                <div class="card-label">Administrator</div>
            </div>

            <div class="card">
                <div class="icon">✓</div>
                <div class="number">{{ $totalMembers }}</div>
                <div class="card-label">Pengguna Biasa</div>
            </div>
        </section>

        <section class="panel">
            <h2>Selamat datang di PingPong Mania!</h2>
            <p class="muted">
                Kelola akun pengguna dan periksa aktivitas latihan
                melalui menu administrasi.
            </p>

            <div class="actions">
                <a class="btn" href="{{ route('admin.users') }}">
                    Kelola Pengguna
                </a>
                <a class="btn secondary" href="{{ route('training.history') }}">
                    Lihat Riwayat Latihan
                </a>
            </div>
        </section>

        <div class="footer">
            © {{ date('Y') }} PingPong Mania · Admin Panel
        </div>
    </main>
</body>
</html>
