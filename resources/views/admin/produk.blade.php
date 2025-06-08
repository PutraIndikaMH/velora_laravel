<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <title>Daftar Produk</title>
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

        .table img {
            border-radius: 5px;
        }

        .table {
            margin-top: 20px;
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
                    <a class="nav-link active nav-link-button" href="{{ route('admin_feedback') }}">Lihat feedback</a>
                    <a class="nav-link active nav-link-button" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="mt-5">
        <h5 class="text-center">
            @if (Session::has('status'))
                <div><span style="color: red">{{ Session::get('status') }}</span></div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </h5>
    </div>

    <div class="container mt-3">
        <div class="row d-flex justify-content-between">
            <div class="col-8">
                <a href="{{ route('produk.create') }}" class="btn btn-success">Tambah</a>
            </div>
            <div class="col-4">
                <form class="d-flex" method="GET" action="{{ route('produk.index') }}">
                    <input class="form-control me-2" type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <i style="color: #888; font-size: small;">Search nama produk</i>
            </div>
        </div>
        <table class="table table-danger table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">ID</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Fungsi</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Tipe Wajah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Link</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $key => $product)
                    <tr>
                        <td>{{ $produk->firstItem() + $key }}</td> <!-- Menampilkan nomor urut -->
                        <td>{{ $product->id }}</td>
                        <td class="text-center">
                            <img src="{{ asset('gambar_produk/' . urlencode($product->image_name)) }}" width="100"
                                height="100" alt="{{ $product->product_name }}">
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->function }}</td>
                        <td>{{ $product->product_description }}</td>
                        <td>{{ $product->skin_type }}</td>
                        <td>Rp. {{ number_format($product->product_price, 0, ',', '.') }}</td>
                        <td><a href="{{ $product->recommendation_links }}" target="_blank">Link</a></td>
                        <td class="text-center">
                            <a href="{{ route('produk.edit', $product->id) }}" class="mb-2 btn btn-warning">Edit</a>
                            <form action="{{ route('produk.destroy', $product->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin akan hapus produk?')"
                                    class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($produk->count() === 0)
            <div class="alert alert-warning text-center" role="alert">
                Tidak ada produk yang tersedia saat ini.
            </div>
        @endif

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $produk->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <script src="/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>

</body>

</html>
