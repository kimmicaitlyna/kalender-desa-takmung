<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'judul', 
        'tanggalMulai', 
        'tanggalSelesai',
        'lokasi', 
        'keterangan', 
        'jenisPeserta',
        'jumlahPeserta', 
        'deskripsi'
    ];
}
