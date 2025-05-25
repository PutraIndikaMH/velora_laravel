<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/service.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Service</title>
</head>
@include('template.serviceStyle')

<body>
    @include('template.nav')

    <main id="chatBot_page">

        <div class="chat-header">Hello, Users!</div>
        <div class="chat-subtitle">How can I help you today?</div>
        <img class="icon-discord" src="icons/chatBot.png" alt="">
        <div class="chat-box" id="chatBox">
            <div class="bubble bot">Apakah ada hal khusus yang ingin kamu bahas?</div>
        </div>


        <form class="chat-input-container" id="chatForm" method="POST">
            @csrf
            <input type="text" id="userBox" name="message" placeholder="Type your message here..." />
            <button type="submit" class="btn-submit"><img src="icons/send-alt-1-svgrepo-com.svg" class="btn-input"
                    alt=""></button>
        </form>





    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>


        $('#chatForm').on('submit', function(event) {
            event.preventDefault();
            var userMessage = $('#userBox').val().trim();

            if (!userMessage) {
                alert("Masukkan pesan sebelum mengirim.");
                return;
            }


            // Tampilkan pesan user
            $('#chatBox').append(`<div class='bubble user'>${userMessage}</div>`);
            $('#userBox').val('');
            $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);

            // Kirim ke server
            $.ajax({
                url: '{{ route('chat.handle') }}',
                method: 'POST',
                data: {
                    message: userMessage,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'text',
                // Terima response sebagai text biasa
                success: function(reply) {
                    console.log(reply)
                    $('#chatBox').append(`<div class='bubble bot'>${reply}</div>`);
                    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
                },
                error: function() {
                    console.log("error")
                    $('#chatBox').append('<div class="bubble bot error">Maaf, terjadi kesalahan</div>');
                    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
                }
            });
        });
    </script>

</body>

</html>
