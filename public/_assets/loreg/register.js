// ==========================================
// KONFIGURASI API BACKEND
// ==========================================
const API_URL = 'http://localhost:3000/api';

// ==========================================
// REGISTER FUNCTION
// ==========================================
async function registerUser(name, email, password) {
  try {
    const response = await fetch(`${API_URL}/auth/register`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name, email, password })
    });

    const data = await response.json();

    if (data.status === 'ok') {
      alert('Registrasi berhasil! Silakan login.');
      window.location.href = 'login.html';
      return true;
    } else {
      alert(data.message || 'Registrasi gagal!');
      return false;
    }
  } catch (error) {
    alert('Error: ' + error.message);
    return false;
  }
}

// ==========================================
// SUBMIT REGISTER FORM
// ==========================================
document.getElementById("registerForm").addEventListener("submit", function (event) {
  event.preventDefault();

  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const passwordConfirmation = document.getElementById("password_confirmation").value;

  if (!name || !email || !password) {
    alert("Semua field harus diisi!");
    return;
  }

  if (password !== passwordConfirmation) {
    alert("Password dan konfirmasi password tidak sama!");
    return;
  }

  if (password.length < 6) {
    alert("Password minimal 6 karakter!");
    return;
  }

  registerUser(name, email, password);
});

// ==========================================
// REDIRECT KE LOGIN
// ==========================================
document.querySelector('.login__register a').addEventListener("click", function(e) {
  e.preventDefault();
  window.location.href = "login.html";
});