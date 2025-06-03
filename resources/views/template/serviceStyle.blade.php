<style>
    @font-face {
        font-family: 'laila';
        src: url('fonts/laila/Laila-Bold.ttf') format('truetype');
        font-weight: bold;
    }

    @font-face {
        font-family: 'nunito';
        src: url('fonts/nunito/Nunito-Regular.ttf') format('truetype');
        font-weight: normal;
    }


    html,
    body {
        height: 100vh;
        margin: 0;
        padding: 0;
    }


    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'nunito', sans-serif;
        background: url("images/background.png") no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        color: #222;
    }


    nav {
        background: #8997b0;
        padding: 15px 30px;
        display: flex;
        justify-content: end;
        align-items: center;
        font-family: 'laila';
        box-shadow: 0px 5px 12px 0px rgba(137, 151, 176, 0.78);
    }

    nav .logo {
        font-weight: bold;
        letter-spacing: 3px;
        font-size: 1.2rem;
        color: black;
        position: absolute;
        left: 40px;
        padding-top: 10px;
    }

    .logo img {
        height: 90px;

    }

    nav .logo {
        font-weight: bold;
        letter-spacing: 3px;
        font-size: 1.2rem;
        color: black;
    }

    nav ul {
        list-style: none;
        display: flex;
        gap: 25px;
        margin: 0;
        padding: 0;
        align-items: center;
    }

    nav ul li {
        font-weight: 600;
        cursor: pointer;
        color: #222;
    }

    nav ul li a {
        text-decoration: none;
        color: #222;
    }

    nav ul li a:hover {
        color: #F6F6E8;
    }

    nav ul li.active a,
    nav ul li.active a:hover {
        background: #d97da1;
        border-radius: 12px;
        color: white;
        padding: 5px 12px;
    }

    nav .login-btn {
        border-radius: 8px;
        border: none;
        padding: 6px 20px;
        background: #f4f1e7;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
        font-family: 'laila', 'Popins';

    }

    nav .login-btn:hover {
        background: #e3d5ca;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-button {
        border-radius: 8px;
        border: none;
        padding: 6px 20px;
        background: #f4f1e7;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
        font-family: 'laila', 'Popins';
        font-weight: 700;
        box-shadow: 0 3px 8px rgba(255 111 134 / 0.31);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .dropdown-button::after {
        content: '▼';
        font-size: 0.6rem;
        margin-left: 4px;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background: #f4f1e7;
        min-width: 180px;
        border-radius: 12px;
        padding: 8px 0;
        box-shadow: 0 3px 8px rgba(255 111 134 / 0.31);
        z-index: 100;
        font-weight: 600;
    }

    .dropdown-content a {
        display: flex;
        align-items: center;
        gap: 6px;
        color: black;
        text-decoration: none;
        font-size: 0.9rem;
        padding: 8px 22px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .dropdown-content a:hover {
        background: #f8a8bd;
    }

    .dropdown-content a svg {
        width: 16px;
        height: 16px;
        fill: black;
    }

    .dropdown.show .dropdown-content {
        display: block;
    }


    #chatBot_page {
        display: flex;
        flex-direction: column;
        max-width: 700px;
        height: 90vh;
        margin: 0 auto;
        padding: 25px 15px;
        gap: 10px;
        border: 1px solid #ccc;
        background-color: transparent;
    }

    /* Header dan subtitle tetap tinggi otomatis */
    .chat-header,
    .chat-subtitle,
    .icon-discord,
    .chat-input-container {
        flex-shrink: 0;
    }

    /* Bagian chatBox mengambil sisa ruang dan scroll */
    #chatBox {
        flex: 1 1 auto;
        overflow-y: auto;
        padding-right: 5px;
        /* agar scroll tidak menutupi teks */
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    /* optional scrollbar styling */
    #chatBox::-webkit-scrollbar {
        width: 6px;
    }

    #chatBox::-webkit-scrollbar-thumb {
        background: #c2c2c2;
        border-radius: 3px;
    }

    #chatBox::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Title text */
    .chat-header {
        text-align: center;
        font-size: 1.6rem;
        font-weight: 600;
        color: #111;
    }

    .chat-subtitle {
        text-align: center;
        font-weight: 500;
        color: #222;
    }

    /* Chat box container */
    .chat-box {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 15px;
        max-height: 500px;
        overflow-y: auto;
        padding: 0 10px;
        font-family: 'nunito';
    }

    /* Bubble styles */
    .bubble {
        max-width: 75%;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 0.9rem;
        line-height: 1.3;
        word-wrap: break-word;
        position: relative;
        display: inline-block;
    }

    .bot {
        background-color: #8a98bc;
        /* periwinkle */
        color: #1b2e50;
        align-self: flex-start;
        border-bottom-left-radius: 0;
    }

    .user {
        background-color: #f7a7b9;
        /* pink */
        color: #3a1a22;
        align-self: flex-end;
        border-bottom-right-radius: 0;
    }

    /* Scrollbar styling for chat box */
    .chat-box::-webkit-scrollbar {
        width: 6px;
    }

    .chat-box::-webkit-scrollbar-thumb {
        background: #c2c2c2;
        border-radius: 3px;
    }

    .chat-box::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Chat input container */
    .chat-input-container {
        padding: 0 10px 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    input[type="text"] {
        width: 100%;
        max-width: 700px;
        padding: 15px 20px;
        border: none;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 500;
        outline: none;
        background-color: #f7a7b9;
        color: #3a1a22;
        box-shadow: 0 3px 8px rgb(247 167 185 / 0.5);
        transition: box-shadow 0.3s ease;
        caret-color: #3a1a22;
    }

    input[type="text"]:focus {
        box-shadow: 0 0 10px #f7a7b9;
    }

    /* Discord icon */
    .icon-discord {
        width: 50px;
        height: 50px;
        margin: 0 auto 20px auto;
        display: block;
        filter: drop-shadow(0 0 3px #555);
    }

    .btn-submit {
        cursor: pointer;
        background: transparent;
        border: 0px;
    }

    .btn-input {
        width: 40px;
        height: 40px;

    }

    @media (max-width: 600px) {
        main {
            padding: 20px 10px;
            max-width: 100%;
        }

        .chat-box {
            max-height: 400px;
        }

        input[type="text"] {
            max-width: 100%;
        }
    }
</style>
