<!DOCTYPE html>
<html lang="id" class="page-about">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>About Us - Velora</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body class="page-about">
    @include('template.nav')

    <main id="aboutPage">
        <h2 class="judul">OUR STORY</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @include('template.alert')
        <section class="about-story row">
            <div class="col-left">
                <h3>
                    <span class="highlight">Aplikasi AI perawatan kulit wajah.</span>
                </h3>
                <p>
                    Dibangun dengan teknologi terbaru dan didukung oleh para ahli
                    dermatologi, Velora berkomitmen membantu Anda memahami kulit wajah
                    dan merawatnya secara tepat sehingga terhindar dari masalah kulit.
                </p>

                <a href="{{ route('scanning') }}" class="btn-scan">Scan Kulit Anda</a>
                <p class="disclaimer" style="font-size: small">
                    Tergantung pada konsultasi. Hasil dapat bervariasi.
                </p>
            </div>

            <div class="col-right">
                <img src="images/images.png" alt="Gambar AI Perawatan Kulit" />
            </div>
        </section>

        <section id="about-care-contact" class="about-care-contact">
            <div class="col-left">
                <div class="skin-care">
                    <h2>Perawatan untuk kulit wajah</h2>
                    <img src="images/skincare.png" alt="Perawatan Kulit Wajah" />
                    <p class="description">
                        <span class="highlight-light">Perawatan wajah yang tepat untuk semua jenis kulit.</span><br />
                        Kami menyediakan rekomendasi produk perawatan kulit yang
                        dipersonalisasi sesuai dengan kebutuhan dan kondisi kulit Anda,
                        mulai dari produk alami hingga perawatan medis yang terpercaya.
                        Selain itu, Velora menawarkan tips harian dan edukasi
                        seputar perawatan kulit yang mudah diaplikasikan, sehingga Anda
                        dapat menjaga kulit wajah tetap sehat, segar, dan terlindungi dari
                        berbagai gangguan.
                    </p>
                </div>
            </div>

            <div class="col-right">
                <div class="contact-us">
                    <h2>KONTAK KAMI</h2>
                    <form id="contactForm" action="{{ route('postFeedback') }}" method="post" novalidate>
                        @csrf
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required />

                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required />

                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="6" required></textarea>

                        <button type="submit" class="btn-submit">Submit</button>


                    </form>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Dropdown profil toggle
        const profileBtn = document.getElementById("profile-button");
        const profileMenu = document.getElementById("profile-menu");
        const dropdownLi = profileBtn.parentElement;

        profileBtn.addEventListener("click", () => {
            dropdownLi.classList.toggle("show");
        });

        // Close dropdown if click outside
        window.addEventListener("click", (e) => {
            if (!dropdownLi.contains(e.target)) {
                dropdownLi.classList.remove("show");
            }
        });

        // Dropdown Start Analyze button
        const startBtn = document.getElementById("startAnalyzeBtn");
        const analyzeDropdown = document.getElementById("analyzeDropdown");

        startBtn.addEventListener("click", () => {
            analyzeDropdown.classList.toggle("show");
            // Aria attribute for accessibility
            const expanded = startBtn.getAttribute("aria-expanded") === "true";
            startBtn.setAttribute("aria-expanded", !expanded);
        });
    </script>
</body>

</html>
