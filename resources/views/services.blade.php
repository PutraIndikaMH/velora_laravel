<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/service.css">
    <title>Service</title>
</head>

<body>
    @include('template.nav')

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
            <input type="text" placeholder="type message here..." />
            <button class="btn-submit"><img src="icons/send-alt-1-svgrepo-com.svg" class="btn-input" alt=""
                    srcset=""></button>
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
