<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'message',
        'is_from_bot',
        'history_id'
    ];

    protected $casts = [
        'is_from_bot' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function history()
    {
        return $this->belongsTo(History::class);
    }
}