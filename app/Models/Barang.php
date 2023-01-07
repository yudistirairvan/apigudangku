<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    /**
     * @var string
     */
    protected $table = 'barangs';

    /**
     * @var array
     */
    protected $fillable = [
        'kodebarang', 
        'namabarang',
        'satuan', 
        'hargabeli',
        'hargajual', 
        'jumlah',
        'deskripsi',
    ];
}