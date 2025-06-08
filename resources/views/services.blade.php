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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
$('#chatForm').on('submit', function(event) {
    event.preventDefault();
    var userMessage = $('#userBox').val().trim();

    if (!userMessage) {
        alert("Masukkan pesan sebelum mengirim.");
        return;
    }

    // Show loading indicator
    $('#chatBox').append(`<div class='bubble user'>${userMessage}</div>`);
    $('#chatBox').append(`<div class='bubble bot loading'>Sedang mengetik...</div>`);
    $('#userBox').val('');
    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);

    // Send to server
    $.ajax({
        url: '{{ route('chat.handle') }}',
        method: 'POST',
        data: {
            message: userMessage,
            _token: '{{ csrf_token() }}'
        },
        dataType: 'text',
        success: function(reply) {
            // Remove loading indicator
            $('.loading').remove();
            
            // Parse Markdown to HTML
            const htmlContent = marked.parse(reply);
            $('#chatBox').append(`<div class='bubble bot'>${htmlContent}</div>`);
            $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
        },
        error: function() {
            $('.loading').remove();
            $('#chatBox').append('<div class="bubble bot error">Maaf, terjadi kesalahan</div>');
            $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);
        }
    });
});
</script>

</body>

</html>
