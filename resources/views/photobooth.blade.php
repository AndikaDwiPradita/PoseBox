<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Pose Box</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('style.css') }}">
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
            <a href="{{ route('dashboard') }}" style="text-decoration:none;">
              <img src="{{ auth()->user()->avatar_url }}" alt="Avatar"
                   style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #fff;">
            </a>
            <a href="{{ route('dashboard') }}" style="text-decoration:none;color:inherit;font-weight:600;">
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
      <img src="{{ auth()->user()->avatar_url ?? asset('assets/default-avatar.png') }}" alt="Avatar">
      <div>
        <p>{{ auth()->user()->name ?? 'Guest' }}</p>
        <span class="role-badge">{{ ucfirst(auth()->user()->role ?? 'Free') }}</span>
      </div>
    </div>
    <nav class="sidebar-nav">
      <a href="{{ route('dashboard') }}" class="sidebar-link"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
      <a href="{{ route('photobooth') }}" class="sidebar-link active"><i class="fa-solid fa-camera"></i> Buat Strip</a>

      @if(auth()->check() && auth()->user()->role === 'premium')
        <a href="#" class="sidebar-link"><i class="fa-solid fa-folder"></i> Strip Saya</a>
        <a href="#" class="sidebar-link"><i class="fa-solid fa-star"></i> Favorit</a>
        <a href="#" class="sidebar-link"><i class="fa-solid fa-gear"></i> Pengaturan</a>
      @endif

      @if(auth()->check() && auth()->user()->role === 'free')
        <a href="#" class="sidebar-link"><i class="fa-solid fa-gem"></i> Upgrade Premium</a>
        <a href="#" class="sidebar-link"><i class="fa-solid fa-briefcase"></i> Upgrade Profesional</a>
      @endif

      @if(auth()->check() && auth()->user()->role === 'professional')
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
    <div class="content-wrapper">
      <div class="posebox">
        <h1>Jepretkan Momen Mu</h1>
        <section class="timer">
          <button id="s3" class="active"><i class="fa-solid fa-stopwatch"></i> 3s</button>
          <button id="s5"><i class="fa-solid fa-stopwatch"></i> 5s</button>
          <button id="s10"><i class="fa-solid fa-stopwatch"></i> 10s</button>
        </section>
        <section class="kamera">
          <div id="countdown">3</div>
          <video id="video" autoplay playsinline muted></video>
          <div class="tombol">
            <button onclick="settings()"><i class="fa-solid fa-gear"></i></button>
            <button onclick="takeFoto()"><i class="fa-solid fa-camera btn-camera"></i></button>
            <button onclick="gantiKamera()"><i class="fa-solid fa-camera-rotate"></i></button>
          </div>
        </section>
        <section class="fitur">
          <div class="button-fitur">
            <button onclick="openTemplatePopup()"><i class="fa-solid fa-border-all"></i><p>Template</p></button>
            <button onclick="openFilterPopup()"><i class="fa-solid fa-wand-magic-sparkles"></i><p>Efek</p></button>
            <button onclick="openTemaPopup()"><i class="fa-solid fa-palette"></i><p>Tema</p></button>
          </div>
        </section>
      </div>
    </div>

    <aside>
      <div class="aside-wrapper">
        <h1>Hasil Jepret</h1>
        <div class="upload-area" id="uploadArea">
          <i class="fa-solid fa-cloud-upload-alt"></i>
          <span>Upload Gambar</span>
          <input type="file" id="fileInput" accept="image/*" multiple>
        </div>
        <div class="photo-slots" id="photoSlots"></div>
        <div id="hasilStrip">
          <canvas id="resultCanvas"></canvas>
          <div class="preview-overlay" id="previewOverlay">
            <p>📸 Upload foto &amp; pilih template</p>
          </div>
        </div>
        <div class="download-actions">
          <button id="btnDownloadPNG" class="btn-download"><i class="fa-solid fa-download"></i> PNG</button>
          <button id="btnDownloadJPG" class="btn-download"><i class="fa-solid fa-file-image"></i> JPG</button>
        </div>
      </div>
    </aside>
  </main>

  <div id="templatePopup" class="popup">
    <div class="popup-content" style="width: 360px; max-width: 90vw;">
      <h2>Pilih Template</h2>
      <div id="templateGrid" class="template-grid"></div>
      <button onclick="closeTemplatePopup()" class="btn-close-popup">Tutup</button>
    </div>
  </div>

  <div id="settingsPopup" class="popup">
    <div class="popup-content">
      <h2>Settings</h2>
      <div class="setting-item"><span>Flash Kamera</span>
        <label class="switch"><input type="checkbox" id="flashToggle" checked><span class="slider"></span></label>
      </div>
      <div class="setting-item"><span>Suara Kamera</span>
        <label class="switch"><input type="checkbox" id="soundToggle" checked><span class="slider"></span></label>
      </div>
      <button onclick="document.getElementById('settingsPopup').style.display='none'" class="btn-close-popup">Tutup</button>
    </div>
  </div>

  <div id="filterPopup" class="popup">
    <div class="popup-content">
      <h2>Filter Kamera</h2>
      <div class="filter-list">
        <button onclick="setFilter('none')">Normal</button>
        <button onclick="setFilter('grayscale(1)')">Black & White</button>
        <button onclick="setFilter('sepia(1)')">Vintage</button>
        <button onclick="setFilter('contrast(1.2) saturate(1.3)')">Warm</button>
        <button onclick="setFilter('brightness(1.1) contrast(1.1)')">Bright</button>
        <button onclick="setFilter('blur(2px)')">Blur</button>
        <button onclick="setFilter('brightness(1.05) contrast(1.1) saturate(1.2) hue-rotate(-10deg)')">🌸 Soft Pink</button>
        <button onclick="setFilter('sepia(0.5) saturate(1.4) brightness(1.05)')">🌅 Warm Sunset</button>
        <button onclick="setFilter('brightness(1.02) contrast(1.05) saturate(1.1) hue-rotate(10deg)')">💙 Cool Blue</button>
        <button onclick="setFilter('sepia(0.6) contrast(1.2) brightness(0.95)')">📼 Vintage Warm</button>
        <button onclick="setFilter('contrast(1.4) brightness(1.05) saturate(1.2)')">⚡ High Contrast</button>
        <button onclick="setFilter('blur(1px) brightness(1.05) saturate(1.1)')">☁️ Dreamy</button>
      </div>
      <button onclick="document.getElementById('filterPopup').style.display='none'" class="btn-close-popup">Tutup</button>
    </div>
  </div>

  <div id="temaPopup" class="popup">
    <div class="popup-content">
      <h2>Pilih Tema Website</h2>
      <div class="tema-list">
        <button onclick="pilihTema('pink')">🌸 Pink (Default)</button>
        <button onclick="pilihTema('creammaroon')">🤎 Cream + Maroon</button>
      </div>
      <button onclick="document.getElementById('temaPopup').style.display='none'" class="btn-close-popup">Tutup</button>
    </div>
  </div>

  <div id="flash"></div>
  <audio id="shutter" src="{{ asset('camera.mp3') }}"></audio>
  <script src="{{ asset('script.js') }}"></script>
</body>
</html>lementById('filterPopup').style.display='none'" class="btn-close-popup">Tutup</button>
    </div>
  </div>

  <!-- ===== POPUP TEMA ===== -->
  <div id="temaPopup" class="popup">
    <div class="popup-content">
      <h2>Pilih Tema Website</h2>
      <div class="tema-list">
        <button onclick="pilihTema('pink')">🌸 Pink (Default)</button>
        <button onclick="pilihTema('creammaroon')">🤎 Cream + Maroon</button>
      </div>
      <button onclick="document.getElementById('temaPopup').style.display='none'" class="btn-close-popup">Tutup</button>
    </div>
  </div>

  <div id="flash"></div>
  <audio id="shutter" src="{{ asset('camera.mp3') }}"></audio>

  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
