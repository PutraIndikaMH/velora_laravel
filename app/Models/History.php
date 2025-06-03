<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_path',
        'skin_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


     public function products()
    {
        return $this->belongsToMany(Product::class, 'product_recommendations')
                    ->withTimestamps();
    }
}
