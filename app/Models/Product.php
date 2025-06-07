<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_description',
        'recommendation_links',
        'product_price',
        'product_image',
        'skin_type',
        'function'
    ];

    public function histories()
    {
        return $this->belongsToMany(History::class, 'product_recommendations')
            ->withTimestamps();
    }

    public function getImageNameAttribute()
    {
        return basename($this->product_image);
    }
}
