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
        'product_name',
        'product_category',
        'product_description',
        'product_image',
        'recommendation_links',
        'product_price',
    ];

    public function history()
    {
        return $this->belongsTo(History::class);
    }
}
