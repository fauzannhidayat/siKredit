<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'nama_lengkap',
        'pendapatan_per_bulan',
    ];

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }
}
