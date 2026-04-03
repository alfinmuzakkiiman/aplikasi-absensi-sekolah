<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nis',
        'classroom_id',
        'qr_code',
        'qr_image',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
