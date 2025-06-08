<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Feedback User</title>
    <link rel="stylesheet" href="/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <style>
        @font-face {
            font-family: "laila";
            src: url("/fonts/laila/Laila-Bold.ttf") format("truetype");
            font-weight: bold;
        }

        @font-face {
            font-family: "nunito";
            src: url("/fonts/nunito/Nunito-Regular.ttf") format("truetype");
            font-weight: normal;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "nunito", sans-serif;
            background: url("/images/background.png") no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #222;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .nav-link-button {
            padding: 8px 16px;
            margin-left: 10px;
            border-radius: 8px;
            font-weight: bold;
            text-transform: capitalize;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-link-button:hover {
            background-color: #ff4f98;
            color: #fff !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ff8fba;">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Admin Produk</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link active nav-link-button" href="{{ route('produk.index') }}">Kelola Produk</a>
                    <a class="nav-link active nav-link-button" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mt-5">

        <h3 class="mb-4 text-center">Daftar Feedback Pengguna</h3>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>ID Feedback</th>
                    <th>ID User</th>
                    <th>Nama User</th>
                    <th>Pesan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($feedback as $index => $item)
                    <tr>
                        <td>{{ $feedback->firstItem() + $index }}</td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->user_id }}</td>
                        <td>{{ $item->user->nama ?? 'Tidak diketahui' }}</td>
                        <td>{{ $item->message }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada feedback.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $feedback->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
