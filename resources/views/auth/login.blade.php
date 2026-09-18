<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - PoseBox</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('style.css') }}" />
  <link rel="stylesheet" href="{{ asset('_assets/loreg/login.css') }}" />
</head>

<body>
  <div class="container">
    <form id="loginForm" action="{{ url('/login') }}" method="POST">
      @csrf

      @if (session('success'))
        <div style="color:#27ae60; text-align:center; margin-bottom:10px; font-size:13px;">
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div style="color:#e74c3c; text-align:center; margin-bottom:10px; font-size:13px;">
          {{ $errors->first() }}
        </div>
      @endif

      <div class="userpass">
        <i class="fa-solid fa-user"></i>
        <input type="text" name="login" id="username" placeholder="Username / Email"
               value="{{ old('login') }}" required autofocus />
      </div>
      <div class="userpass">
        <i class="fa-solid fa-unlock"></i>
        <input type="password" name="password" id="password" placeholder="Password" required />
      </div>

      <div class="login__check">
        <div class="login__check-box">
          <input type="checkbox" name="remember" class="login__check-input" id="user-check">
          <label for="user-check" class="login__check-label">Remember me</label>
        </div>
        <a href="#" class="login__forgot" id="forgotPassword">Forgot Password?</a>
      </div>

      <button type="submit" class="login__button">Login</button>

      <div class="login__register">
        Don't have an account? <a href="{{ route('register') }}" id="registerLink">Register</a>
      </div>
    </form>

    <!-- Panda design -->
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
    <div class="paw-l"></div>
    <div class="paw-r"></div>
  </div>
</body>
</html>
