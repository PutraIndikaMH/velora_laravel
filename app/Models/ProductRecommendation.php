<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRecommendation extends Model
{
    use HasFactory;

    protected $table = 'product_recommendations';

    protected $fillable = [
         'history_id',
        'product_id',
    ];

    // Relasi ke History
    public function history()
    {
        return $this->belongsTo(History::class);
    }

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}