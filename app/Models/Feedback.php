<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional, Laravel otomatis menggunakan 'feedbacks')
    protected $table = 'feedback';

    // Atribut yang dapat diisi (fillable)
    protected $fillable = [
        'user_id',   // Kolom ini harus ada karena data ini yang akan disimpan
        'message',   // Pesan yang dikirim oleh pengguna
    ];

    // Mendefinisikan relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
