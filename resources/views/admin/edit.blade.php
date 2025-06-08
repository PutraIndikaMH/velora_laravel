<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="\bootstrap-5.0.2-dist\css\bootstrap.min.css">
    <title>Edit Produk</title>
    <style>
        .form-container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

    <div class="container form-container">
        <h2 class="text-center">Edit Produk</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produk.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")

            <div class="mb-3">
                <label for="product_name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="product_name" name="product_name"
                    value="{{ old('product_name', $product->product_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="function" class="form-label">Fungsi</label>
                <input type="text" class="form-control" id="function" name="function"
                    value="{{ old('function', $product->function) }}" required>
            </div>

            <div class="mb-3">
                <label for="product_description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="product_description" name="product_description" rows="3" required>{{ old('product_description', $product->product_description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="skin_type" class="form-label">Tipe Wajah</label>
                <input type="text" class="form-control" id="skin_type" name="skin_type"
                    value="{{ old('skin_type', $product->skin_type) }}" required>
            </div>

            <div class="mb-3">
                <label for="product_price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="product_price" name="product_price"
                    value="{{ old('product_price', $product->product_price) }}" required>
            </div>

            <div class="mb-3">
                <label for="recommendation_links" class="form-label">Link Rekomendasi</label>
                <input type="url" class="form-control" id="recommendation_links" name="recommendation_links"
                    value="{{ old('recommendation_links', $product->recommendation_links) }}" required>
            </div>

            <div class="mb-3">
                <label for="image_name" class="form-label">Gambar Produk (Kosongkan jika tidak ingin mengubah)</label>
                <input type="file" class="form-control" id="image_name" name="image_name" accept="image/*">
                @if ($product->image_name)
                    <p class="mt-2">Gambar Saat Ini:</p>
                    <img src="{{ asset('gambar_produk/' . $product->image_name) }}" width="100" height="100"
                        alt="{{ $product->product_name }}">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="\bootstrap-5.0.2-dist\js\bootstrap.min.js"></script>
</body>

</html>
