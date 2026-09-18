<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya · PoseBox</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('_assets/dashboard/profile/profile.css') }}">
</head>
<body>

  <!-- Navbar -->
  <header class="navbar">
    <div class="nav-inner">
      <a href="{{ route('photobooth') }}" class="brand">Pose<span>Box</span></a>
      <a href="{{ route('dashboard') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Dashboard</a>
    </div>
  </header>

  <main>
    <div class="profile-container">

      <div class="profile-header">
        <h1>👤 Profil Saya</h1>
        <p>Kelola data akunmu di sini</p>
      </div>

      <!-- Avatar Section -->
      <div class="avatar-section">
        <div class="avatar-wrapper">
          <img id="avatarPreview" src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="avatar-img">
          <label for="avatarInput" class="avatar-upload-btn">
            <i class="fa-solid fa-camera"></i>
          </label>
          <input type="file" id="avatarInput" accept="image/png,image/jpeg,image/webp" style="display:none;">
        </div>
        <p class="avatar-hint">Klik ikon kamera untuk upload foto baru</p>
      </div>

      <!-- Form Upload Avatar (hidden, auto-submit) -->
      <form id="avatarForm" action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" style="display:none;">
        @csrf
        <input type="file" name="avatar" id="avatarFileInput" accept="image/png,image/jpeg,image/webp">
      </form>

      <!-- Alert -->
      @if (session('success'))
        <div style="color:#27ae60;text-align:center;margin-bottom:10px;font-size:13px;">
          {{ session('success') }}
        </div>
      @endif
      @if ($errors->any())
        <div style="color:#e74c3c;text-align:center;margin-bottom:10px;font-size:13px;">
          {{ $errors->first() }}
        </div>
      @endif

      <!-- Form Profile -->
      <form id="profileForm" class="profile-form" action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="name">Nama Lengkap</label>
          <input type="text" id="name" name="name" placeholder="Nama kamu"
                 value="{{ old('name', auth()->user()->name) }}" required>
        </div>

        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Username"
                 value="{{ old('username', auth()->user()->username) }}" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Email kamu"
                 value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <div class="form-group">
          <label for="password">Password Baru (opsional)</label>
          <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin diubah">
          <small>Minimal 6 karakter</small>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Konfirmasi Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
        </div>

        <button type="submit" class="btn-save" id="saveBtn">
          <i class="fa-solid fa-save"></i> Simpan Perubahan
        </button>

        <button type="button" id="deleteAvatarBtn" class="btn-delete">
          <i class="fa-solid fa-trash"></i> Hapus Foto
        </button>

        <div id="message" class="message"></div>
      </form>

      <!-- Logout -->
      <div class="logout-section">
        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
          @csrf
          <button type="submit" class="btn-logout">
            <i class="fa-solid fa-sign-out-alt"></i> Logout
          </button>
        </form>
      </div>

    </div>
  </main>

  <!-- Script -->
  <script>
    // Handle upload avatar
    document.getElementById('avatarInput').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (!file) return;

      // Validasi ukuran (max 2MB)
      if (file.size > 10 * 1024 * 1024) {
        alert('Ukuran foto maksimal 10MB');
        return;
      }

      // Preview
      const reader = new FileReader();
      reader.onload = (ev) => {
        document.getElementById('avatarPreview').src = ev.target.result;
      };
      reader.readAsDataURL(file);

      // Pindahkan file ke form & submit
      const form = document.getElementById('avatarForm');
      const fileInput = document.getElementById('avatarFileInput');
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(file);
      fileInput.files = dataTransfer.files;
      form.submit();
    });

    // Handle hapus avatar
    document.getElementById('deleteAvatarBtn')?.addEventListener('click', function() {
      if (!confirm('Yakin ingin hapus foto profil?')) return;

      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '{{ route('profile.avatar.delete') }}';
      form.innerHTML = '@csrf @method("DELETE")';
      document.body.appendChild(form);
      form.submit();
    });
  </script>

</body>
</html>
