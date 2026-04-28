<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meja extends Model
{
    protected $fillable = ['nomor','jumlah_kursi'];

    // relasi ke order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
