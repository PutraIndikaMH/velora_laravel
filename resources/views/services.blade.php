<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/service.css">
    <title>Service</title>
</head>

<body>
    <nav>
        <div class="logo">VELORA</div>
        <ul>
            <li><a href="{{route('home')}}">Home</a></li>
            <li><a href="{{route('scanning')}}">Scanning</a></li>
            <li class="active"><a href="{{route('services')}}">Services</a></li>
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

    <main id="chatBot_page">
        <div class="chat-header">Hello, Users!</div>
        <div class="chat-subtitle">How can I help you today?</div>

        <img class="icon-discord" src="icons/chatBot.png" alt="">

        <div class="chat-box" id="chatBox">
            <div class="bubble bot">Apakah ada hal khusus yang ingin kamu bahas?</div>
            <div class="bubble user">Kulitku sering perih kalau pakai skincare, kenapa ya?</div>
            <div class="bubble bot">Aku lihat kamu punya masalah kulit kering dan agak sensitif, ya? Yuk kita bahas
                pelan-pelan...</div>
            <div class="bubble user">Iya, kadang suka merah juga</div>
            <div class="bubble bot">Sebelum kita lanjut, aku mau tanya sedikit ya:
                <br>Kamu merasa kulitmu makin kering di pagi atau malam hari?
            </div>
            <div class="bubble user">Biasanya malam sih kak, apalagi kalau habis mandi.</div>
            <div class="bubble bot">Noted ya! Itu bisa jadi karena skin barrier kamu sedang lemah. Tapi jangan khawatir,
                ini masih bisa dibantu dengan perawatan yang tepat.</div>
        </div>

        <form class="chat-input-container">
            <input type="text" placeholder="type message here..."  />
            <button class="btn-submit"><img src="icons/send-alt-1-svgrepo-com.svg" class="btn-input" alt="" srcset=""></button>
        </form>
    </main>


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

        </script>

</body>

</html>
