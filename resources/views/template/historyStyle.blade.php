<style>
    @font-face {
        font-family: "laila";
        src: url("fonts/laila/Laila-Bold.ttf") format("truetype");
        font-weight: bold;
    }

    @font-face {
        font-family: "nunito";
        src: url("fonts/nunito/Nunito-Regular.ttf") format("truetype");
        font-weight: normal;
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: "nunito", sans-serif;
        background: url("images/background.png") no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        color: #222;
    }

    /* Header sederhana */
    header {
        padding: 15px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    header h1 {
        font-weight: 700;
        font-size: 24px;
        font-family: "laila";
    }

    /* Icon Back dan user */
    .icon-btn {
        cursor: pointer;
        width: 32px;
        height: 32px;
        fill: #000;
        flex-shrink: 0;
    }

    /* Container utama */
    main {
        flex-grow: 1;
        padding: 20px 30px;
        max-width: 900px;
        margin: 0 auto;
    }

    .subheading {
        font-size: 1.3rem;
        font-weight: 600;
        color: #df86ac;
        margin-bottom: 18px;
        font-family: "laila";
    }


    .message {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 40vh;
        text-align: center;
        font-size: 1.5rem;
        color: #333;
    }


    .history-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 18px;
         padding: 20px;
    }

    /* Card History */
    .history-card {
        background: rgba(151, 169, 205, 0.5);
        border-radius: 15px;
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        height: 240px;
        text-align: start
    }

    .history-card a {
        text-decoration: none;
    }

    .history-card .analysis-info:hover {
        background-color: #a3b2d6;
    }

    .avatar {
        width: 120px;
        height: 120px;
        border-radius: 16px;
        position: relative;
        flex-shrink: 0;
        left: 55px;
    }

    .hair1::before {
        content: "";
        position: absolute;
        top: 10px;
        left: 18px;
        width: 40px;
        height: 40px;
        background-color: #000;
        border-radius: 50% 50% 20% 50%;
    }


    .avatar::after {
        content: "";
        position: absolute;
        top: 30px;
        left: 22px;
        width: 10px;
        height: 10px;
        background: #bbb;
        border-radius: 50%;
        box-shadow: 26px 0 #bbb;
    }

    /* Text info card */
    .analysis-info {
        margin-top: 20px;
        background-color: #7a89b3;
        border-radius: 12px;
        padding: 8px 12px;
        width: 100%;
        font-size: 12px;
        font-weight: 600;
        color: #222;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    .analysis-text {
        max-width: 120px;
        white-space: nowrap;

        text-overflow: ellipsis;
    }

    .analysis-date {
        font-weight: 400;
        font-size: 10px;
        opacity: 0.8;
        text-align: start;
    }

    .arrow {
        font-weight: 700;
        font-size: 16px;
        margin-left: 6px;
        color: #222;
    }
</style>
