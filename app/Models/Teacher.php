<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
    'kode_guru',
    'nama',
    'nip',
    'jenis_guru',
    'gmail',
    'alamat'
];


    // 🔥 Guru punya banyak sesi mengajar
    public function sessions()
    {
        return $this->hasMany(ClassSession::class);
    }
}
