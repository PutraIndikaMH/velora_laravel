<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Login</title>
  </head>

  <body>
    @include('template.nav')

    <main id="loginPage">
      <h1>Login</h1>
      <p class="subtitle">Siap untuk kembali? Silakan login!</p>
      @include('template.alert')
      <form method="POST" action="{{ route('login.process') }}">
         @csrf
        <input type="email" placeholder="Email" name="email"  value="{{ old('email') }}" required />
        <input type="password" placeholder="Password" name="password" required />
        <button type="submit" class="btn-login">Login</button>
      </form>
      <div class="bottom-text">
        Belum punya akun? Klik tombol di samping ini
        <a href="{{route('register')}}">Daftar</a>
      </div>
    </main>
  </body>
</html>
