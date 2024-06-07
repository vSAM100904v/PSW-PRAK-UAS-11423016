<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $table = 'pengelola_lapangan';
    protected $primaryKey = 'id_pengelola_lapangan';
    protected $fillable = ['id_pengguna', 'id_lokasi', 'tanggal_mulai', 'tanggal_selesai', 'status', 'keterangan','created_at','created_by','updated_at'];

    // Pelanggan Model
    public function pengguna()
    {
        return $this->hasOne(PenggunaOlahraga::class, 'id_pengguna', 'id_pengguna','id_lapangan');
    }
    
    // Pelanggan Model
    public function lapangan()
    {
        return $this->hasOne(Lokasi::class, 'id_lokasi','id_lokasi');
    }

}
