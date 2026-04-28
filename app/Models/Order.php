<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['tgl_order','karyawan_id','pelanggan_id','meja_id','total_harga','status'];

    // relasi ke detail
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // relasi ke karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    // relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // relasi ke meja
    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }
}