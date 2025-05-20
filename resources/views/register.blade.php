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
        <a href="{{route('login')}}" class="login-btn">Login</a>
      </ul>
    </nav>

    <main class="register-page">
      <h1>Daftar</h1>
      <p class="subtitle">Ayo, daftar hari ini dan raih manfaatnya!</p>
      <form  method="POST" action="{{ route('register.process') }}">
        @csrf
        <input type="text" name="nama" placeholder="Nama" value="{{ old('nama') }}" required />
        <select name="jenis_kelamin" required>
          <option value="" disabled selected>Jenis Kelamin</option>
          <option value="pria" {{ old('jenis_kelamin') == 'pria' ? 'selected' : '' }}>Pria</option>
          <option value="wanita" {{ old('jenis_kelamin') == 'wanita' ? 'selected' : '' }}>Wanita</option>
        </select>
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required />
        <input
          type="password"
          name="password"
          placeholder="Password"
          value="{{ old('password') }}"
          required
        />
        <input
          type="password"
          name="konfirmasi_password"
          placeholder="Konfirmasi Password"
          required
        />
        <button type="submit" class="btn-daftar">Daftar</button>
      </form>
    </main>
  </body>
</html>
