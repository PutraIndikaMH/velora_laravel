<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Scanning</title>
</head>

<body>
    <nav>
        <div class="logo">VELORA</div>
        <ul>
            <li><a href="{{route('home')}}">Home</a></li>
            <li class="active"><a href="{{route('scanning')}}">Scanning</a></li>
            <li><a href="{{route('services')}}">Services</a></li>
            <li><a href="{{route('about')}}">About Us</a></li>
            <li class="dropdown">
                <button class="dropdown-button" id="profile-button">Profil</button>
                <div class="dropdown-content" id="profile-menu">
                    <a href="history.html">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 5.5A6.5 6.5 0 1 0 18.5 12 6.508 6.508 0 0 0 12 5.5zM12 15a9 9 0 0 1-8.66-6.11l-1.85 1.15A11.986 11.986 0 0 0 12 17a11.986 11.986 0 0 0 10.51-5.96l-1.85-1.15A9 9 0 0 1 12 15zm0 4a1 1 0 1 0 1 1 1 1 0 0 0-1-1z" />
                        </svg>
                        History
                    </a>
                    <a href="#">
                        <svg viewBox="0 0 24 24">
                            <path d="M7 10v4h10v-4H7zm-4 8h18v2H3v-2zM3 4h18v2H3V4zm0 6h18v2H3v-2z" />
                        </svg>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <main id="scanning-page">
        <div class="scan-box" aria-label="Face scanning area">
            <svg class="camera-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path
                    d="M20 5h-3.17l-1.83-2H9L7.17 5H4a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zM12 17a5 5 0 1 1 0-10 5 5 0 0 1 0 10z">
                </path>
            </svg>
        </div>

        <div style="position: relative; width: max-content; margin: 0 auto;">
            <button id="startAnalyzeBtn" class="btn-drop" aria-haspopup="true" aria-expanded="false">
                Start Analyze
            </button>
            <div id="analyzeDropdown" class="dropdown-menu" role="menu" aria-label="Analyze options">
                <div tabindex="0" role="menuitem" id="chooseLib">Choose from library</div>
                <div tabindex="0" role="menuitem" id="takeSelfie">Take selfie</div>
            </div>
        </div>

        


        <section class="recommendation" aria-label="Analysis results and recommended products">
            <div class="title">Analysis Results: Dry Skin</div>

            <p>Recommended Products</p>

            <div class="product-item" tabindex="0" role="button"
                aria-label="Hydrating Cleanser from CleanCare, gentle daily cleanser for dry skin">
                <svg class="product-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M9 2v2h6V2H9zM17 4h-2v16h2V4zm-8 0h-2v16h2V4zM5 5H3v15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5h-2v12H5V5z" />
                </svg>
                <div class="product-info">
                    <h4>Hydrating Cleanser</h4>
                    <div class="brand">CleanCare</div>
                    <div class="price">Rp. xxx.xxx</div>
                    <div class="desc">Gentle daily cleanser for dry skin</div>
                </div>
                <div class="product-arrow">&#8594;</div>
            </div>

            <div class="product-item" tabindex="0" role="button"
                aria-label="Moisture Boost Serum from DermaCare, intensive hydrating serum with hyaluronic acid">
                <svg class="product-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M9 2v2h6V2H9zM17 4h-2v16h2V4zm-8 0h-2v16h2V4zM5 5H3v15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5h-2v12H5V5z" />
                </svg>
                <div class="product-info">
                    <h4>Moisture Boost Serum</h4>
                    <div class="brand">DermaCare</div>
                    <div class="price">Rp. xxx.xxx</div>
                    <div class="desc">Intensive hydrating serum with hyaluronic acid</div>
                </div>
                <div class="product-arrow">&#8594;</div>
            </div>

            <div class="product-item" tabindex="0" role="button"
                aria-label="Barrier Repair Cream from SkinHealth, rich moisturizer for dry skin repair">
                <svg class="product-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M17 2H7a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM7 20V4h10v16H7z" />
                </svg>
                <div class="product-info">
                    <h4>Barrier Repair Cream</h4>
                    <div class="brand">SkinHealth</div>
                    <div class="price">Rp. xxx.xxx</div>
                    <div class="desc">Rich moisturizer for dry skin repair</div>
                </div>
                <div class="product-arrow">&#8594;</div>
            </div>
        </section>

        <section class="chat-section" aria-label="Consultation chat bot">
            <p>Apakah anda memerlukan konsultasi lebih lanjut? Klik Chat bot dibawah ini</p>
            <a href="{{route('services')}}" class="chat-btn" aria-label="Chat Bot Button">Chat Bot</a>
            <div class="chat-feedback" aria-live="polite" aria-atomic="true">
                Kami ingin mendengar dari Anda! Klik tombol di samping ini untuk memberikan saran
               <a href="{{route('about')}}"> <img src="icons/feedback-svgrepo-com.svg" alt="Feedback Icon" class="feedback-icon" />  </a>
            </div>
        </section>


        <script>
            // Dropdown profil toggle
            const profileBtn = document.getElementById('profile-button');
            const profileMenu = document.getElementById('profile-menu');
            const dropdownLi = profileBtn.parentElement;

            profileBtn.addEventListener('click', () => {
                dropdownLi.classList.toggle('show');
            });

            // Close dropdown if click outside
            window.addEventListener('click', e => {
                if (!dropdownLi.contains(e.target)) {
                    dropdownLi.classList.remove('show');
                }
            });

            // Dropdown Start Analyze button
            const startBtn = document.getElementById('startAnalyzeBtn');
            const analyzeDropdown = document.getElementById('analyzeDropdown');

            startBtn.addEventListener('click', () => {
                analyzeDropdown.classList.toggle('show');
                // Aria attribute for accessibility
                const expanded = startBtn.getAttribute('aria-expanded') === 'true';
                startBtn.setAttribute('aria-expanded', !expanded);
            });

            // Close dropdown if click outside for analyze dropdown
            window.addEventListener('click', e => {
                if (!startBtn.contains(e.target) && !analyzeDropdown.contains(e.target)) {
                    analyzeDropdown.classList.remove('show');
                    startBtn.setAttribute('aria-expanded', false);
                }
            });

            // Dummy actions for analyze options
            document.getElementById('chooseLib').addEventListener('click', () => {
                alert('Fitur pilih foto dari perpustakaan akan dikembangkan.');
                analyzeDropdown.classList.remove('show');
                startBtn.setAttribute('aria-expanded', false);
            });
            document.getElementById('takeSelfie').addEventListener('click', () => {
                alert('Fitur selfie akan dikembangkan.');
                analyzeDropdown.classList.remove('show');
                startBtn.setAttribute('aria-expanded', false);
            });


        </script>


</body>

</html>
