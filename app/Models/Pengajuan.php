<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuans';

    protected $fillable = [
        'customer_id',
        'tipe_pengajuan',
        'nominal_pengajuan',
        'tenor',
        'status',
        'catatan',
        'tagihan_per_bulan',
        'tanggal_pengajuan',
        'tanggal_persetujuan',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
