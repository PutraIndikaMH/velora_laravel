<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="\bootstrap-5.0.2-dist\css\bootstrap.min.css">
    <title>Daftar Produk</title>
    <style>
        .table th, .table td {
            vertical-align: middle;
        }

        .table img {
            border-radius: 5px;
        }

        .table {
            margin-top: 20px;
        }
    </style>
</head>

<body>

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
        <a href="{{route('produk.create')}}" class="btn btn-success">Tambah</a>

        <table class="table table-warning table-striped table-bordered">
            <thead>
                <tr>
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
                @foreach ($produk as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td class="text-center">
                            <img src="{{ asset('gambar_produk/' . urlencode($product->image_name)) }}" width="100" height="100" alt="{{ $product->product_name }}">
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->function }}</td>
                        <td>{{ $product->product_description }}</td>
                        <td>{{ $product->skin_type }}</td>
                        <td>Rp. {{ number_format($product->product_price, 0, ',', '.') }}</td>
                        <td><a href="{{ $product->recommendation_links }}" target="_blank">Link</a></td>
                        <td class="text-center">
                            <a href="{{ route('produk.edit', $product->id) }}" class="mt- btn btn-info">Edit</a>
                            <a href="{{ route('produk.destroy', $product->id) }}" onclick="return confirm('Yakin akan hapus produk?')" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($produk->isEmpty())
        <div class="alert alert-warning text-center" role="alert">
            Tidak ada produk yang tersedia saat ini.
        </div>
        @endif
    </div>

    <script src="\bootstrap-5.0.2-dist\js\bootstrap.min.js"></script>
</body>

</html>
