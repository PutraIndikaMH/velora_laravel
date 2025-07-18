<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'history_id',
        'user_id'
    ];

    public function history()
    {
        return $this->belongsTo(History::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultationChats()
    {
        return $this->hasMany(ConsultationChat::class);
    }
}