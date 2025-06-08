<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // Dapatkan query pencarian dari input
        $search = $request->input('search');

        // Ambil produk, cari berdasarkan nama atau deskripsi
        $produk = Product::when($search, function ($query) use ($search) {
            return $query->where('product_name', 'like', '%' . $search . '%')
                ->orWhere('product_description', 'like', '%' . $search . '%');
        })->paginate(15);


        return view('admin.produk', compact('produk', 'search')); // Kirim produk dan search ke view

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_produk');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',                      // Nama produk
            'function' => 'required|string|max:255',                         // Fungsi produk
            'product_description' => 'required|string',                       // Deskripsi produk
            'skin_type' => 'required|string|max:255',                        // Tipe wajah
            'product_price' => 'required|numeric',                           // Harga produk
            'recommendation_links' => 'required|url',                        // Link rekomendasi
            'image_name' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi gambar
        ]);

        // Membuat instance produk baru
        $product = new Product();
        $product->product_name = $validatedData['product_name'];
        $product->function = $validatedData['function'];
        $product->product_description = $validatedData['product_description'];
        $product->skin_type = $validatedData['skin_type'];
        $product->product_price = $validatedData['product_price'];
        $product->recommendation_links = $validatedData['recommendation_links'];

        // Menyimpan gambar ke storage dan mendapatkan namanya
        if ($request->hasFile('image_name')) {
            $image = $request->file('image_name');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Membuat nama unik berbasis waktu
            $image->move(public_path('gambar_produk'), $imageName); // Memindahkan gambar ke folder yang diinginkan
            $product->product_image = $imageName; // Menyimpan nama file ke kolom produk
        }

        // Menyimpan produk ke database
        $product->save();

        // Mengalihkan pengguna kembali dengan pesan sukses
        return redirect()->route('produk.index')->with('status', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Mengambil data produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Mengembalikan view dengan data produk untuk diedit
        return view('admin.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'function' => 'required|string|max:255',
            'product_description' => 'required|string',
            'skin_type' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'recommendation_links' => 'required|url',
            'image_name' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi gambar, bisa kosong
        ]);

        // Mengambil data produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Memperbarui data produk
        $product->product_name = $validatedData['product_name'];
        $product->function = $validatedData['function'];
        $product->product_description = $validatedData['product_description'];
        $product->skin_type = $validatedData['skin_type'];
        $product->product_price = $validatedData['product_price'];
        $product->recommendation_links = $validatedData['recommendation_links'];

        // Memeriksa jika ada file gambar yang di-upload
        if ($request->hasFile('image_name')) {
            // Menghapus gambar yang lama jika ada
            if ($product->image_name) {
                $previousImagePath = public_path('gambar_produk/' . $product->product_image);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath); // Menghapus gambar lama
                }
            }

            // Menyimpan gambar baru
            $image = $request->file('image_name');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Membuat nama unik berbasis waktu
            $image->move(public_path('gambar_produk'), $imageName); // Memindahkan gambar ke folder yang diinginkan
            $product->product_image = $imageName; // Menyimpan nama file baru ke kolom produk
        }

        $product->save();

        return redirect()->route('produk.index')->with('status', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_name) {
            $imagePath = public_path('gambar_produk/' . $product->image_name);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Menghapus file gambar dari server
            }
        }

        $product->delete();

        // Mengalihkan kembali ke daftar produk dengan pesan sukses
        return redirect()->route('produk.index')->with('status', 'Produk berhasil dihapus.');
    }
}
