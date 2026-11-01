<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PingPong Mania')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        :root{--navy:#07182d;--blue:#1677f8;--pale:#f2f7ff;--ink:#12243b;--muted:#718096}
        *{box-sizing:border-box}body{font-family:Inter,Arial,sans-serif;background:#f3f7fc;color:var(--ink);font-size:14px}
        .topbar{height:68px;background:#fff;border-bottom:1px solid #e5edf6;display:flex;align-items:center;padding:0 28px;justify-content:space-between;position:sticky;top:0;z-index:20}
        .brand{font-size:19px;font-weight:800;color:var(--navy)!important;text-decoration:none}.brand-mark{display:inline-flex;background:var(--blue);color:white;border-radius:12px;width:34px;height:34px;align-items:center;justify-content:center;margin-right:9px}
        .navlinks{display:flex;align-items:center;gap:22px}.navlinks a{color:#42536a;font-weight:600;text-decoration:none}.navlinks a:hover,.navlinks a.active{color:var(--blue)}.user-pill{background:#eef5ff;padding:9px 13px;border-radius:12px;color:#154b9b!important}
        .app-shell{display:flex;min-height:calc(100vh - 68px)}.sidebar{width:220px;background:var(--navy);padding:25px 14px;color:#c5d3e5;flex-shrink:0}.side-label{text-transform:uppercase;font-size:10px;letter-spacing:1.4px;color:#6f87a7;padding:10px 13px}.side-link{display:flex;align-items:center;gap:12px;color:#b8c8dd;padding:12px 13px;border-radius:10px;margin:4px 0;text-decoration:none;font-weight:600}.side-link:hover,.side-link.active{background:var(--blue);color:#fff;text-decoration:none}.side-icon{width:20px;text-align:center}.side-bottom{margin-top:42px;border-top:1px solid #203752;padding-top:15px}.main-content{padding:30px;width:calc(100% - 220px);min-width:0}.eyebrow{color:var(--blue);font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1.4px}.page-title{font-size:28px;font-weight:800;margin:5px 0 4px}.muted{color:var(--muted)}.stat-card,.panel,.mode-card{background:#fff;border:1px solid #e4edf7;border-radius:17px;box-shadow:0 5px 20px rgba(24,59,98,.035)}.stat-card{padding:20px;height:100%}.stat-icon{width:43px;height:43px;border-radius:14px;display:flex;align-items:center;justify-content:center;background:#e8f2ff;color:var(--blue);font-size:20px}.stat-number{font-size:27px;font-weight:800;margin-top:13px}.stat-label{color:var(--muted);font-size:12px;font-weight:600}.panel{padding:22px}.panel-title{font-size:16px;font-weight:800;margin-bottom:17px}.mode-card{padding:20px;height:100%;transition:.15s}.mode-card:hover{border-color:#9bc4ff;transform:translateY(-2px)}.mode-symbol{width:44px;height:44px;border-radius:14px;background:#e9f3ff;color:#1677f8;display:flex;align-items:center;justify-content:center;font-size:21px;margin-bottom:15px}.form-control{border-color:#dfe8f3;border-radius:9px;height:43px;font-size:13px}.btn{border-radius:9px;font-weight:700;padding:10px 16px}.btn-primary{background:var(--blue);border-color:var(--blue)}.btn-danger{background:#e53e53;border-color:#e53e53}.btn-outline-primary{border-color:#c9dcf6}.control-status{display:inline-flex;align-items:center;gap:8px;border-radius:30px;padding:7px 11px;background:#edf2f7;color:#607086;font-size:12px;font-weight:700}.status-dot{width:8px;height:8px;border-radius:50%;background:#9aa9ba}.status-dot.running{background:#19b77b;box-shadow:0 0 0 4px #dcf8ed}.table thead th{border-top:0;color:#728198;text-transform:uppercase;font-size:10px;letter-spacing:.8px}.table td{vertical-align:middle;font-size:12px}.badge-soft{background:#e8f7f0;color:#13875c;padding:6px 9px;border-radius:20px}.hero-banner{border-radius:18px;padding:25px;background:linear-gradient(115deg,#07182d,#0e3e78);color:white;position:relative;overflow:hidden}.hero-banner:after{content:'🏓';position:absolute;font-size:100px;right:22px;top:5px;opacity:.18}.hero-banner h3{font-weight:800;position:relative;z-index:1}.hero-banner p,.hero-banner a{position:relative;z-index:1}.alert{border-radius:12px}.footer-note{font-size:11px;color:#8391a4;margin-top:25px}
        @media(max-width:800px){.topbar{padding:0 14px}.navlinks{gap:10px}.sidebar{width:65px;padding:20px 8px}.side-link{justify-content:center;padding:13px 5px;font-size:0}.side-icon{font-size:17px}.side-label{display:none}.main-content{width:calc(100% - 65px);padding:18px 12px}.page-title{font-size:23px}.brand{font-size:16px}.hide-mobile{display:none}}
    </style>
    @stack('styles')
</head>
<body>
<header class="topbar">
    <a class="brand" href="{{ url('/') }}"><span class="brand-mark">🏓</span>PingPong Mania</a>
    <nav class="navlinks">
        @auth
            <a class="hide-mobile {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">Dashboard</a>
            <a class="hide-mobile {{ request()->routeIs('training.history') ? 'active' : '' }}" href="{{ route('training.history') }}">Riwayat</a>
            <a class="user-pill" href="{{ route('profile.edit') }}">{{ Auth::user()->name }}</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Keluar</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
        @else
            <a href="{{ route('login') }}">Login</a><a class="user-pill" href="{{ route('register') }}">Daftar</a>
        @endauth
    </nav>
</header>
@auth
<div class="app-shell">
    <aside class="sidebar">
        <div class="side-label">Workspace</div>
        <a class="side-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}"><span class="side-icon">▦</span>Dashboard</a>
        <a class="side-link" href="{{ route('user.dashboard') }}#mode-latihan"><span class="side-icon">◎</span>Mode Latihan</a>
        <a class="side-link {{ request()->routeIs('training.history') ? 'active' : '' }}" href="{{ route('training.history') }}"><span class="side-icon">◷</span>Riwayat Latihan</a>
        <div class="side-bottom"><div class="side-label">Akun</div><a class="side-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}"><span class="side-icon">♙</span>Profil</a><a class="side-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span class="side-icon">↪</span>Logout</a></div>
    </aside>
    <main class="main-content">@yield('content')</main>
</div>
@else
    <main>@yield('content')</main>
@endauth
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
