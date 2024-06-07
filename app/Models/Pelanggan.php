<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pelanggan extends Model
{

    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = ['id_pengguna', 'jenis_pelanggan', 'tgl_berakhir_member', 'updated_at'];

    // Pelanggan Model
    public function pengguna()
    {
        return $this->hasOne(PenggunaOlahraga::class, 'id_pengguna', 'id_pengguna');
    }
}
