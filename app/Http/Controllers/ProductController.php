<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function produk()
    {
        $produks = Product::all();
        return view('products.index', compact('produks'));
    }
}
