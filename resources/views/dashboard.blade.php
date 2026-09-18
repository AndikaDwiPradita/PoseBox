<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - PoseBox</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  <link rel="stylesheet" href="{{ asset('_assets/dashboard/dashboard.css') }}">
</head>
<body>

<div class="nav">
  <div class="nav-inner">
    <div class="nav-left">
      <button id="hamburgerBtn" class="hamburger-btn">
        <span></span><span></span><span></span>
      </button>
      <a href="{{ route('photobooth') }}" class="brand">Pose<span style="font-weight: normal;">Box</span></a>
    </div>
    <div class="nav-right">
      @guest
        <a href="{{ route('login') }}" class="nav-btn login-btn">Login</a>
        <a href="{{ route('register') }}" class="nav-btn register-btn">Daftar</a>
      @endguest

      @auth
        <div class="user-info-nav" style="display:flex;align-items:center;gap:10px;">
          {{-- Klik foto profil → ke PROFILE --}}
          <a href="{{ route('profile') }}" style="text-decoration:none;">
            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar"
                 style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #fff;">
          </a>
          <a href="{{ route('profile') }}" style="text-decoration:none;color:inherit;font-weight:600;">
            {{ auth()->user()->name }}
          </a>
          <form action="{{ route('logout') }}" method="POST" style="display:inline;margin:0;">
            @csrf
            <button type="submit" class="nav-btn logout-btn">Logout</button>
          </form>
        </div>
      @endauth
    </div>
  </div>
</div>

<div id="sidebarOverlay" class="sidebar-overlay"></div>
<div id="sidebar" class="sidebar">
  <div class="sidebar-header">
    <h2>📸 PoseBox</h2>
    <button id="closeSidebar" class="close-sidebar">✕</button>
  </div>
  <div class="sidebar-user">
    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar">
    <div>
      <p>{{ auth()->user()->name }}</p>
      <span class="role-badge">{{ ucfirst(auth()->user()->role) }}</span>
    </div>
  </div>
  <nav class="sidebar-nav">
    <a href="{{ route('dashboard') }}" class="sidebar-link active"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
    <a href="{{ route('photobooth') }}" class="sidebar-link"><i class="fa-solid fa-camera"></i> Buat Strip</a>

    @if(auth()->user()->role === 'premium')
      <a href="#" class="sidebar-link"><i class="fa-solid fa-folder"></i> Strip Saya</a>
      <a href="#" class="sidebar-link"><i class="fa-solid fa-star"></i> Favorit</a>
      <a href="#" class="sidebar-link"><i class="fa-solid fa-gear"></i> Pengaturan</a>
    @endif

    @if(auth()->user()->role === 'free')
      <a href="#" class="sidebar-link"><i class="fa-solid fa-gem"></i> Upgrade Premium</a>
      <a href="#" class="sidebar-link"><i class="fa-solid fa-briefcase"></i> Upgrade Profesional</a>
    @endif

    @if(auth()->user()->role === 'professional')
      <a href="{{ route('custom-templates') }}" class="sidebar-link"><i class="fa-solid fa-palette"></i> Custom Template</a>
      <a href="#" class="sidebar-link"><i class="fa-solid fa-pen"></i> Custom Footer</a>
    @endif

    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
      @csrf
      <button type="submit" class="sidebar-link logout-link"
              style="background:none;border:none;width:100%;text-align:left;cursor:pointer;font:inherit;color:inherit;">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </button>
    </form>
  </nav>
</div>

<main>
  <div class="dashboard-content">
    <div class="profile-card">
      <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="avatar">
      <div class="info">
        <h2>{{ auth()->user()->name }}</h2>
        <p>{{ auth()->user()->email }}</p>
        <span class="badge badge-{{ auth()->user()->role }}">{{ ucfirst(auth()->user()->role) }}</span>
      </div>
    </div>

    <div class="stats-grid">
      <div class="stat-card"><div class="number">0</div><div class="label">Total Strip</div></div>
      <div class="stat-card"><div class="number">0</div><div class="label">Total Foto</div></div>
      <div class="stat-card"><div class="number">-</div><div class="label">Template Favorit</div></div>
    </div>

    <div class="action-buttons">
      <a href="{{ route('photobooth') }}" class="action-btn primary"><i class="fa-solid fa-camera"></i> Buat Strip</a>
      <a href="#" class="action-btn"><i class="fa-solid fa-folder"></i> Lihat Strip</a>
    </div>

    <div class="activity-section">
      <h3>🕐 Aktivitas Terbaru</h3>
      <div id="activityList"><p style="color:#999;text-align:center;padding:12px 0;">Belum ada aktivitas</p></div>
    </div>
  </div>
</main>

<script src="{{ asset('_assets/dashboard/dashboard.js') }}"></script>
</body>
</html> Aksi -->
    <div class="action-buttons">
      <a href="{{ route('photobooth') }}" class="action-btn primary"><i class="fa-solid fa-camera"></i> Buat Strip</a>
      <a href="#" class="action-btn"><i class="fa-solid fa-folder"></i> Lihat Strip</a>
    </div>

    <!-- Aktivitas -->
    <div class="activity-section">
      <h3>🕐 Aktivitas Terbaru</h3>
      <div id="activityList"><p style="color:#999;text-align:center;padding:12px 0;">Belum ada aktivitas</p></div>
    </div>
  </div>
</main>

<script src="{{ asset('script.js') }}"></script>
<script src="{{ asset('_assets/dashboard/dashboard.js') }}"></script>
</body>
</html>
