<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * @var string
     */
    protected $table = 'images';

    /**
     * @var array
     */
    protected $fillable = [
        'barang_id', 
        'filepath',
        'kategori', 
        'keterangan',
    ];
}