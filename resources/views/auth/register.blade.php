<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - PoseBox</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('style.css') }}" />
  <link rel="stylesheet" href="{{ asset('_assets/loreg/register.css') }}" />
</head>

<body>
  <div class="container">
    <form id="registerForm" action="{{ route('register') }}" method="POST">
      @csrf
      <h2>📸 Buat Akun</h2>

      @if ($errors->any())
        <div style="color:#e74c3c; text-align:center; margin-bottom:10px; font-size:12px;">
          <ul style="list-style:none; padding:0; margin:0;">
            @foreach ($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="userpass">
        <i class="fa-solid fa-user"></i>
        <input type="text" id="name" name="name" placeholder="Nama lengkap"
               value="{{ old('name') }}" required />
      </div>

      <div class="userpass">
        <i class="fa-solid fa-at"></i>
        <input type="text" id="username" name="username" placeholder="Username (huruf/angka)"
               value="{{ old('username') }}" required />
      </div>

      <div class="userpass">
        <i class="fa-solid fa-envelope"></i>
        <input type="email" id="email" name="email" placeholder="Email"
               value="{{ old('email') }}" required />
      </div>

      <div class="userpass">
        <i class="fa-solid fa-unlock"></i>
        <input type="password" id="password" name="password"
               placeholder="Password (min 8 karakter)" required />
      </div>

      <div class="userpass">
        <i class="fa-solid fa-lock"></i>
        <input type="password" id="password_confirmation" name="password_confirmation"
               placeholder="Konfirmasi Password" required />
      </div>

      <button type="submit" class="register__button">Daftar</button>

      <div class="login__register">
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
      </div>
    </form>

    <!-- Panda Face -->
    <div class="ear-l"></div>
    <div class="ear-r"></div>
    <div class="panda-face">
      <div class="blush-l"></div>
      <div class="blush-r"></div>
      <div class="eye-l"><div class="eyeball-l"></div></div>
      <div class="eye-r"><div class="eyeball-r"></div></div>
      <div class="nose"></div>
      <div class="mouth"></div>
    </div>
    <div class="hand-l"></div>
    <div class="hand-r"></div>
  </div>
</body>

</html>
