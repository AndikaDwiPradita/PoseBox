
  document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const closeBtn = document.getElementById('closeSidebar');

    if (hamburger) {
      hamburger.addEventListener('click', function() {
        sidebar.classList.add('open');
        overlay.classList.add('active');
      });
    }

    if (closeBtn) {
      closeBtn.addEventListener('click', function() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
      });
    }

    if (overlay) {
      overlay.addEventListener('click', function() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
      });
    }
  });

// ==========================================
// DASHBOARD - AMBIL DATA USER & STATISTIK
// ==========================================

// Fungsi update dashboard
function updateDashboard() {
  const token = localStorage.getItem('token');
  const user = JSON.parse(localStorage.getItem('user') || 'null');
  const role = localStorage.getItem('role') || 'free';

  // ===== Profil =====
  const avatar = document.getElementById('profileAvatar');
  const name = document.getElementById('profileName');
  const email = document.getElementById('profileEmail');
  const badge = document.getElementById('profileBadge');

  if (token && user) {
    name.innerText = user.name || user.email.split('@')[0];
    email.innerText = user.email || 'guest@posebox.com';
    badge.innerText = role.charAt(0).toUpperCase() + role.slice(1);
    badge.className = 'badge badge-' + role;
    if (user.avatar) {
      avatar.src = user.avatar;
    }
  } else {
    // Tampilkan data default untuk guest
    name.innerText = 'Guest';
    email.innerText = 'guest@posebox.com';
    badge.innerText = 'Free';
    badge.className = 'badge badge-free';
 }

  // ===== Statistik =====
  // Ambil data dari localStorage (nanti bisa dari API)
  const strips = JSON.parse(localStorage.getItem('strips') || '[]');
  const totalStrips = strips.length;
  const totalPhotos = totalStrips * 3;

  document.getElementById('totalStrips').innerText = totalStrips;
  document.getElementById('totalPhotos').innerText = totalPhotos;

  // Template favorit (contoh)
  const favTemplate = localStorage.getItem('favTemplate') || 'Pink';
  document.getElementById('favTemplate').innerText = favTemplate;

  // ===== Aktivitas =====
  const activityList = document.getElementById('activityList');
  const activities = JSON.parse(localStorage.getItem('activities') || '[]');

  if (activities.length === 0) {
    activityList.innerHTML = '<p style="color: #999; text-align: center; padding: 12px 0;">Belum ada aktivitas</p>';
  } else {
    activityList.innerHTML = activities.map(act => `
      <div class="activity-item">
        <div class="icon">${act.icon || '📸'}</div>
        <div class="text">${act.text || 'Membuat strip baru'}</div>
        <div class="time">${act.time || 'Baru saja'}</div>
      </div>
    `).join('');
  }
}

// ==========================================
// JALANKAN SAAT HALAMAN DIMUAT
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
  updateDashboard();

  // Update sidebar juga (fungsi dari script.js)
  if (typeof updateSidebarUI === 'function') {
    updateSidebarUI();
  }
});

// ==========================================
// UPDATE NAVBAR BERDASARKAN STATUS LOGIN
// ==========================================
function updateNavbarUI() {
  const token = localStorage.getItem('token');
  const user = JSON.parse(localStorage.getItem('user') || 'null');

  const authSection = document.getElementById('authSection');
  const userSection = document.getElementById('userSection');
  const avatar = document.getElementById('navAvatar');

  if (token && user) {
    // Sudah login
    if (authSection) authSection.style.display = 'none';
    if (userSection) userSection.style.display = 'flex';

    // Update avatar (jika ada foto profil)
    if (user.avatar_url) {
      avatar.src = user.avatar_url;
    } else {
      avatar.src = 'assets/default-avatar.png';
    }
  } else {
    // Belum login
    if (authSection) authSection.style.display = 'flex';
    if (userSection) userSection.style.display = 'none';
  }
}

// ==========================================
// PANGGIL SAAT HALAMAN DIMUAT
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
  updateNavbarUI();

  // ... kode lain yang sudah ada
});