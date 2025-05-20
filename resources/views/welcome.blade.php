<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Velora - Deteksi Kulit Wajah</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  </head>

  <body>
    <nav>
      <div class="logo">VELORA</div>
      <ul>
        <li class="active"><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('scanning') }}">Scanning</a></li>
        <li><a href="{{ route('services') }}">Services</a></li>
        <li><a href="{{ route('about') }}">About Us</a></li>
        <li><a href="{{ route('login') }}" class="login-btn">Login</a></li>
      </ul>
    </nav>

    <main>
      <section class="left-content">
        <h1>WELCOME TO VELORA</h1>
        <a href="#" class="subtitle">Temukan jenis kulitmu dalam sekejap!</a>
        <p>
          Kenali kebutuhan kulitmu hanya dengan satu kali scan.
          <b>Velora</b> menggunakan teknologi pemindaian wajah berbasis AI untuk
          menganalisis kondisi kulit secara cepat dan akurat -- mulai dari kulit
          kering, berminyak, acne prone, hingga sensitif.
        </p>
        <p class="highlight-italic">
          <b>personalisasi perawatanmu, Mulai dari Sini</b><br />
          Dapatkan rekomendasi produk dan tips perawatan sesuai jenis kulitmu,
          langsung dari hasil analisis wajah.
        </p>
        <p class="highlight-pink">
          Scan Wajahmu Sekarang --<br />
          Cantik Alami Dimulai dari Kulit Sehat
        </p>
        <button
          class="scan-btn"
          onclick="alert('Fitur scan akan dikembangkan.')"
        >
          Mulai Scan
        </button>
        <a href="{{ route('about') }}" class="learn-link">Pelajari Lebih Lanjut</a>
      </section>
      <section class="right-content">
        <img src="{{ asset('images/gambar_home.jpg') }}" alt="Wanita dengan perawatan kulit" />
      </section>
    </main>
  </body>
</html>
