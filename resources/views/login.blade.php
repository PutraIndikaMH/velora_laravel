<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Login</title>
  </head>

  <body>
    <nav>
      <div class="logo">VELORA</div>
      <ul>
        <li><a href="{{route('home')}}">Home</a></li>
        <li><a href="{{route('scanning')}}">Scanning</a></li>
        <li><a href="{{route('services')}}">Services</a></li>
        <li><a href="{{route('about')}}">About Us</a></li>
        <a href="{{route('login')}}" class="login-btn login-active">Login</a>
      </ul>
    </nav>

    <main id="loginPage">
      <h1>Login</h1>
      <p class="subtitle">Siap untuk kembali? Silakan login!</p>
       @if ($errors->any())
        <div class="error-message">
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif
      <form method="POST" action="{{ route('login.process') }}">
         @csrf
        <input type="email" placeholder="Email"   value="{{ old('email') }}" required />
        <input type="password" placeholder="Password" required />
        <button type="submit" class="btn-login">Login</button>
      </form>
      <div class="bottom-text">
        Belum punya akun? Klik tombol di samping ini
        <a href="{{route('register')}}">Daftar</a>
      </div>
    </main>
  </body>
</html>
