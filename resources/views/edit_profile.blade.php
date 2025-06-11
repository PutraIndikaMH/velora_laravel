<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/style.css" />
    <title>Edit Profil</title>
</head>

<style>
    .alert {
        position: absolute;
        padding: 10px;
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        top: 100px;
        margin-bottom: 15px;
    }

    .alert-success {
        background-color: #d4edda;
        /* Ganti warna untuk pesan sukses */
        color: #155724;
        border-color: #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        /* Ganti warna untuk pesan error */
        color: #721c24;
        border-color: #f5c6cb;
    }

    .alert ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .alert li {
        margin: 5px 0;
        /* Spacing between list items */
    }

    header {
        padding: 20px 20px;
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
</style>

<body>
    <header>
        <a href="/history">
            <img class="icon-btn" src="/icons/left-arrow-alt-svgrepo-com.svg" alt="" srcset="">
        </a>
    </header>

    <main class="register-page">
        <h1>Edit Profile</h1>
        <p class="subtitle">Please update your profile information below.:</p>

        <!-- Menampilkan alert pesan kesuksesan atau error -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('update_profile', $user->id) }}">
            @csrf

            <input type="text" name="nama" placeholder="Nama" value="{{ old('name', $user->nama) }}" required />

            <select name="jenis_kelamin" required>
                <option value="" disabled>Pilih Jenis Kelamin</option>
                <option value="pria" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'pria' ? 'selected' : '' }}>Pria
                </option>
                <option value="wanita" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'wanita' ? 'selected' : '' }}>
                    Wanita</option>
            </select>

            <input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}"
                required />

            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                required />

            <input type="password" name="password" placeholder="Password (Kosongkan jika tidak ingin mengubah)" />
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" />

            <button type="submit" class="btn-daftar">Update Profile</button>
        </form>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alertBox = document.querySelector('.alert'); // Select the alert box
            if (alertBox) {
                setTimeout(() => {
                    alertBox.style.transition = 'opacity 0.5s ease'; // Add fade-out transition
                    alertBox.style.opacity = '0'; // Set opacity to 0
                    setTimeout(() => {
                        alertBox.style.display = 'none'; // Hide alert after fade-out
                    }, 500); // Wait for the fade-out to complete
                }, 3000); // 3 seconds delay
            }
        });
    </script>

</body>

</html>
