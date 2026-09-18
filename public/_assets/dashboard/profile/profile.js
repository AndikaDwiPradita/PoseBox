// ============================================================
// PROFILE.JS
// Koneksi ke Backend API
// ============================================================

const API_URL = 'http://localhost:3000/api';

// ============================================================
// CEK LOGIN
// ============================================================
const token = localStorage.getItem('token');
const user = JSON.parse(localStorage.getItem('user') || 'null');

if (!token || !user) {
  alert('Silakan login dulu!');
  window.location.href = 'loreg/login.html';
}

// ============================================================
// DOM REFS
// ============================================================
const form = document.getElementById('profileForm');
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const passConfirmInput = document.getElementById('password_confirmation');
const avatarImg = document.getElementById('avatarPreview');
const avatarInput = document.getElementById('avatarInput');
const avatarUploadBtn = document.getElementById('avatarUploadBtn');
const saveBtn = document.getElementById('saveBtn');
const messageDiv = document.getElementById('message');
const logoutBtn = document.getElementById('logoutBtn');

// ============================================================
// LOAD DATA USER
// ============================================================
async function loadUserProfile() {
  try {
    const response = await fetch(`${API_URL}/user/me`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });

    const data = await response.json();

    if (data.status === 'ok') {
      const userData = data.user;
      nameInput.value = userData?.name || '';
      emailInput.value = userData?.email || '';
      
      if (userData?.avatar_url) {
        avatarImg.src = 'assets/default-avatar.png';
      }
      
      localStorage.setItem('user', JSON.stringify(userData));
    } else {
      showMessage('Gagal memuat profil: ' + (data.message || 'Unknown error'), 'error');
    }
  } catch (error) {
    showMessage('Error: ' + error.message, 'error');
  }
}

// ============================================================
// UPDATE PROFILE
// ============================================================
async function updateProfile(data) {
  try {
    const response = await fetch(`${API_URL}/user/profile`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify(data)
    });

    const result = await response.json();

    if (result.status === 'ok') {
      localStorage.setItem('user', JSON.stringify(result.user));
      showMessage('✅ Profil berhasil diperbarui!', 'success');
      if (result.user.avatar_url) {
        avatarImg.src = `http://localhost:3000${result.user.avatar_url}`;
      }
    } else {
      showMessage('❌ ' + (result.message || 'Gagal update profil'), 'error');
    }
  } catch (error) {
    showMessage('Error: ' + error.message, 'error');
  }
}

// ============================================================
// UPLOAD AVATAR
// ============================================================
/* async function uploadAvatar(file) {
  const formData = new FormData();
  formData.append('avatar', file);

  try {
    const response = await fetch(`${API_URL}/user/avatar`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`
      },
      body: formData
    });

    const result = await response.json();

    if (response.status === 413) {
      showMessage('❌ File terlalu besar! Maksimal 5MB.', 'error');
      return;
    }

    if (result.status === 'ok') {
      // ... success handler
    } else {
      showMessage('❌ ' + (result.message || 'Gagal upload avatar'), 'error');
    }
  } catch (error) {
    showMessage('Error: ' + error.message, 'error');
  }
} */

// ============================================================
// SHOW MESSAGE
// ============================================================
function showMessage(msg, type = 'success') {
  messageDiv.textContent = msg;
  messageDiv.className = 'message ' + type;
  setTimeout(() => {
    messageDiv.className = 'message';
  }, 5000);
}

// ============================================================
// EVENT LISTENERS
// ============================================================

// Form Submit
form.addEventListener('submit', async (e) => {
  e.preventDefault();
  saveBtn.disabled = true;
  saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

  const name = nameInput.value.trim();
  const email = emailInput.value.trim();
  const password = passwordInput.value;
  const passConfirm = passConfirmInput.value;

  if (password && password.length < 6) {
    showMessage('Password minimal 6 karakter!', 'error');
    saveBtn.disabled = false;
    saveBtn.innerHTML = '<i class="fa-solid fa-save"></i> Simpan Perubahan';
    return;
  }

  if (password && password !== passConfirm) {
    showMessage('Password dan konfirmasi tidak sama!', 'error');
    saveBtn.disabled = false;
    saveBtn.innerHTML = '<i class="fa-solid fa-save"></i> Simpan Perubahan';
    return;
  }

  const data = {};
  if (name) data.name = name;
  if (email) data.email = email;
  if (password) data.password = password;

  await updateProfile(data);

  saveBtn.disabled = false;
  saveBtn.innerHTML = '<i class="fa-solid fa-save"></i> Simpan Perubahan';
});

// Upload Avatar
avatarUploadBtn.addEventListener('click', () => avatarInput.click());
avatarInput.addEventListener('change', (e) => {
  const file = e.target.files[0];
  if (!file) return;

  const allowed = ['image/jpeg', 'image/png', 'image/webp'];
  if (!allowed.includes(file.type)) {
    showMessage('Format file tidak didukung. Gunakan JPEG, PNG, atau WEBP.', 'error');
    avatarInput.value = '';
    return;
  }

  if (file.size > 10 * 1024 * 1024) {
    showMessage('Ukuran file maksimal 5MB.', 'error');
    avatarInput.value = '';
    return;
  }

  // Preview lokal
  const reader = new FileReader();
  reader.onload = (e) => {
    avatarImg.src = e.target.result;
  };
  reader.readAsDataURL(file);

  // Upload ke server
  uploadAvatar(file);
  avatarInput.value = '';
});

// Logout
logoutBtn.addEventListener('click', () => {
  if (confirm('Yakin mau logout?')) {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    window.location.href = 'loreg/login.html';
  }
});

// ============================================================
// DELETE AVATAR
// ============================================================
async function deleteAvatar() {
  if (!confirm('Yakin ingin menghapus foto profil?')) return;

  try {
    const response = await fetch(`${API_URL}/user/avatar`, {
      method: 'DELETE',
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });

    const result = await response.json();

    if (result.status === 'ok') {
      // Reset avatar ke default
      avatarImg.src = 'assets/default-avatar.png';

      // Update localStorage
      const userData = JSON.parse(localStorage.getItem('user') || '{}');
      delete userData.avatar_url;
      localStorage.setItem('user', JSON.stringify(userData));

      // Update navbar
      if (window.updateNavbarUI) {
        window.updateNavbarUI();
      }

      showMessage('✅ Foto profil berhasil dihapus!', 'success');
    } else {
      showMessage('❌ ' + (result.message || 'Gagal hapus foto'), 'error');
    }
  } catch (error) {
    showMessage('Error: ' + error.message, 'error');
  }
}

// ============================================================
// INIT
// ============================================================
loadUserProfile();