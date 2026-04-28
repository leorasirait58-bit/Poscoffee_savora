<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    
    protected $fillable = ['nmmenu','jenis_id','harga','foto','deskripsi'];

public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'jenis_id');
    }
}
